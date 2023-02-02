<?php

namespace App\Http\Controllers;

use App\Http\Modules\Pembeli\EloquentPembeliRepository;
use App\Http\Utils\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembeliController extends Controller
{
    use Response;

    protected $eloquentPembeli;

    /**
     * @param EloquentPembeliRepository $eloquentPembeli
     */
    public function __construct(EloquentPembeliRepository $eloquentPembeli)
    {
        $this->eloquentPembeli = $eloquentPembeli;
    }

    public function registerpembeli(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ttl' => 'required|string',
            'jenis_kelamin' => 'required|integer',
            'alamat' => 'required|string',
            'ktp_url' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string|min:6',
            'rbac' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->responseValidation('Ada input yang salah di Field Barang', $validator->errors()->all());
        } else {
            return $this->eloquentPembeli->create($request);
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
