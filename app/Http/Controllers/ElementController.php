<?php

namespace App\Http\Controllers;

use App\Helper\Uploader;
use App\Models\Element;
use Illuminate\Http\Request;

class ElementController extends Controller
{

    public function index()
    {

        $rows = Element::orderByRaw("id");

        if (!empty(request("name"))) {
            $rows->where("name", "like", "%" . request("name") . "%");
        }

        $rows = $rows->paginate($this->perPage);

        return view("admin.elements.index", compact("rows"));
    }


    public function create()
    {

        $elements = Element::all();

        return view("admin.elements.create", compact("elements"));
    }

    public function show($id)
    {

        $row = Element::find($id);

        return view("admin.elements.create", compact("id", "row"));
    }


    public function store()
    {

        request()->validate([
            'name' => 'required',
            'type' => 'required',
            'icon' => 'required',
        ]);

        $data = request()->all();

        if (!empty(request()->file("icon"))) {
            $data["icon"] = Uploader::_()->uploadImage($data["icon"]);
        }

        Element::create($data);

        return redirect()->route("elements.index");
    }



    public function update($id)
    {
        request()->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        $data = request()->all();

        if (!empty(request()->file("icon"))) {
            $data["icon"] = Uploader::_()->uploadImage($data["icon"]);
        } else {
            unset($data["icon"]);
        }

        $row = Element::find($id);

        $row->update($data);

        return redirect()->route("elements.index");
    }

    public function remove($id)
    {
        Element::find($id)->delete();

        return redirect()->route("elements.index");
    }

    public function elements()
    {

        $rows = Element::orderByRaw("id")->get()->toArray();

        return response()->success($rows);
    }
}
