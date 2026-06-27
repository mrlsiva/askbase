<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;

        return [
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category_name')->ignore($categoryId),
            ],
            'parent_id' => [
                'nullable',
                Rule::exists('categories', 'id')->whereNull('parent_id'),
                Rule::notIn([$categoryId]),
            ],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ];
    }

    public function messages(): array
    {
        return [
            'parent_id.exists' => 'The selected parent must be a top-level category (subcategories cannot be nested further).',
            'parent_id.not_in' => 'A category cannot be its own parent.',
        ];
    }

    /**
     * Prevent making a category a subcategory of itself if it already has children
     * (one level of nesting only).
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $categoryId = $this->route('category')?->id;

            if ($categoryId && $this->filled('parent_id')) {
                $hasChildren = Category::where('parent_id', $categoryId)->exists();

                if ($hasChildren) {
                    $validator->errors()->add('parent_id', 'This category has subcategories and cannot become a subcategory itself.');
                }
            }
        });
    }

    /**
     * Validated data plus the derived slug and a normalized (nullable) parent_id,
     * ready to pass straight to Category::create()/update(). The "image" upload
     * is handled separately by the controller, so it's excluded here.
     */
    public function categoryData(): array
    {
        $categoryId = $this->route('category')?->id;
        $validated = $this->validated();

        unset($validated['image']);

        $validated['parent_id'] = $validated['parent_id'] ?? null ?: null;
        $validated['slug'] = Category::uniqueSlug($validated['category_name'], $categoryId);

        return $validated;
    }
}
