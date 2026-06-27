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
    <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
    <select id="category_id" name="category_id" class="form-select" required>
        <option value="">Select a category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $question->category_id) == $category->id)>
                {{ $category->category_name }}
            </option>
            @if ($category->children->isNotEmpty())
                <optgroup label="{{ $category->category_name }} subcategories">
                    @foreach ($category->children as $child)
                        <option value="{{ $child->id }}" @selected(old('category_id', $question->category_id) == $child->id)>
                            &nbsp;&nbsp;&mdash; {{ $child->category_name }}
                        </option>
                    @endforeach
                </optgroup>
            @endif
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
    <input type="text" id="question" name="question" class="form-control"
           value="{{ old('question', $question->question) }}" required>
</div>

<div class="mb-3">
    <label for="answer" class="form-label">Answer <span class="text-danger">*</span></label>
    <textarea id="answer" name="answer" rows="10">{{ old('answer', $question->answer) }}</textarea>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="display_order" class="form-label">Display Order</label>
        <input type="number" id="display_order" name="display_order" class="form-control" min="0"
               value="{{ old('display_order', $question->display_order ?? 0) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select" required>
            <option value="Draft" @selected(old('status', $question->status ?? 'Draft') === 'Draft')>Draft</option>
            <option value="Published" @selected(old('status', $question->status ?? 'Draft') === 'Published')>Published</option>
        </select>
    </div>
</div>
