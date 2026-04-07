<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class LeavePdfController extends Controller
{
    public function generate($id)
    {
        $leave = LeaveRequest::with('user')->findOrFail($id);

        if ($leave->final_status !== 'approved') {
            abort(403);
        }

        $pdf = Pdf::loadView('pdf.leave', compact('leave'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('surat-cuti-'.$leave->id.'.pdf');
    }
}
