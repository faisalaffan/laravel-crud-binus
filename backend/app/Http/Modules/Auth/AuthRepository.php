<?php

namespace App\Http\Modules\Auth;

use Illuminate\Http\Request;

interface AuthRepository
{
    public function login(Request $request);
    public function refreshToken(Request $request);
    public function register(Request $request);
    public function resetpassword(Request $request);
    public function getProfile(Request $request);
}
