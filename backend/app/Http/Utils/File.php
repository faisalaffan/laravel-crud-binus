<?php

namespace App\Http\Utils;

use Barryvdh\DomPDF\Facade\Pdf;

trait File
{

    public function saveToS3()
    {
    }

    public function getFromS3()
    {
    }

    public function saveMultipleFile()
    {
    }

    public function getFromLocalAsset()
    {
    }

    public function saveToLocalAsset($file = null, $upload_path = null, $nameFile = null)
    {
        // constructor
        if ($upload_path == null) {
            $upload_path = '/assets/images/gallery/';
        }

        // Upload File
        $base64string = '';
        $uploadpath   = $_SERVER['DOCUMENT_ROOT'] . $upload_path;
        $parts        = explode(";base64,", $file);
        $imageparts   = explode("image/", @$parts[0]);
        $imagetype    = $imageparts[1];
        $imagebase64  = base64_decode($parts[1]);
        $file         = $uploadpath . $nameFile . '.png';
        file_put_contents($file, $imagebase64);

        // RETURN PATH UNTUK DISIMPAN DI DB
        return $upload_path . $nameFile . '.png';
    }

    /**
     * Html To Pdf
     * @param array $data
     * @param string $fileName
     * @param string $view
     * @return \Illuminate\Http\Response|bool
     */
    public function htmlFileToPdf($data = [], $fileName = '', $view = '')
    {
        if (count($data) == 0) {
            return false;
        }

        $pdf = Pdf::loadView($view, $data);
        return $pdf->download($fileName);
    }

    /**
     * Html To Base64
     * @param array $data
     * @param string $fileName
     * @param string $view
     * @return \Illuminate\Http\Response|string
     */
    public function htmlFileToBase64($data = [], $fileName = '', $view = '')
    {
        if (count($data) == 0) {
            return false;
        }

        $pdf = Pdf::loadView($view, $data);
        return base64_encode($pdf->output());
    }
}
