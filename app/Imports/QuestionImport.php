<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\SubCategory;
use App\QuestionType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $rows = [];
    protected $importedCount = 0;

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $this->rows = $rows;

        foreach ($rows as $row) {
            // Check if required fields are present
            if (empty($row['question']) || empty($row['category']) || empty($row['subcategory']) || empty($row['type'])) {
                continue;
            }

            // Find or create category
            $category = Category::firstOrCreate(
                ['title' => $row['category']],
                [
                    'desc' => $row['category_description'] ?? null,
                    'created_by' => Auth::id() // Add the created_by field here
                ]
            );

            // Find or create subcategory
            $subCategory = SubCategory::firstOrCreate(
                [
                    'category_id' => $category->id,
                    'title' => $row['subcategory']
                ],
                ['desc' => $row['subcategory_description'] ?? null]
            );

            // Ensure question type is valid
            $questionType = $this->validateQuestionType($row['type']);

            // Create the question
            $question = Question::create([
                'title' => $row['question'],
                'type' => $questionType,
                'sub_category_id' => $subCategory->id,
                'point' => $row['point'] ?? 1,
                'difficulty' => $row['difficulty'] ?? 1,
                'created_by' => Auth::id(),
            ]);

            // Handle answers based on question type
            $this->createAnswersForQuestion($question, $row);

            // Increment counter
            $this->importedCount++;
        }
    }

    /**
     * Get the imported rows
     */
    public function getRows(): Collection
    {
        return collect($this->rows);
    }

    /**
     * Get the count of imported questions
     */
    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    /**
     * Validate the question type and return valid type value
     */
    private function validateQuestionType(string $type): string
    {
        $type = strtolower(str_replace(' ', '_', $type));

        // Check if it's a valid question type
        if (in_array($type, array_keys(QuestionType::options()))) {
            return $type;
        }

        // Try to match similar types
        if (str_contains($type, 'multiple') || str_contains($type, 'choice') || $type === 'mc') {
            return QuestionType::MULTIPLE_CHOICE->value;
        } elseif (str_contains($type, 'essay') && str_contains($type, 'short')) {
            return QuestionType::SHORT_ESSAY->value;
        } elseif (str_contains($type, 'essay')) {
            return QuestionType::ESSAY->value;
        } elseif (str_contains($type, 'true') || str_contains($type, 'false') || $type === 'tf') {
            return QuestionType::TRUE_FALSE->value;
        }

        // Default to multiple choice if can't determine
        return QuestionType::MULTIPLE_CHOICE->value;
    }

    /**
     * Create answers for the question based on its type
     */
    private function createAnswersForQuestion(Question $question, $row): void
    {
        if ($question->type === QuestionType::MULTIPLE_CHOICE->value) {
            // Handle multiple choice answers (expects option_a, option_b, etc. with correct_answer field)
            $options = [];
            foreach ($row as $key => $value) {
                if (strpos($key, 'option_') === 0 && !empty($value)) {
                    $letter = substr($key, 7, 1); // Extract the letter (a, b, c, etc.)
                    $options[$letter] = $value;
                }
            }

            foreach ($options as $letter => $text) {
                QuestionAnswer::create([
                    'question_id' => $question->id,
                    'title' => $text,
                    'is_true' => strtolower($row['correct_answer'] ?? '') === strtolower($letter),
                ]);
            }
        } elseif ($question->type === QuestionType::TRUE_FALSE->value) {
            // Create True option
            QuestionAnswer::create([
                'question_id' => $question->id,
                'title' => 'True',
                'is_true' => strtolower($row['correct_answer'] ?? '') === 'true',
            ]);

            // Create False option
            QuestionAnswer::create([
                'question_id' => $question->id,
                'title' => 'False',
                'is_true' => strtolower($row['correct_answer'] ?? '') === 'false',
            ]);
        } elseif ($question->type === QuestionType::SHORT_ESSAY->value && isset($row['correct_answer'])) {
            // Add the correct answer
            QuestionAnswer::create([
                'question_id' => $question->id,
                'title' => $row['correct_answer'],
                'is_true' => true,
            ]);
        }
        // For essay type, no answers needed
    }

    /**
     * Rules for validation
     */
    public function rules(): array
    {
        return [
            'question' => 'required',
            'category' => 'required',
            'subcategory' => 'required',
            'type' => 'required',
        ];
    }
}
