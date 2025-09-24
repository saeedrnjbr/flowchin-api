<?php

namespace App\Http\Controllers;

use App\Helper\Uploader;
use App\Models\Flow;
use App\Models\FlowNode;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;

class FlowController extends Controller
{

    public function index()
    {
        $rows = Flow::with(['nodes.integration', 'workspace'])->where("user_id", auth()->id())->paginate($this->perPage);
        return response()->success($rows);
    }

    public function remove($unique_id)
    {

        $flow = Flow::where("unique_id", $unique_id)->first();

        if (!isset($flow->id)) {
            return response()->error("فرآیند مورد نظر یافت نشد");
        }

        \DB::beginTransaction();

        try {

            FlowNode::where("flow_id", $flow->id)->delete();

            $flow->delete();

            \DB::commit();

            return response()->success([
                [
                    "deleted" => true
                ]
            ]);
        } catch (Exception $e) {

            \DB::rollback();

            return response()->error("خطا در حذف اطلاعات فرآیند");
        }
    }


    public function store()
    {

        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'pattern' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = request()->all();

        $nodes = $data["pattern"]["nodes"];

        $data["unique_id"] = \Str::uuid();

        $data["pattern"] = json_encode($data["pattern"]);

        $data["user_id"] = auth()->id();

        \DB::beginTransaction();

        try {

            $row = Flow::create($data);

            $flowNodes = [];

            foreach ($nodes as $node) {

                array_push($flowNodes, [
                    "flow_id" => $row->id,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "integration_id" => $node["data"]["meta"],
                    "params" => !empty($node["data"]["params"]) ? json_encode($node["data"]["params"]) : ""
                ]);
            }

            FlowNode::insert($flowNodes);

            \DB::commit();

            return response()->success([$row]);
        } catch (Exception $e) {

            \DB::rollback();

            return response()->error("خطا در ذخیره اطلاعات فرآیند");
        }
    }

    public function nodes($unique_id)
    {

        $flows = Flow::select(["name", "pattern"])->where("unique_id", $unique_id)->get()->toArray();

        return response()->success($flows);
    }


    public function copy($unique_id)
    {

        $flow = Flow::with("nodes")->where("unique_id", $unique_id)->first();

        if (!isset($flow->id)) {
            return response()->error("فرآیند مورد نظر یافت نشد");
        }

        \DB::beginTransaction();

        try {

            $row = $flow->replicate();

            $row->unique_id = \Str::uuid();

            $row->save();

            if (!empty($flow->nodes)) {

                $flowNodes = [];

                foreach ($flow->nodes as $node) {
                    array_push($flowNodes, [
                        "flow_id" => $row->id,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now(),
                        "integration_id" => $node->integration_id,
                        "params" => $node->params
                    ]);
                }

                FlowNode::insert($flowNodes);
            }

            \DB::commit();

            return response()->success([$row]);
        } catch (Exception $e) {

            \DB::rollback();

            return response()->error("خطا در ذخیره اطلاعات فرآیند");
        }

        return response()->success($flows);
    }

    public function workspace($id)
    {

        $data = request()->all();

        $row = Flow::where("unique_id", $id)->first();

        if (!isset($row->id)) {
            return response()->error("فرآیند مورد نظر یافت نشد");
        }

        $row->update($data);

        return response()->success([$row]);
    }

    public function update($id)
    {

        $data = request()->all();

        $row = Flow::where("unique_id", $id)->first();

        if (!isset($row->id)) {
            return response()->error("فرآیند مورد نظر یافت نشد");
        }

        if (empty($data["has_marketplace"])) {
            $data["price"] = 0;
        }

        if (!empty($data["has_marketplace"]) && empty($data["price"])) {
            return response()->error("لطفا قیمت محصول مورد نظر را وارد نمایید");
        }

        if (!empty($data["discount"]) && $data["discount"] > 100) {
            return response()->error("درصد تخفیف نمی‌تواند از 100 درصد بیشتر باشد");
        }

        if (!empty($data["discount"]) && $data["discount"] < 0) {
            return response()->error("درصد تخفیف نمی‌تواند از صفر درصد کمتر باشد");
        }

        \DB::beginTransaction();

        try {

            if (!empty(request()->file("icon"))) {

                $validator = Validator::make(request()->all(), [
                    'icon' => 'max:1024|mimes:jpeg,png,jpg',
                ]);

                if ($validator->fails()) {
                    return response()->error($validator->errors()->first());
                }

                $data["icon"] = Uploader::_()->uploadImage($data["icon"]);
            }
            
            if (empty(request()->file("icon"))) {
                unset($data["icon"]);
            }

            $row->update($data);

            if (!empty($data["pattern"])) {

                $nodes = $data["pattern"]["nodes"];

                FlowNode::where(["flow_id" => $row->id])->delete();

                foreach ($nodes as $node) {

                    FlowNode::create([
                        "flow_id" => $row->id,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now(),
                        "integration_id" => $node["data"]["meta"],
                        "params" => !empty($node["data"]["params"]) ? json_encode($node["data"]["params"]) : ""
                    ]);
                }
            }

            \DB::commit();

            $flow = Flow::find($row->id);

            return response()->success([$flow]);
        } catch (Exception $e) {

            \DB::rollback();

            return response()->error("خطا در ذخیره اطلاعات فرآیند");
        }
    }
}
