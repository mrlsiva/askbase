<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - AskBase Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar {
            min-height: 100vh;
            background: #1e2a3a;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
            font-weight: 500;
            border-radius: .375rem;
            margin-bottom: .15rem;
        }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,.1);
        }
        .sidebar .brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.25rem;
        }
        .card-stat {
            border: none;
            border-radius: .75rem;
            color: #fff;
        }
        .table thead th { white-space: nowrap; }
    </style>
    @stack('styles')
</head>
<body>
<div class="d-flex">
    <nav class="sidebar p-3" style="width: 250px;">
        <a href="{{ route('admin.dashboard') }}" class="brand d-flex align-items-center gap-2 text-decoration-none mb-4">
            <i class="bi bi-patch-question-fill"></i> AskBase
        </a>
        <ul class="nav nav-pills flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags-fill me-2"></i> Categories
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.questions.index') }}" class="nav-link {{ request()->routeIs('admin.questions.*') ? 'active' : '' }}">
                    <i class="bi bi-question-circle-fill me-2"></i> Questions
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.import.create') }}" class="nav-link {{ request()->routeIs('admin.import.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-arrow-up-fill me-2"></i> Bulk Import
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="bi bi-box-arrow-up-right me-2"></i> View Site
                </a>
            </li>
        </ul>
    </nav>

    <main class="flex-grow-1">
        <nav class="navbar navbar-light bg-white border-bottom px-4">
            <span class="navbar-brand mb-0 h5">@yield('title', 'Dashboard')</span>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted">
                    <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                </span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </nav>

        <div class="p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-1"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle-fill me-1"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
