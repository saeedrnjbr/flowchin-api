<?php

namespace App\Http\Controllers;

use App\Models\Flow;
use App\Models\Workspace;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WorkspaceController extends Controller
{

    public function index()
    {

        $rows = Workspace::with("flows")->where("user_id", auth()->id())->paginate($this->perPage);

        return response()->success($rows);
    }


    public function store()
    {

        $rules = [
            'name' => 'required',
        ];

        if (!empty(request("description"))) {
            $rules["description"] = "max:50";
        }

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = request()->all();

        $data["user_id"] = auth()->id();

        try {

            $row = Workspace::create($data);

            return response()->success([$row]);
        } catch (Exception $e) {
            return response()->error("خطا در ذخیره اطلاعات فرآیند");
        }
    }



    public function update($id)
    {

        $rules = [
            'name' => 'required',
        ];

        if (!empty(request("description"))) {
            $rules["description"] = "max:50";
        }

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = request()->all();

        $data["user_id"] = auth()->id();

        $row = Workspace::find($id);

        if (!isset($row->id)) {
            return response()->error("پوشه مورد نظر یافت نشد");
        }

        try {
            $row->update($data);
        } catch (Exception $e) {
            return response()->error("خطا در ذخیره اطلاعات فرآیند");
        }

        return response()->success([$row]);
    }

    public function remove($id)
    {

        $row = Workspace::find($id);

        if (!isset($row->id)) {
            return response()->error("پوشه مورد نظر یافت نشد");
        }

        DB::beginTransaction();

        try {


            Flow::where("workspace_id", $row->id)->update([
                "workspace_id" => 0
            ]);

            $row->delete();

            DB::commit();

            return response()->success([
                [
                    "deleted" => true
                ]
            ]);
        } catch (Exception $e) {

            DB::rollback();

            return response()->error("خطا در حذف اطلاعات پوشه‌ها");
        }
    }
}
