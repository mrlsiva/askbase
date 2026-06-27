<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Show a single category's published questions (route-model-bound by slug).
     */
    public function show(Category $category): View
    {
        $category->load('parent');

        $categories = Category::sidebarTree();

        $questions = $category->questions()->published()->ordered()->paginate(10)->withQueryString();

        return view('frontend.home', [
            'categories' => $categories,
            'activeCategory' => $category,
            'questions' => $questions,
        ]);
    }
}
