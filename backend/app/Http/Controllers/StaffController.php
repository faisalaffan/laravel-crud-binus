<?php

namespace App\Http\Controllers;

use App\Http\Modules\Staff\EloquentStaffRepository;
use App\Http\Utils\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    use Response;

    protected $eloquentStaff;

    /**
     * @param EloquentStaffRepository $eloquentStaff
     */
    public function __construct(EloquentStaffRepository $eloquentStaff)
    {
        $this->eloquentStaff = $eloquentStaff;
    }

    public function registerstaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'jenis_kelamin' => 'required|integer',
            'email' => 'required|string',
            'password' => 'required|string|min:6',
            'rbac' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->responseValidation('Ada input yang salah di Field Barang', $validator->errors()->all());
        } else {
            return $this->eloquentStaff->create($request);
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
