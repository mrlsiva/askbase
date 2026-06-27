@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="category_name" class="form-label">Category Name <span class="text-danger">*</span></label>
    <input type="text" id="category_name" name="category_name" class="form-control"
           value="{{ old('category_name', $category->category_name) }}" required>
</div>

<div class="mb-3">
    <label for="parent_id" class="form-label">Parent Category</label>
    <select id="parent_id" name="parent_id" class="form-select">
        <option value="">None (top-level category)</option>
        @foreach ($parentOptions as $option)
            <option value="{{ $option->id }}" @selected((string) old('parent_id', $category->parent_id) === (string) $option->id)>
                {{ $option->category_name }}
            </option>
        @endforeach
    </select>
    <div class="form-text">Select a parent to make this a subcategory. Subcategories cannot have their own subcategories.</div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
</div>

<div class="mb-3">
    <label for="image" class="form-label">Category Image</label>
    @if ($category->image)
        <div class="mb-2">
            <img src="{{ \Illuminate\Support\Facades\Storage::url($category->image) }}" alt="{{ $category->category_name }}"
                 class="img-thumbnail" style="max-height: 120px;">
        </div>
    @endif
    <input type="file" id="image" name="image" class="form-control" accept="image/png,image/jpeg,image/webp">
    <div class="form-text">JPG, PNG, or WEBP. Max 2MB. Used in the admin panel only (not shown on the public site yet).</div>
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
    <select id="status" name="status" class="form-select" required>
        <option value="Active" @selected(old('status', $category->status ?? 'Active') === 'Active')>Active</option>
        <option value="Inactive" @selected(old('status', $category->status ?? 'Active') === 'Inactive')>Inactive</option>
    </select>
</div>
