@extends('layouts.admin')

@section('title', 'Bulk Import')

@section('content')
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-file-earmark-arrow-up-fill me-1"></i> Import Questions</h5>
                    <p class="text-muted">Upload an Excel (.xlsx) or CSV file with the columns below. Categories that don't already exist will be created automatically.</p>

                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                        <tr><th>Category</th><th>Question</th><th>Answer</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Laravel</td>
                            <td>What is Laravel?</td>
                            <td>Laravel is a PHP framework.</td>
                            <td>Published</td>
                        </tr>
                        </tbody>
                    </table>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.import.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Choose File (.xlsx or .csv)</label>
                            <input type="file" id="file" name="file" class="form-control" accept=".xlsx,.csv,.txt" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i> Import
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            @if (session('importedCount') !== null)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-clipboard-check-fill me-1"></i> Import Report</h5>

                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            {{ session('importedCount') }} question(s) imported successfully.
                        </div>

                        @if (count(session('failures', [])) > 0)
                            <div class="alert alert-danger">
                                <i class="bi bi-x-circle-fill me-1"></i>
                                {{ count(session('failures')) }} row(s) failed validation.
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                    <tr><th>Row</th><th>Errors</th></tr>
                                    </thead>
                                    <tbody>
                                    @foreach (session('failures') as $failure)
                                        <tr>
                                            <td>{{ $failure['row'] }}</td>
                                            <td>
                                                <ul class="mb-0">
                                                    @foreach ($failure['errors'] as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
