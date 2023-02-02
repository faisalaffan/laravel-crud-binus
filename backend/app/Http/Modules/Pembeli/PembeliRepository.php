<?php

namespace App\Http\Modules\Pembeli;

use Illuminate\Http\Request;

interface PembeliRepository
{
    public function create(Request $request);
    public function read(Request $request);
    public function update(Request $request);
    public function delete(Request $request);
}
