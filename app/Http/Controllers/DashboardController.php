<?php

namespace App\Http\Controllers;

use App\Helper\Uploader;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view("admin.dashboard");
    }

    public function uploads()
    {

        $response = [];

        if (!empty(request()->file("file"))) {
            $response["file"] = Uploader::_()->uploadImage(request("file"));
        }

        $response["file_url"] = implode("/uploads/", [url("/"), $response["file"]]);

        return response()->success([$response]);
    }
}
