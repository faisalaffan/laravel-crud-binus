<?php

namespace App\Models\Struct;

class ResponseFormatted
{
    public $code;
    public $success;
    public $message;
    public $data;
    public $error;
    public $pagination;

    public function __construct()
    {
        $this->code = 200;
        $this->success = true;
        $this->message = null;
        $this->data = null;
        $this->error = [];
        $this->pagination = null;
    }

    public function toJson()
    {
        return response()->json([
            'code' => $this->code,
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'error' => $this->error,
            'pagination' => $this->pagination,
        ], $this->code);
    }
}
