<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Modules\Auth\EloquentAuthRepository;
use App\Http\Utils\Response;

class AuthController extends Controller
{
    use Response;

    protected $eloquentAuth;

    public function __construct(EloquentAuthRepository $eloquentAuth)
    {
        $this->eloquentAuth = $eloquentAuth;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->responseValidation('Error Saat Login', $validator->errors()->all());
        } else {
            // from eloquent auth repository
            $res = $this->eloquentAuth->login($request);

            if ($res == null) {
                return $this->responseNotAuthenticated('User Not Found', ['Email or Password is wrong']);
            } else {
                return $this->responseData($res, "Berhasil Login");
            }
        }
    }

    public function refreshToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->responseValidation('Token Required', $validator->errors()->all());
        } else {
            // from eloquent auth repository
            $res = $this->eloquentAuth->refreshToken($request);

            if ($res == null) {
                return $this->responseNotAuthenticated('User Not Found', ['Token is wrong']);
            } else {
                return $this->responseData($res, "Berhasil Refresh Token");
            }
        }
    }

    public function getprofile(Request $request)
    {
        return $this->eloquentAuth->getProfile($request);
    }
}
