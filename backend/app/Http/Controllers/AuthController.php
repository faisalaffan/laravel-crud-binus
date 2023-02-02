<?php

namespace App\Http\Controllers;

use App\Http\Modules\Auth\EloquentAuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|min:10',
            'rbac' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->responseValidation('Error Saat Login', $validator->errors()->all());
        } else {
            // from eloquent auth repository
            $data = $this->eloquentAuth->register($request);
            if($data->getData()->success) {
                return $this->responseData($request->toArray(), 'Berhasil Insert');
            } else {
                return $this->responseError('Gagal Insert', 500, $data->getData()->error);
            }
        }
    }


    public function resetpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password_new' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return $this->responseValidation('Error Saat Login', $validator->errors()->all());
        } else {
            // from eloquent auth repository
            return $this->eloquentAuth->resetpassword($request);
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
