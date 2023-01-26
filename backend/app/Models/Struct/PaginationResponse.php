<?php

namespace App\Models\Struct;

class PaginationResponse
{
    public $page = "1";
    public $itemPerPage = "5";
    public $totalData = "0";
    public $totalPage = "0";
    public $orderBy = null;
    public $sortBy = null;

    public function __construct(PaginationPayload $payload = new PaginationPayload(), int $totalData = 0)
    {
        $this->fromJson($payload, $totalData);
    }

    public function fromJson(PaginationPayload $payload, string $totalData)
    {
        $intTotalData = (int)$totalData;
        $intItemPerPage = (int)$payload->itemPerPage;
        $logicTotalPage = strval(ceil($intTotalData / $intItemPerPage) - 1);

        $this->page = $payload->page;
        $this->itemPerPage = $payload->itemPerPage;
        $this->totalData = $totalData;
        $this->totalPage = $logicTotalPage <= 0 ? 1 : $logicTotalPage;
        $this->orderBy = $payload->orderBy;
        $this->sortBy = $payload->sortBy;
    }

    public function toJson()
    {
        return [
            'page' => $this->page,
            'itemPerPage' => $this->itemPerPage,
            'totalData' => $this->totalData,
            'totalPage' => $this->totalPage,
            'orderBy' => $this->orderBy,
            'sortBy' => $this->sortBy,
        ];
    }
}
