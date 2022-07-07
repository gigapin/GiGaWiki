<?php

namespace App\Services;

use App\Jobs\PDFExportJob;
use App\Models\Page;
use PDF;
use Illuminate\Support\Facades\Auth;


class PDFController 
{
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
