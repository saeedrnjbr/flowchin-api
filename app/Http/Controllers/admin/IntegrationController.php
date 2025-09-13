<?php

namespace App\Http\Controllers\admin;

use App\Helper\Uploader;
use App\Models\Integration;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class IntegrationController extends Controller
{

    public function index()
    {

        $rows = Integration::with("parent")->orderByRaw("id");
        
        if(!empty(request("name"))){
            $rows->where("name", "like", "%". request("name")."%");
        }

        $rows = $rows->paginate($this->perPage);

        return view("admin.integrations.index", compact("rows"));
    }


    public function create()
    {

        $integrations = Integration::all();

        return view("admin.integrations.create", compact("integrations"));
    }

    public function show($id)
    {

        $integrations = Integration::all();

        $row = Integration::find($id);

        return view("admin.integrations.create", compact("id", "integrations", "row"));
    }


    public function store()
    {

         request()->validate([
            'name' => 'required',
            'description' => 'required',
            'icon' => 'required',
        ]);

        $data = request()->all();

        if (!empty(request()->file("icon"))) {
            $data["icon"] = Uploader::_()->uploadImage($data["icon"]);
        }

        Integration::create($data);

        return redirect()->route("integrations.index");
    }



    public function update($id)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $data = request()->all();

        if (!empty(request()->file("icon"))) {
            $data["icon"] = Uploader::_()->uploadImage($data["icon"]);
        }else{
            unset($data["icon"]);
        }

        $row = Integration::find($id);

        $row->update($data);

        return redirect()->route("integrations.index");
    }

    public function remove($id)
    {
        Integration::find($id)->delete();

        return redirect()->route("integrations.index");
    }

    public function integrations()
    {
        $trees = Integration::with("parent")->orderByRaw("id")->get()->toArray();
        return response()->success($this->buildTree($trees));
    }
}
