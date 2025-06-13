<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Response;

class SampleController extends Controller
{
    /**
     * Generate a sample Excel template for question imports
     */
    public function questionImportTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'A1' => 'question',
            'B1' => 'category',
            'C1' => 'category_description',
            'D1' => 'subcategory',
            'E1' => 'subcategory_description',
            'F1' => 'type',
            'G1' => 'point',
            'H1' => 'difficulty',
            'I1' => 'option_a',
            'J1' => 'option_b',
            'K1' => 'option_c',
            'L1' => 'option_d',
            'M1' => 'correct_answer'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Add some sample data
        $sampleData = [
            [
                'What is the capital of France?', // question
                'Geography', // category
                'Questions about world geography', // category_description
                'Capitals', // subcategory
                'Questions about capital cities', // subcategory_description
                'multiple_choice', // type
                '1', // point
                '1', // difficulty
                'Paris', // option_a
                'London', // option_b
                'Berlin', // option_c
                'Madrid', // option_d
                'a', // correct_answer (corresponds to option_a)
            ],
            [
                'The sun rises in the east.', // question
                'Science', // category
                'General science questions', // category_description
                'Astronomy', // subcategory
                'Questions about celestial bodies', // subcategory_description
                'true_false', // type
                '1', // point
                '1', // difficulty
                '', // option_a (not used for true/false)
                '', // option_b (not used for true/false)
                '', // option_c (not used for true/false)
                '', // option_d (not used for true/false)
                'true', // correct_answer (true or false)
            ],
            [
                'What is the chemical symbol for water?', // question
                'Science', // category
                'General science questions', // category_description
                'Chemistry', // subcategory
                'Questions about chemical elements and compounds', // subcategory_description
                'short_essay', // type
                '2', // point
                '2', // difficulty
                '', // option_a (not used for short_essay)
                '', // option_b (not used for short_essay)
                '', // option_c (not used for short_essay)
                '', // option_d (not used for short_essay)
                'H2O', // correct_answer
            ],
            [
                'Explain the process of photosynthesis.', // question
                'Science', // category
                'General science questions', // category_description
                'Biology', // subcategory
                'Questions about biological processes', // subcategory_description
                'essay', // type
                '5', // point
                '3', // difficulty
                '', // option_a (not used for essay)
                '', // option_b (not used for essay)
                '', // option_c (not used for essay)
                '', // option_d (not used for essay)
                '', // correct_answer (not used for essay)
            ]
        ];

        // Add sample data rows
        foreach ($sampleData as $index => $row) {
            $rowNumber = $index + 2; // Start from row 2
            $sheet->setCellValue("A{$rowNumber}", $row[0]);
            $sheet->setCellValue("B{$rowNumber}", $row[1]);
            $sheet->setCellValue("C{$rowNumber}", $row[2]);
            $sheet->setCellValue("D{$rowNumber}", $row[3]);
            $sheet->setCellValue("E{$rowNumber}", $row[4]);
            $sheet->setCellValue("F{$rowNumber}", $row[5]);
            $sheet->setCellValue("G{$rowNumber}", $row[6]);
            $sheet->setCellValue("H{$rowNumber}", $row[7]);
            $sheet->setCellValue("I{$rowNumber}", $row[8]);
            $sheet->setCellValue("J{$rowNumber}", $row[9]);
            $sheet->setCellValue("K{$rowNumber}", $row[10]);
            $sheet->setCellValue("L{$rowNumber}", $row[11]);
            $sheet->setCellValue("M{$rowNumber}", $row[12]);
        }

        // Auto size columns
        foreach (range('A', 'M') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Style header row
        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
        $sheet->getStyle('A1:M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');

        // Create the Excel file in the public/samples directory
        $writer = new Xlsx($spreadsheet);
        $filePath = public_path('samples/questions_import_template.xlsx');
        $writer->save($filePath);

        // Return the file for download
        return response()->download($filePath, 'questions_import_template.xlsx');
    }
}
