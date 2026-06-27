<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\QuestionsImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class QuestionImportController extends Controller
{
    public function create(): View
    {
        return view('admin.import.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,csv,txt'],
        ]);

        $import = new QuestionsImport();
        Excel::import($import, $request->file('file'));

        $failures = $import->failures()->map(fn ($failure) => [
            'row' => $failure->row(),
            'errors' => $failure->errors(),
        ])->values()->all();

        return redirect()->route('admin.import.create')->with([
            'importedCount' => $import->imported,
            'failures' => $failures,
        ]);
    }
}
