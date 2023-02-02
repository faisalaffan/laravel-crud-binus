<?php

namespace App\Http\Modules\Staff;

use App\Http\Modules\Auth\EloquentAuthRepository;
use App\Http\Utils\Response;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EloquentStaffRepository implements StaffRepository
{
    use Response;
    protected $eloquentAuth;

    public function __construct(EloquentAuthRepository $eloquentAuthRepository)
    {
        $this->eloquentAuth = $eloquentAuthRepository;
    }

    public function create(Request $request)
    {
        $payload = [
            ...$request->all()
        ];
        DB::beginTransaction();
        try {
            // insert user
            $resAuth = $this->eloquentAuth->register($request);
            if (!$resAuth->getData()->success) {
                DB::rollBack();
                return $this->responseError("Berhasil Insert Staff", 500, $resAuth->getData()->error);
            }

            // insert staff
            Staff::insert([
                'nama' => $payload['nama_lengkap'],
                'jenis_kelamin' => $payload['jenis_kelamin'],
                'id_user' => $resAuth->getData()->data->id_user,
            ]);
            DB::commit();
            return $this->responseData($request->all(), "Berhasil Insert Staff");
        } catch (\Exception $e){
            DB::rollBack();
            return $this->responseError("Berhasil Insert Staff", 500, [$e->getMessage()]);
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
