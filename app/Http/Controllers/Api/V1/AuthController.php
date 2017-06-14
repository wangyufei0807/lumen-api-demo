<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends BaseController
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $credentials = $request->only('email', 'password');
        // 验证失败返回403
        if (! $token = \Auth::attempt($credentials)) {
            $this->response->errorUnauthorized(trans('auth.incorrect'));
        }
        $result['data'] = [
            'token' => $token,
            'expired_at' => Carbon::now()->addMinutes(config('jwt.ttl'))->toDateTimeString(),
            'refresh_expired_at' => Carbon::now()->addMinutes(config('jwt.refresh_ttl'))->toDateTimeString(),
        ];

        return $this->response->array($result)->setStatusCode(201);
    }

    public function update()
    {
        $token = $this->auth->getToken();
        $newtoken = $this->auth->refresh($token);

        $result['data'] = [
            'token' => $newtoken,
            'expired_at' => Carbon::now()->addMinutes(config('jwt.ttl'))->toDateTimeString(),
            'refresh_expired_at' => Carbon::now()->addMinutes(config('jwt.refresh_ttl'))->toDateTimeString(),
        ];
        return $this->response->array($result);
    }

}