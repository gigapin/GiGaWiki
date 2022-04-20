<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Page;
use PDF;
use Illuminate\Support\Facades\Auth;


class PDFController extends Controller
{
    public function generatePdf(string $project, string $section, string $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('updated_by', Auth::id())
            ->firstOrFail();
        $data = [
            'title' => $page->title,
            'content' => $page->content
        ];

        $pdf = PDF::loadView('exports.pdf', $data);
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        return $pdf->download($page->title . '.pdf');
    }
}
