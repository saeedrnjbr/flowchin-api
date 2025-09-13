<?php

namespace App\Http\Controllers;

use App\Models\Flow;
use App\Models\FlowNode;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;

class FlowController extends Controller
{

    public function index()
    {

        $rows = Flow::with('nodes.integration')->where("user_id", auth()->id())->paginate($this->perPage);

        return response()->success($rows);
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

                $meta = $node["data"]["meta"];

                array_push($flowNodes, [
                    "flow_id" => $row->id,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "integration_id" => $meta["id"],
                    "params" => !empty($node["data"]["params"]) ? json_encode($node["data"]["params"]) : "",
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


    public function update($id)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'pattern' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = request()->all();

        $row = Flow::where("unique_id", $id)->first();

        $row->update($data);

        $nodes = $data["pattern"]["nodes"];

        foreach ($nodes as $node) {

            $meta = $node["data"]["meta"];

            FlowNode::where([
                "flow_id" => $row->id,
                "integration_id" => $meta["id"],
            ])->update([
                "params" => !empty($node["data"]["params"]) ? json_encode($node["data"]["params"]) : ""
            ]);
        }

        $flow = Flow::find($row->id);

        return response()->success([$flow]);
    }
}
