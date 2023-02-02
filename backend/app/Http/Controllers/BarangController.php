<?php

namespace App\Http\Controllers;

use App\Http\Modules\Barang\EloquentBarangRepository;
use App\Http\Modules\Staff\EloquentStaffRepository;
use App\Http\Utils\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    use Response;

    protected $eloquentBarang;

    /**
     * @param EloquentBarangRepository $eloquentBarang
     */
    public function __construct(EloquentBarangRepository $eloquentBarang)
    {
        $this->eloquentBarang = $eloquentBarang;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string',
            'deskripsi' => 'required|string',
            'jenis_barang' => 'required|string',
            'stock_barang' => 'required|integer',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'gambar_url' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->responseValidation('Ada input yang salah di Field Barang', $validator->errors()->all());
        } else {
            return $this->eloquentBarang->create($request);
        }
    }

    public function read()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

}
