<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Document;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function reportPDF($userId, $reportType,$dateFrom = null, $dateTo = null){
        $data = [];
        if ($reportType == 0) { //ventas del dia
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($dateTo)->format('Y-m-d') . ' 23:59:59';
        }
        if ($userId == 0) {
            $data = Document::with('archives')
                            ->join('users as u','u.id','documents.user_id')
                            ->join('categories as c','c.id','documents.category_id')
                            ->select('documents.*','u.name as user','c.name as categoria')
                            ->whereBetween('documents.created_at', [$from,$to])
                            ->get();
        } else {
            $data = Document::with('archives')
                            ->join('users as u','u.id','documents.user_id')
                            ->join('categories as c','c.id','documents.category_id')
                            ->select('documents.*','u.name as user','c.name as categoria')
                            ->whereBetween('documents.created_at',[$from,$to])
                            ->where('user_id', $userId)
                            ->get();
        }

        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;
        $pdf = PDF::loadView('pdf.report',compact('data','reportType','user','dateFrom','dateTo'));
        return $pdf->stream('salesReport.pdf');
    }
}
