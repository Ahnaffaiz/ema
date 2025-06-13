<?php

namespace App\Imports;

use App\Models\Classes;
use App\Models\ClassStudent;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Spatie\Permission\Models\Role;

class StudentImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $rows = [];
    protected $importedCount = 0;
    protected $createdClassesCount = 0;

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $this->rows = $rows;
        $studentRole = Role::findByName('student', 'web');

        foreach ($rows as $row) {
            // Check if required fields are present
            if (empty($row['name']) || empty($row['email']) || empty($row['class'])) {
                continue;
            }

            // Find or create class
            $class = Classes::firstOrCreate(
                ['title' => $row['class']],
                [
                    'year' => now(),
                    'user_id' => auth()->id() ?? 1, // Default to admin user if no user is authenticated
                ]
            );

            // If class was just created, increment counter
            if ($class->wasRecentlyCreated) {
                $this->createdClassesCount++;
            }

            // Find existing user or create new one
            $user = User::firstOrCreate(
                ['email' => $row['email']],
                [
                    'name' => $row['name'],
                    'password' => Hash::make('password'), // Default password
                ]
            );

            // Assign student role if not already assigned
            if (!$user->hasRole('student')) {
                $user->assignRole($studentRole);
            }

            // Check if student is already in this class
            $existingClassStudent = ClassStudent::where('user_id', $user->id)
                ->where('class_id', $class->id)
                ->first();

            if (!$existingClassStudent) {
                // Add student to class
                ClassStudent::create([
                    'user_id' => $user->id,
                    'class_id' => $class->id,
                ]);

                // Increment counter
                $this->importedCount++;
            }
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
     * Get the count of imported students
     */
    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    /**
     * Get the count of created classes
     */
    public function getCreatedClassesCount(): int
    {
        return $this->createdClassesCount;
    }

    /**
     * Rules for validation
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'class' => 'required',
        ];
    }
}
