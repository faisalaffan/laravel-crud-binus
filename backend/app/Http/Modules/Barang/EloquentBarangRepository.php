<?php

namespace App\Http\Modules\Barang;

use App\Http\Controllers\ResponseApi;
use App\Http\Utils\Response;
use App\Models\Barang;
use App\Models\Pembeli;
use App\Models\Rbac;
use App\Models\Connection;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EloquentBarangRepository implements BarangRepository
{
    use Response;

    public function create(Request $request)
    {
        $payload = [
            ...$request->all()
        ];
        DB::beginTransaction();
        try {
            $barang = new Barang();
            $barang->nama_barang = $payload['nama_barang'];
            $barang->deskripsi = $payload['deskripsi'];
            $barang->jenis_barang = $payload['jenis_barang'];
            $barang->stock_barang = $payload['stock_barang'];
            $barang->harga_beli = $payload['harga_beli'];
            $barang->harga_jual = $payload['harga_jual'];
            $barang->gambar_url = $payload['gambar_url'];
            $barang->save();
            DB::commit();
            return $this->responseData($request->all(), "Berhasil Insert Barang");
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseError("Berhasil Insert Barang", 500, [$e->getMessage()]);
        }
    }

    public function read(Request $request)
    {
        // TODO: Implement read() method.
    }

    public function update(Request $request)
    {
        // TODO: Implement update() method.
    }

    public function delete(Request $request)
    {
        // TODO: Implement delete() method.
    }
}
