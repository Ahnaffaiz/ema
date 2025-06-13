<?php

namespace App\Exports;

use App\Models\ExamStudent;
use App\Models\ExamSession;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentScoreExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithCustomStartCell, WithMapping
{
    protected $examSessionId;
    protected $examSession;
    protected $search;

    /**
     * Constructor
     *
     * @param int $examSessionId
     * @param string|null $search
     */
    public function __construct($examSessionId, $search = '')
    {
        $this->examSessionId = $examSessionId;
        $this->search = $search;
        $this->examSession = ExamSession::with(['exam', 'observer'])->findOrFail($examSessionId);
    }

    /**
     * Start cell for data
     *
     * @return string
     */
    public function startCell(): string
    {
        return 'A8';
    }

    /**
     * Set the spreadsheet title
     *
     * @return string
     */
    public function title(): string
    {
        return 'Student Scores';
    }

    /**
     * Get the data collection
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ExamStudent::with(['student.user', 'student.class', 'examReport'])
            ->where('exam_session_id', $this->examSessionId)
            ->whereHas('student.user', function($query) {
                if (!empty($this->search)) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                }
            })
            ->get();
    }

    /**
     * Map the data to rows
     *
     * @param mixed $student
     * @return array
     */
    public function map($student): array
    {
        $scoreData = [
            'score' => 0,
            'total' => 100 // Default total score
        ];

        if ($student->examReport) {
            $scoreData['score'] = $student->examReport->score;

            // Try to extract score/total from note
            if (isset($student->examReport->note) && preg_match('/Total score: (\d+)\/(\d+)/', $student->examReport->note, $matches)) {
                $scoreData['score'] = (int)$matches[1];
                $scoreData['total'] = (int)$matches[2];
            }
        }

        // Calculate percentage and score100
        $accuracy = ($scoreData['total'] > 0) ? ($scoreData['score'] / $scoreData['total']) * 100 : 0;
        $score100 = $accuracy; // Same calculation

        // Format session data for completed status
        $sessionData = $student->session_data ?? [];
        $isExamComplete = isset($sessionData['end_exam']) && $sessionData['end_exam'] !== null;
        $status = $isExamComplete ? 'Completed' : 'Not Completed';

        return [
            $student->student->user->name,
            $student->student->class->title ?? 'N/A',
            $student->student->user->email,
            $scoreData['score'] . '/' . $scoreData['total'],
            number_format($accuracy, 2) . '%',
            number_format($score100, 2),
            $status
        ];
    }

    /**
     * Set the headings
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Student Name',
            'Class',
            'Email',
            'Score',
            'Accuracy',
            'Score (100)',
            'Status'
        ];
    }

    /**
     * Style the Excel export
     *
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Add title and exam information at the top
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'EXAM STUDENT SCORES REPORT');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Add exam information
        $sheet->setCellValue('A3', 'Exam Session:');
        $sheet->setCellValue('B3', $this->examSession->title);

        $sheet->setCellValue('A4', 'Exam Title:');
        $sheet->setCellValue('B4', $this->examSession->exam->title);

        $sheet->setCellValue('A5', 'Duration:');
        $sheet->setCellValue('B5', $this->examSession->exam->timer . ' minutes');

        $sheet->setCellValue('A6', 'Generated:');
        $sheet->setCellValue('B6', now()->format('Y-m-d H:i:s'));

        // Style headers
        $headerRange = 'A8:G8';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E2E8F0');

        // Auto size columns
        foreach(range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            8 => ['font' => ['bold' => true]],
        ];
    }
}
