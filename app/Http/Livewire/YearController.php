<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Year;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class YearController extends Component
{
    use WithPagination;

    public $gestion, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Gestiones';
        $this->selected_id = 0;
    }

    public function render()
    {
        if (strlen($this->search) > 0) 
            $data = Year::where('gestion','like','%' .$this->search. '%')
                                ->paginate($this->pagination);
        else
        $data = Year::orderBy('id','desc')->paginate($this->pagination);

        return view('livewire.years.index',
            ['years' => $data
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Edit($id){
        $record = Year::find($id,['id','gestion']);
        $this->gestion = $record->gestion;
        $this->selected_id = $record->id;
        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules= [
            //'gestion' => 'required|unique:years,deleted_at,null',
            'gestion' => ['required', Rule::unique('years', 'gestion')->where(function ($query) {
                $query->whereNull('deleted_at');
            })]
        ];
        $messages = [
            'gestion.required' => 'la gestion es requerida',
            'gestion.unique' => 'Ya existe una gestion con este valor'
        ];
        $this->validate($rules,$messages);
        $year = Year::create([
            'gestion' => $this->gestion
        ]);
        $this->resetUI();
        $this->emit('item-added','Gestion Registrada');
    }

    public function Update(){
        $rules = [
            //'gestion' => "required|unique:years,gestion,{$this->selected_id},deleted_at,",
            'gestion' => ['required', Rule::unique('years', 'gestion')->where(function ($query) {
                $query->whereNull('deleted_at');
            })->whereNot('id', $this->selected_id)]
        ];

        $messages = [
            'gestion.required' => 'La gestion es requerida',
            'gestion.unique' => 'Esta gestion ya esta registrada'
        ];

        $this->validate($rules,$messages);

        $year = Year::find($this->selected_id);
        $year->update([
            'gestion' => $this->gestion
        ]);

        $this->resetUI();
        $this->emit('item-updated','Gestion Actualizada');
    }

    public function resetUI(){
        $this->gestion = '';
        $this->search = '';
        $this->selected_id = 0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Year $denomination){
        $denomination->delete();
        $this->resetUI();
        $this->emit('item-deleted','Gestion Eliminada');
    }
}
