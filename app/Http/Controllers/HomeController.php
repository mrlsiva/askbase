<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show questions from the first active category (ordered by name).
     */
    public function index(): View
    {
        $categories = Category::sidebarTree();

        $firstCategory = $categories->first();

        $questions = $firstCategory
            ? $firstCategory->questions()->published()->ordered()->paginate(10)->withQueryString()
            : Question::query()->whereRaw('0 = 1')->paginate(10)->withQueryString();

        return view('frontend.home', [
            'categories' => $categories,
            'activeCategory' => $firstCategory,
            'questions' => $questions,
        ]);
    }
}
