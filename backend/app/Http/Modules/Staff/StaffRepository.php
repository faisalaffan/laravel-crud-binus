<?php

namespace App\Http\Modules\Staff;

use Illuminate\Http\Request;

interface StaffRepository
{
    public function create(Request $request);
    public function read(Request $request);
    public function update(Request $request);
    public function delete(Request $request);
}
