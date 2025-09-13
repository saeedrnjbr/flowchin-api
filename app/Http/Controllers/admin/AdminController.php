<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return redirect()->route("dashboard");
        }


        return view("admin.login");
    }

    public function auth()
    {

        request()->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = Admin::whereUsername(request("username"))->first();

        if (!isset($user->id)) {
            return redirect()->route("login")->withErrors(["msg" => __("errors.invalidUser")]);
        }

        if (!Hash::check(request("password"), $user->password)) {
            return redirect()->route("login")->withErrors(["msg" => __("errors.invalidPassword")]);
        }

        auth()->login($user);

        return redirect()->route("dashboard");
    }
}
