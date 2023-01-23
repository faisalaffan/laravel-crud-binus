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
        $data = User::where('email', $request->input('email'))->with(['connection', 'pegawai', 'pegawai.cabang'])->first();

        // dd(json_decode($data));

        if ($data == null) {
            return null;
        }

        $matchPassword = $this->verifyBcyrptBetweenStringAndInputed($data['password'], $request->input('password'));

        if ($matchPassword) {
            $data = [
                "APIKey" => $data['connection']['APIKey'],
                "db_connection" => [
                    "host" => $data['connection']['host'],
                    "port" => $data['connection']['port'],
                    "database" => $data['connection']['database'],
                    "username" => $data['connection']['username'],
                    "password" => $data['connection']['password'],
                ],
                "rbac" => json_decode($data['rbac'], true),
                "user_info" => [
                    "id_user" => $data['id_user'],
                    "nama_lengkap" => $data['nama_lengkap'],
                    "email" => $data['email'],
                    "created_at" => $data['created_at'],
                    "updated_at" => $data['updated_at'],
                ],
                "pegawai_info" => $data['pegawai'] != null ? [
                    "id" => $data['pegawai']['id'],
                    "kodepegawai" => $data['pegawai']['kodepegawai'],
                    "emailpegawai" => $data['pegawai']['emailpegawai'],
                    "password" => $data['pegawai']['password'],
                    "namapegawai" => $data['pegawai']['namapegawai'],
                    "jabatanpegawai" => $data['pegawai']['jabatanpegawai'],
                    "alamatpegawai" => $data['pegawai']['alamatpegawai'],
                    "kotapegawai" => $data['pegawai']['kotapegawai'],
                    "notelppegawai" => $data['pegawai']['notelppegawai'],
                    "kode_cabang" => $data['pegawai']['kode_cabang'],
                    "cabang" => $data['pegawai']['cabang'],
                ] : null
            ];

            // Convert Payload Data Diatas Menjadi Token JWT dari UTILS
            $res = $this->dataToJWTToken($data);

            return $res;

            return null;
        }
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

    public function getlistrole(Request $request)
    {
        $data = Rbac::all();

        return $data;
    }

    public function getlistconnection(Request $request)
    {
        $data = Connection::all();

        return $data;
    }

    public function getlistconnectiondetail(Request $request, $id)
    {
        $data = Connection::where('id_db_connection', $id)->first();

        return $data;
    }

    public function register(Request $request)
    {
        //     if (!Auth::attempt($request->only('email', 'password'))) {
        //         return $this->response->response(401, true, 'Login Failed', null, 'Email or Password is wrong');
        //     }
        //     $data = User::where('email', $request->input('email'))->with('koperasi', 'role', 'koperasi.connection')->first();
        $data = [
            "nama" => "faisal",
            "kelas" => "XII"
        ];
        $res = $this->dataToJWTToken($data);

        return $res;
    }
}
