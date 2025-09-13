<?php

namespace App\Http\Controllers;

use App\Models\Integration;

class IntegrationController extends Controller
{

    public function index()
    {
        $trees = Integration::with("parent")->orderByRaw("id")->get()->toArray();
        return response()->success($this->buildTree($trees));
    }

}
