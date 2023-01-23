<?php

namespace App\Http\Utils;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ResponseApi;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Http\Utils\Response;
use Error;

trait Authorization
{
    // Dari String Ke BCRYPT
    public function stringToBcrypt($string)
    {
        $hash = password_hash($string, PASSWORD_DEFAULT);
        return $hash;
    }

    // Verify Antara Password Di Database Dan Password Yang Di Input
    public function verifyBcyrptBetweenStringAndInputed($databasePassword, $inputedPasswordString)
    {
        if (password_verify($inputedPasswordString, $databasePassword)) {
            return true;
        } else {
            return false;
        }
    }

    // Mostly Digunakan Untuk GET PROFILE (TOKEN -> PAYLOAD DATA)
    public function jwtTokenToData($token)
    {
        $key = env("SECRET_KEY");
        $token = $token;
        if ($token == null) {
            return $this->responseNotAuthenticated('Token Not Valid', [
                'Coba Login Ulang'
            ]);
        }

        if ($key == null) {
            var_dump('DEVELOPER: SECRET KEY DI ENV BELUM DIISI :)');
            die;
        }

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $response = [
                'status' => 'token valid',
                'user_info' => $decoded->data
            ];
            return $this->responseData($response, 'Berhasil Get Profile');
        } catch (\Firebase\JWT\ExpiredException $e) {
            return $this->responseNotAuthenticated($e->getMessage(), [$e->getMessage()]);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            return $this->responseNotAuthenticated($e->getMessage(), [$e->getMessage()]);
        } catch (\InvalidArgumentException $e) {
            // 500 internal server error
            // your fault
            return $this->responseNotAuthenticated($e->getMessage(), [$e->getMessage()]);
        } catch (\Exception $e) {
            // 401 unauthorized
            // clients fault
            return $this->responseNotAuthenticated($e->getMessage(), [$e->getMessage()]);
        }
    }

    public function jwtTokenRefresh($token)
    {
        $key = env("SECRET_KEY");
        $token = $token;
        if ($token == null) {
            return $this->responseNotAuthenticated('Token Not Valid', [
                'Coba Login Ulang'
            ]);
        }

        if ($key == null) {
            var_dump('DEVELOPER: SECRET KEY DI ENV BELUM DIISI :)');
            die;
        }

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $payload = json_decode(json_encode($decoded->data), true);
            $refresh_token = $this->dataToJWTToken($payload);
            $response = [
                'status' => 'token valid',
                'refresh_token' => $refresh_token['access_token'],
            ];
            // dd($response);
            return $response;
        } catch (\Firebase\JWT\ExpiredException $e) {
            JWT::$leeway = 720000;
            $payload = $this->jwtTokenToData($token)->original['data'];
            $data = $this->dataToJWTToken($payload);
            return $data;
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            return $this->responseNotAuthenticated($e->getMessage(), [$e->getMessage()]);
        } catch (\InvalidArgumentException $e) {
            // 500 internal server error
            // your fault
            return $this->responseNotAuthenticated($e->getMessage(), [$e->getMessage()]);
        } catch (\Exception $e) {
            // 401 unauthorized
            // clients fault
            return $this->responseNotAuthenticated($e->getMessage(), [$e->getMessage()]);
        }
    }

    // Mostly Digunakan Untuk LOGIN (PAYLOAD DATA -> TOKEN)
    public function dataToJWTToken($data)
    {
        $data = $data;
        $now_seconds = time();
        $key = env("SECRET_KEY");
        $payload = array(
            "iss" => env("JWT_ISSUER"),
            "aud" => env("JWT_ISSUER"),
            "iat" => $now_seconds,
            "exp" => $now_seconds + (60 * env("JWT_EXPIRE_IN")),
            // "exp" => $now_seconds + 1,
            "data" => $data
        );
        $jwt = JWT::encode($payload, $key, 'HS256');

        $res = [
            'access_token' => $jwt,
            'status' => 'token valid',
            'payload' => $data,
        ];

        return $res;
    }

    /**
     * @param Request $request
     * @return Request
     */
    public function getLoggedInUser(Request $request)
    {
        return json_decode($request->header('user_login'))->data->user_info;
    }

    public function loginOAUTHGoogle()
    {
    }
}
