<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthController;
use App\Http\Utils\Response;
use App\Http\Modules\Auth\EloquentAuthRepository;
use Closure;
use App\Http\Utils\Connection as Conn;
use Illuminate\Support\Facades\Config;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Http\Utils\Authorization;

class Auth
{
    use Conn;
    use Response;
    use Authorization;

    protected $eloquentAuth;

    public function __construct(EloquentAuthRepository $eloquentAuth)
    {
        $this->eloquentAuth = $eloquentAuth;
    }

    public function handle($request, Closure $next)
    {
        if ($request->header('authorization') == null || $request->header('authorization') == "") {
            return $this->responseNotAuthenticated('Token Belum Disertakan', [
                'Token Belum Disertakan',
                'Login Ulang',
                'Clear Cache Browser'
            ]);
        }

        $data = $this->eloquentAuth->getProfile($request);
        $data = json_decode($data->content());

        // set user data di request
        $request->headers->set('user_login', json_encode($data));

        $payload = [
            "code" => $data->code,
            "success" => $data->success,
            "message" => $data->message,
            "data" => $data->data,
            "error" => $data->error
        ];

        if ($payload['code'] == 401) {
            return $this->responseNotAuthenticated($payload['message'], $payload['error']);
        }

        return $next($request);
    }
}
