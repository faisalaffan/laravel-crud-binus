<?php

namespace App\Models\Struct;

use Illuminate\Http\Request;

class PaginationPayload
{
    public $page = "1";
    public $itemPerPage = "5";
    public $query = [];
    public $orderBy = null;
    public $sortBy = 'ASC';

    public function getTake()
    {
        return $this->itemPerPage;
    }

    public function getSkip()
    {
        return $this->page == 1 ? 0 : $this->page * $this->itemPerPage;
    }

    public function fromJson(Request $request)
    {
        $this->page = $request->input('page');
        $this->itemPerPage = $request->input('item');
        $this->orderBy = $request->input('orderBy');
        $this->sortBy = $request->input('sortBy');
    }
}
