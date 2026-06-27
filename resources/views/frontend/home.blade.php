@extends('layouts.app')

@section('title', $activeCategory?->category_name ?? 'Home')

@section('content')
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card shadow-sm category-list">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-tags-fill me-1 text-primary"></i> Categories
                </div>
                <div class="list-group list-group-flush p-2">
                    @forelse ($categories as $category)
                        @php
                            $isParentActive = $activeCategory && $activeCategory->id === $category->id;
                            $hasActiveChild = $activeCategory && $category->children->contains('id', $activeCategory->id);
                        @endphp
                        <div class="d-flex align-items-stretch">
                            <a href="{{ route('category.show', $category->slug) }}"
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center flex-grow-1 {{ $isParentActive ? 'active' : '' }}">
                                {{ $category->category_name }}
                                <span class="badge {{ $isParentActive ? 'bg-white text-primary' : 'bg-secondary' }}">
                                    {{ $category->questions_count }}
                                </span>
                            </a>
                            @if ($category->children->isNotEmpty())
                                <button type="button" class="btn btn-light border-0" data-bs-toggle="collapse"
                                        data-bs-target="#subcats-{{ $category->id }}" aria-expanded="{{ $hasActiveChild ? 'true' : 'false' }}">
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                            @endif
                        </div>

                        @if ($category->children->isNotEmpty())
                            <div id="subcats-{{ $category->id }}" class="collapse {{ $hasActiveChild ? 'show' : '' }}">
                                @foreach ($category->children as $child)
                                    <a href="{{ route('category.show', $child->slug) }}"
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ps-4 {{ $activeCategory && $activeCategory->id === $child->id ? 'active' : '' }}">
                                        <span><i class="bi bi-arrow-return-right me-1 text-muted"></i>{{ $child->category_name }}</span>
                                        <span class="badge {{ $activeCategory && $activeCategory->id === $child->id ? 'bg-white text-primary' : 'bg-secondary' }}">
                                            {{ $child->questions_count }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    @empty
                        <p class="text-muted px-2 mb-0">No categories available.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            @if ($activeCategory)
                <form method="GET" action="{{ route('search') }}" class="d-flex mb-3">
                    <input type="hidden" name="category" value="{{ $activeCategory->slug }}">
                    <input type="search" name="q" value="{{ $searchTerm ?? '' }}" class="form-control"
                           placeholder="Search questions and answers in {{ $activeCategory->category_name }}...">
                    <button class="btn btn-primary ms-2"><i class="bi bi-search"></i></button>
                </form>

                <h4 class="mb-3">
                    @if ($activeCategory->parent)
                        <span class="text-muted">{{ $activeCategory->parent->category_name }} <i class="bi bi-chevron-right small"></i></span>
                    @endif
                    {{ $activeCategory->category_name }}
                </h4>

                @if ($questions->isEmpty())
                    <div class="alert alert-light border text-center text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i> No Questions Found
                    </div>
                @else
                    <div class="accordion" id="qaAccordion">
                        @foreach ($questions as $index => $item)
                            <div class="accordion-item mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#qa-{{ $item->id }}">
                                        {{ $item->question }}
                                    </button>
                                </h2>
                                <div id="qa-{{ $item->id }}" class="accordion-collapse collapse" data-bs-parent="#qaAccordion">
                                    <div class="accordion-body">
                                        {!! $item->answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        {{ $questions->links() }}
                    </div>
                @endif
            @else
                <div class="alert alert-light border text-center text-muted">
                    <i class="bi bi-inbox fs-3 d-block mb-2"></i> No Questions Found
                </div>
            @endif
        </div>
    </div>
@endsection
