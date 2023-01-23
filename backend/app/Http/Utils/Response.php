<?php

namespace App\Http\Utils;

use App\Models\Struct\PaginationResponse;
use App\Models\Struct\ResponseFormatted;

trait Response
{
    public function responseData($data, $message = null, $pagination = null)
    {
        $responseFormat = new ResponseFormatted();
        if ($message != null) {
            $responseFormat->code = 200;
            $responseFormat->success = true;
            $responseFormat->message = $message;
            $responseFormat->data = $data;
            $responseFormat->error = [];
            $responseFormat->pagination = $pagination;
        } else {
            $responseFormat->code = 200;
            $responseFormat->success = true;
            $responseFormat->message = null;
            $responseFormat->data = $data;
            $responseFormat->error = [];
            $responseFormat->pagination = null;
        }
        return $responseFormat->toJson();
    }

    public function responseError($message = null, $code = 500, $listCodeError = [])
    {
        $responseFormat = new ResponseFormatted();
        if (count($listCodeError) == 0) {
            var_dump('DEVELOPER: List Code Error Di Controller Kosong Setidaknya Harus Satu Code Error Log :)');
            die;
        }
        if ($message != null) {
            $responseFormat->code = $code;
            $responseFormat->success = false;
            $responseFormat->message = $message;
            $responseFormat->data = null;
            $responseFormat->error = $listCodeError;
        } else {
            $responseFormat->code = $code;
            $responseFormat->success = false;
            $responseFormat->message = null;
            $responseFormat->data = null;
            $responseFormat->error = $listCodeError;
        }
        return $responseFormat->toJson();
    }


    public function responseValidation($topicValidasi = '', $validation = [])
    {
        $responseFormat = new ResponseFormatted();
        if (count($validation) == 0) {
            var_dump('DEVELOPER: Validation Error Kosong Setidaknya Harus Satu Validation Error Log :)');
            die;
        }
        if ($topicValidasi == '') {
            var_dump('DEVELOPER: Topic Validasi Kosong Harus Diisi di Validasi Log :)');
            die;
        }
        $responseFormat->code = 422;
        $responseFormat->success = false;
        $responseFormat->message = "Validasi: " . $topicValidasi;
        $responseFormat->data = null;
        $responseFormat->error = $validation;
        return $responseFormat->toJson();
    }

    public function responseDataNotFound($topicNotFound, $validation)
    {
        $responseFormat = new ResponseFormatted();
        if (count($validation) == 0) {
            var_dump('DEVELOPER: Validation Error Kosong Setidaknya Harus Satu Validation Error Log :)');
            die;
        }
        if ($topicNotFound == '') {
            var_dump('DEVELOPER: Topic Not Found Kosong Harus Diisi di Validasi Log :)');
            die;
        }
        $responseFormat->code = 400;
        $responseFormat->success = false;
        $responseFormat->message = "Error Data Not Found: " . $topicNotFound;
        $responseFormat->data = null;
        $responseFormat->error = $validation;
        return $responseFormat->toJson();
    }

    public function responsePageNotFound($pageName)
    {
        $responseFormat = new ResponseFormatted();
        $responseFormat->code = 400;
        $responseFormat->success = false;
        $responseFormat->message = "Page Not Found: Halaman " . $pageName . " Ini Tidak Ada";
        $responseFormat->data = null;
        $responseFormat->error = [
            $responseFormat->message
        ];
        return $responseFormat->toJson();
    }

    public function responseNotAuthenticated($topicNotAuthenticated, $validation)
    {
        $responseFormat = new ResponseFormatted();
        if (count($validation) == 0) {
            var_dump('DEVELOPER: Validation Error Kosong Setidaknya Harus Satu Validation Error Log :)');
            die;
        }
        $responseFormat->code = 401;
        $responseFormat->success = false;
        $responseFormat->message = "Error Not Authenticated: " . $topicNotAuthenticated;
        $responseFormat->data = null;
        $responseFormat->error = $validation;
        return $responseFormat->toJson();
    }
}
