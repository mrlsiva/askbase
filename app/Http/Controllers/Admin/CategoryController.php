<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::withCount('questions')
            ->with('parent')
            ->search($request->query('search'))
            ->orderByRaw('parent_id is not null')
            ->orderBy('category_name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', [
            'categories' => $categories,
            'search' => $request->query('search'),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'category' => new Category(),
            'parentOptions' => Category::topLevel()->orderBy('category_name')->get(),
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->categoryData();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'parentOptions' => Category::topLevel()->where('id', '!=', $category->id)->orderBy('category_name')->get(),
        ]);
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->categoryData();

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        // One level of nesting only: subcategories must go with their parent.
        $category->children->each(function (Category $child) {
            if ($child->image) {
                Storage::disk('public')->delete($child->image);
            }

            $child->delete();
        });

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function toggleStatus(Category $category): RedirectResponse
    {
        $category->update([
            'status' => $category->status === 'Active' ? 'Inactive' : 'Active',
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category status updated.');
    }
}
