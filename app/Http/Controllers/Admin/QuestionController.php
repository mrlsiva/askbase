<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(Request $request): View
    {
        $questions = Question::query()
            ->with('category.parent')
            ->search($request->query('search'))
            ->when($request->query('category_id'), fn ($q, $categoryId) => $q->where('category_id', $categoryId))
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('admin.questions.index', [
            'questions' => $questions,
            'categories' => Category::topLevel()->with('children')->orderBy('category_name')->get(),
            'search' => $request->query('search'),
            'selectedCategoryId' => $request->query('category_id'),
            'selectedStatus' => $request->query('status'),
        ]);
    }

    public function create(): View
    {
        return view('admin.questions.create', [
            'question' => new Question(),
            'categories' => Category::topLevel()->with('children')->orderBy('category_name')->get(),
        ]);
    }

    public function store(QuestionRequest $request): RedirectResponse
    {
        Question::create($request->validated());

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question created successfully.');
    }

    public function edit(Question $question): View
    {
        return view('admin.questions.edit', [
            'question' => $question,
            'categories' => Category::topLevel()->with('children')->orderBy('category_name')->get(),
        ]);
    }

    public function update(QuestionRequest $request, Question $question): RedirectResponse
    {
        $question->update($request->validated());

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question deleted successfully.');
    }

    public function toggleStatus(Question $question): RedirectResponse
    {
        $question->update([
            'status' => $question->status === 'Published' ? 'Draft' : 'Published',
        ]);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question status updated.');
    }
}
