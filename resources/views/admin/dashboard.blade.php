@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="card card-stat shadow-sm" style="background: linear-gradient(135deg,#0d6efd,#3b82f6);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50">Total Categories</div>
                        <div class="fs-2 fw-bold">{{ $totalCategories }}</div>
                    </div>
                    <i class="bi bi-tags-fill fs-1 opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-stat shadow-sm" style="background: linear-gradient(135deg,#6f42c1,#8e6fe0);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50">Total Questions</div>
                        <div class="fs-2 fw-bold">{{ $totalQuestions }}</div>
                    </div>
                    <i class="bi bi-question-circle-fill fs-1 opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-stat shadow-sm" style="background: linear-gradient(135deg,#198754,#28c76f);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50">Published Questions</div>
                        <div class="fs-2 fw-bold">{{ $publishedQuestions }}</div>
                    </div>
                    <i class="bi bi-check-circle-fill fs-1 opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-stat shadow-sm" style="background: linear-gradient(135deg,#fd7e14,#ffae5c);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50">Draft Questions</div>
                        <div class="fs-2 fw-bold">{{ $draftQuestions }}</div>
                    </div>
                    <i class="bi bi-file-earmark-text-fill fs-1 opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-lightning-charge-fill text-warning me-1"></i>Quick Actions</h5>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Add Category
                        </a>
                        <a href="{{ route('admin.questions.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Add Question
                        </a>
                        <a href="{{ route('admin.import.create') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-file-earmark-arrow-up me-1"></i> Bulk Import
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
