<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\PDFExportJob;
use App\Models\Page;
use PDF;
use Illuminate\Support\Facades\Auth;


class PDFController extends Controller
{
    /**
     * Generate pdf document.
     *
     * @param string $slug
     * @return void
     */
    public function generatePdf(string $slug)
    {
        
        $pageX = Page::where('slug', $slug)
            ->where('updated_by', Auth::id())
            ->firstOrFail();
        
        $data = [
            'title' => $pageX->title,
            'content' => $pageX->content
        ];

        $pdf = PDF::loadView('exports.pdf', $data);
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        return $pdf->download($pageX->title . '.pdf');
    }
}
