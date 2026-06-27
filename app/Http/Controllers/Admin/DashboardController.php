<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalCategories' => Category::count(),
            'totalQuestions' => Question::count(),
            'publishedQuestions' => Question::where('status', 'Published')->count(),
            'draftQuestions' => Question::where('status', 'Draft')->count(),
        ]);
    }
}
