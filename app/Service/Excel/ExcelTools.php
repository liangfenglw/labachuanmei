<?php
namespace App\Service\Excel;

use App\Service\Excel\PHPExcel;
use App\Service\Excel\PHPExcel\PHPExcel_IOFactory;

class ExcelTools
{
    public static function excelFilePic($file)
    {
        $ext = fileExtension($file);
        if ($ext == 'xls') {
            $reader = PHPExcel_IOFactory::createReader('Excel5');
        } else {
            $reader = new \PHPExcel_Reader_Excel2007();
        }
        $excelFile = $reader->load('./'.$file);
        $worksheet = $excelFile->getActiveSheet();
        $basePath = generateStroagePath();
        return $result = self::extractImageFromWorksheet($worksheet, $basePath); 
    }

    public static function extractImageFromWorksheet($worksheet,$basePath){  
        $result = array();  
        $imageFileName = "";  
        foreach ($worksheet->getDrawingCollection() as $drawing) {  
            $xy = $drawing->getCoordinates();
            $path = $basePath . md5(date('YmdHis').str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT)). '.' . fileExtension($drawing->getIndexedFilename());
            if ($drawing instanceof \PHPExcel_Worksheet_Drawing) {  
                $filename = $drawing->getPath();  
                $imageFileName = $drawing->getIndexedFilename();  
                copy($filename, $path);
                $result[$xy] = substr($path, strlen(public_path()));
                // for xls  
            } else if ($drawing instanceof \PHPExcel_Worksheet_MemoryDrawing) {  
                $image = $drawing->getImageResource();  
                $renderingFunction = $drawing->getRenderingFunction();  
                switch ($renderingFunction) {  
                    case \PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG:  
                        $imageFileName = $drawing->getIndexedFilename();  
                        imagejpeg($image, $path);  
                        break;  
                    case \PHPExcel_Worksheet_MemoryDrawing::RENDERING_GIF:  
                        $imageFileName = $drawing->getIndexedFilename();  
                        imagegif($image, $path);  
                        break;  
                    case \PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG:  
                        $imageFileName = $drawing->getIndexedFilename();  
                        imagegif($image, $path);  
                        break;  
                    case \PHPExcel_Worksheet_MemoryDrawing::RENDERING_DEFAULT:  
                        $imageFileName = $drawing->getIndexedFilename();  
                        imagegif($image, $path);  
                        break;  
                }  
                $imageFileName = substr($imageFileName, strlen(public_path()));
                $result[$xy] = $imageFileName;  
            } 
            $cell = $worksheet->getCell($xy);
            $cell->setValue($result[$xy]);
        }  
        return $result;  
    } 
}
