<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Search published questions/answers within a single selected category.
     */
    public function index(Request $request): View
    {
        $term = $request->query('q');
        $categorySlug = $request->query('category');

        $activeCategory = $categorySlug
            ? Category::active()->with('parent')->where('slug', $categorySlug)->first()
            : null;

        $categories = Category::sidebarTree();

        $questions = $activeCategory
            ? $activeCategory->questions()->published()->search($term)->ordered()->paginate(10)->withQueryString()
            : Question::query()->whereRaw('0 = 1')->paginate(10)->withQueryString();

        return view('frontend.home', [
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'questions' => $questions,
            'searchTerm' => $term,
        ]);
    }
}
