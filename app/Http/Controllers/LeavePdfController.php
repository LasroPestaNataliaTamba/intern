<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Barryvdh\Snappy\Facades\SnappyPdf;

class LeavePdfController extends Controller
{
    public function generate($id)
    {
        $leave = LeaveRequest::with('user.company')->findOrFail($id);

        $pdf = SnappyPdf::loadView('pdf.leave', [
            'leave' => $leave
        ])->setOption('enable-local-file-access', true);

        return $pdf->download('surat-cuti.pdf');
    }
}
