<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AskBase') - Questions &amp; Answers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fb; }
        .navbar-brand i { color: #0d6efd; }
        .category-list .list-group-item {
            border: none;
            border-radius: .5rem !important;
            margin-bottom: .25rem;
            font-weight: 500;
        }
        .category-list .list-group-item.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .accordion-button:not(.collapsed) {
            background-color: #e7f1ff;
            color: #0d6efd;
        }
        footer {
            color: #6c757d;
            font-size: .9rem;
        }
        .accordion-body table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }
        .accordion-body table td,
        .accordion-body table th {
            border: 1px solid #dee2e6;
            padding: .5rem .75rem;
        }
        .accordion-body table th {
            background-color: #f1f3f5;
        }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
            <i class="bi bi-patch-question-fill fs-4"></i> AskBase
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-list-ul me-1"></i>Categories
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @forelse($navCategories as $navCategory)
                            <li>
                                <a class="dropdown-item" href="{{ route('category.show', $navCategory->slug) }}">
                                    {{ $navCategory->category_name }}
                                </a>
                            </li>
                            @foreach ($navCategory->children as $child)
                                <li>
                                    <a class="dropdown-item ps-4" href="{{ route('category.show', $child->slug) }}">
                                        <i class="bi bi-arrow-return-right me-1"></i>{{ $child->category_name }}
                                    </a>
                                </li>
                            @endforeach
                        @empty
                            <li><span class="dropdown-item-text text-muted">No categories</span></li>
                        @endforelse
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container">
        @yield('content')
    </div>
</main>

<footer class="border-top py-4 mt-4 bg-white">
    <div class="container text-center">
        &copy; {{ date('Y') }} AskBase. All rights reserved.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
