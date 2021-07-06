<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Document;
use Carbon\Carbon;

class ReportsController extends Component
{
    public $componentName, $data ,$details, $sumDetails, $countDetails, $reportType, $userId,
            $dateFrom, $dateTo, $saleId;
    
    public function mount(){
        $this->componentName = 'Reporte de Documentaciones';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->saleId = 0;
    }

    public function render()
    {
        $this->DocumentByDate();
        
        return view('livewire.reports.component',[
                    'users' => User::orderBy('name','asc')->get()
                ])
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function DocumentByDate(){
        if ($this->reportType == 0) { //ventas del dia
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        }

        if ($this->reportType == 1 && ($this->dateFrom == '' && $this->dateTo == '')) {
            return;
        }

        if ($this->userId == 0) {
            $this->data = Document::join('users as u','u.id','documents.user_id')
                                ->select('documents.*','u.name as user')
                                ->whereBetween('documents.created_at', [$from,$to])
                                ->get();
        } else {
            $this->data = Document::join('users as u','u.id','documents.user_id')
                                ->select('documents.*','u.name as user')
                                ->whereBetween('documents.created_at',[$from,$to])
                                ->where('user_id', $this->userId)
                                ->get();
        }
    }

    public function getDetails(Document $document){
       
        $this->details = $document->archives;
        $this->countDetails = $this->details->count();
        $this->saleId = $document->id;
        $this->emit('show-modal','Details loaded');
    }
}
