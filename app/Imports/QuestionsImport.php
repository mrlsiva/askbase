<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public int $imported = 0;

    /**
     * Maps one spreadsheet row (Category | Question | Answer | Status) to a Question,
     * auto-creating the category when it doesn't already exist.
     */
    public function model(array $row): Question
    {
        $category = Category::firstOrCreate(
            ['category_name' => trim($row['category'])],
            [
                'slug' => Category::uniqueSlug(trim($row['category'])),
                'status' => 'Active',
            ]
        );

        $this->imported++;

        $status = ucfirst(strtolower(trim($row['status'] ?? 'Draft')));

        return new Question([
            'category_id' => $category->id,
            'question' => $row['question'],
            'answer' => $row['answer'],
            'display_order' => 0,
            'status' => in_array($status, ['Published', 'Draft']) ? $status : 'Draft',
        ]);
    }

    public function rules(): array
    {
        return [
            'category' => ['required', 'string', 'max:255'],
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string'],
            'status' => ['nullable', Rule::in(['Published', 'Draft', 'published', 'draft'])],
        ];
    }

    public function customValidationAttributes(): array
    {
        return [
            'category' => 'Category',
            'question' => 'Question',
            'answer' => 'Answer',
            'status' => 'Status',
        ];
    }
}
