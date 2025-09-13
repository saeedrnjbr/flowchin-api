<?php

namespace App\Http\Controllers;

use App\Models\OtpCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login()
    {

        request()->merge(["mobile" => $this->convert2english(request("mobile"))]);

        $validator = Validator::make(request()->all(), [
            'mobile' => 'required|ir_mobile:zero',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $user = User::firstWhere("mobile", request("mobile"));

        $code =  mt_rand(11111, 99999);

        if (!isset($user->id)) {

            $user = new User();

            $user->mobile = request("mobile");

            $user->save();
        }

        if (Redis::get("user" . $user->id)) {
            return response()->error("کاربر گرامی دریافت کد تا دو دقیقه امکان پذیر نیست");
        }

        $otp = new OtpCode();

        $otp->code = $code;

        $otp->expired_at = Carbon::now()->addMinutes(2)->getTimestamp();

        $otp->user_id = $user->id;

        $otp->save();

        Redis::set("user" . $user->id, $code);
        Redis::expire("user" . $user->id, $otp->expired_at);

        return response()->success([
            [
                "code" => $code
            ]
        ]);
    }

    public function verify()
    {
        $validator = Validator::make(request()->all(), [
            'code' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }

        $otp = OtpCode::with("user")->firstWhere("code", request("code"));

        if (! isset($otp->id)) {
            return response()->error("کد وارد شده معتبر نمی‌باشد");
        }

        if ($otp->expired_at < Carbon::now()->getTimestamp()) {
            return response()->error("کد وارد شده منقضی شده است");
        }

        $otp->user->tokens()->delete();

        $token = $otp->user->createToken($otp->user->id);

        $otp->delete();

        Redis::del("user" . $otp->user->id);

        return response()->success([
            [
                "token" => $token->plainTextToken
            ]
        ]);
    }


    public function user()
    {
        return response()->success(auth()->user()->toArray());
    }

   
}
