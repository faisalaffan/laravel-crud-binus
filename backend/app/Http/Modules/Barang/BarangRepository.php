<?php

namespace App\Http\Modules\Barang;

use Illuminate\Http\Request;

interface BarangRepository
{
    public function create(Request $request);
    public function read(Request $request);
    public function update(Request $request);
    public function delete(Request $request);
}
