<?php

namespace App\Http\Modules\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Utils\Response;
use App\Http\Utils\Authorization;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();
        try {
            $user = new User();
            $user->nama_lengkap = $payload['nama_lengkap'];
            $user->email = $payload['email'];
            $user->password = $payload['password'];
            $user->rbac = $payload['rbac'];
            $user->save();
            DB::commit();
            return $this->responseData($user, "Berhasil Insert Data");
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseError("Berhasil Insert Data", 500, [$e->getMessage()]);
        }
    }
}
