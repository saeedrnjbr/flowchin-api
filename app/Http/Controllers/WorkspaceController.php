<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Support\Facades\Validator;

class WorkspaceController extends Controller
{
    
    public function index()
    {

        $rows = Workspace::where("user_id", auth()->id())->paginate($this->perPage);

        return response()->success($rows);
    }


    public function store()
    {

        $validator = Validator::make(request()->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = request()->all();

        $data["user_id"] = auth()->id();

        $row = Workspace::create($data);

        return response()->success([$row]);
    }



    public function update($id)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $data = request()->all();

        $data["user_id"] = auth()->id();

        $row = Workspace::find($id)->update($data);

        return response()->success([$row]);
    }

    public function remove($id)
    {

        Workspace::find($id)->delete();

        return response()->success([
            [
                "deleted" => true
            ]
        ]);
    }
}
