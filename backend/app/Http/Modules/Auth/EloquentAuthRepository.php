<?php

namespace App\Http\Modules\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ResponseApi;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Http\Utils\Response;
use App\Http\Utils\Authorization;
use App\Models\Rbac;
use Error;
use App\Models\Connection;

class EloquentAuthRepository implements AuthRepository
{
    use Response;
    use Authorization;

    public function login(Request $request)
    {
        $data = User::where('email', $request->input('email'))->first();

        // dd(json_decode($data));

        if ($data == null) {
            return null;
        }

        $matchPassword = $this->verifyBcyrptBetweenStringAndInputed($data['password'], $request->input('password'));

        if ($matchPassword) {

            // Convert Payload Data Diatas Menjadi Token JWT dari UTILS
            $res = $this->dataToJWTToken($data);

            return $res;
        }
        return null;
    }

    public function refreshToken(Request $request)
    {
        $key = env("SECRET_KEY");
        $token = explode(" ", $request->header('Authorization'))[1];
        if ($token == null) {
            return $this->responseNotAuthenticated('Token Not Valid', [
                'Coba Login Ulang'
            ]);
        } else {
            $res = $this->jwtTokenRefresh($token);
            return $res;
        }
    }

    public function getProfile(Request $request)
    {
        $key = env("SECRET_KEY");
        $token = explode(" ", $request->header('Authorization'))[1];
        if ($token == null) {
            return $this->responseNotAuthenticated('Token Not Valid', [
                'Coba Login Ulang'
            ]);
        } else {
            $res = $this->jwtTokenToData($token);
            return $res;
        }
    }

    public function resetpassword(Request $request)
    {
        $data = User::where('email', $request->input('email'))->update([
            'password' => $this->stringToBcrypt($request->input('password_new'))
        ]);


        return $this->responseData($request->toArray(), 'Berhasil Update');
    }

    public function register(Request $request)
    {
        $payload = [
            ...$request->all(),
            'password' => $this->stringToBcrypt($request->input('password'))
        ];

        $data = User::insert([
            'nama_lengkap' => $payload['nama_lengkap'],
            'email' => $payload['email'],
            'password' => $payload['password'],
            'rbac' => $payload['rbac'],
        ]);


        return $this->responseData($request->toArray(), 'Berhasil Insert');
    }
}
