<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SampleFileController extends Controller
{
    public function createStudentSample()
    {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header row
        $sheet->setCellValue('A1', 'name');
        $sheet->setCellValue('B1', 'email');
        $sheet->setCellValue('C1', 'class');

        // Add some example data
        $sheet->setCellValue('A2', 'John Doe');
        $sheet->setCellValue('B2', 'john.doe@example.com');
        $sheet->setCellValue('C2', 'Class 10A');

        $sheet->setCellValue('A3', 'Jane Smith');
        $sheet->setCellValue('B3', 'jane.smith@example.com');
        $sheet->setCellValue('C3', 'Class 10A');

        // Set column width
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(15);

        // Create directory if it doesn't exist
        $directory = public_path('samples');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save file
        $writer = new Xlsx($spreadsheet);
        $writer->save(public_path('samples/student_import_sample.xlsx'));

        return response()->download(public_path('samples/student_import_sample.xlsx'));
    }
}
