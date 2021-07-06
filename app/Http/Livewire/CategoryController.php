<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Component
{
    use WithFileUploads,WithPagination;

    public $name, $search ,$selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    protected $paginationTheme = 'bootstrap'; 
    
    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';
    }

    public function render()
    {
        if (strlen($this->search) > 0) 
            $data = Category::where('name','like','%' .$this->search. '%')
                              ->paginate($this->pagination);
        else
        $data = Category::orderBy('id','desc')->paginate($this->pagination);

        return view('livewire.category.index',['categories'=>$data])
                ->extends('layouts.theme.app')
                ->section('content');
    }
    
    public function Store(){
        $rules= [
            'name' => ['required','min:3', Rule::unique('categories', 'name')->where(function ($query) {
                $query->whereNull('deleted_at');
            })]
        ];

        $messages = [
            'name.required' => 'El nombre de la categoria es requerido',
            'name.unique' => 'Ya existe una categoria con ese nombre',
            'name.min' => 'El nombre deve tener al menos 3 caracteres'
        ];

        $this->validate($rules,$messages);

        $category = Category::create([
            'name' => $this->name
        ]);

        $this->resetUI();
        $this->emit('category-added','Categoria Registrada');
    }

    public function Edit($id){
        $record = Category::find($id,['id','name']);
        $this->name = $record->name;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function resetUI(){
        $this->name = '';
        $this->search = '';
        $this->selected_id = 0;
    }

    public function Update(){
        $rules = [
            //'name' => "required|min:3|unique:categories,name,{$this->selected_id}",
            'name' => ['required','min:3', Rule::unique('categories', 'name')->where(function ($query) {
                $query->whereNull('deleted_at');
            })->whereNot('id', $this->selected_id)]
        ];

        $messages = [
            'name.required' => 'Nombre de la categoria es requerido',
            'name.min' => 'la categoria deve tener al menos tres caracteres',
            'name.unique' => 'El nombre de esta categoria ya existe'
        ];

        $this->validate($rules,$messages);

        $category = Category::find($this->selected_id);
        $category->update([
            'name' => $this->name
        ]);

        $this->resetUI();
        $this->emit('category-updated','Categoria Actualizada');
    }
    
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Category $category){
        $category->delete();
        $this->resetUI();
        $this->emit('category-deleted','Categoria Eliminada');
    }
}
