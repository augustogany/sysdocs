<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Year;
use App\Models\Category;
use App\Models\Document;
use Livewire\WithFileUploads;
use DB;

class Createdocument extends Component
{
    use WithFileUploads;
    public $name,$anios=[],$pageTitle,$componentName,$categoryid,$years=[],$archive,$selected_id;

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Documentos';
        $this->categoryid = 'Elegir';
        $this->years = Year::all();
    }

    public function render()
    {
        return view('livewire.documents.create',[
            'categories' => Category::orderBy('name','asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function cancelar(){
        return redirect()->route('documents');
    }

    public function Store(){
        $rules= [
            'name' => 'required|unique:documents|min:3',
            'categoryid' => 'required|not_in:Elegir',
            //'archive' => 'required|mimes:csv,txt,xlx,xls,pdf,doc|max:2048'
        ];

        $messages = [
            'name.required' => 'El nombre del producto es requerido',
            'name.unique' => 'Ya existe un producto con ese nombre',
            'name.min' => 'El nombre deve tener al menos 3 caracteres',
            'categoryid.not_in' => 'Selecciona una categoria diferente de Elegir',
        ];

        $this->validate($rules,$messages);

        DB::beginTransaction();
        try {
            $document = Document::create([
                'name' => $this->name,
                'category_id' => $this->categoryid,
                'status' => 'disponible',
                'user_id' => auth()->user()->id
            ]);
            $document->years()->attach($this->anios);
            $customFileName;
            if ($this->archive) {
                $customFileName = uniqid() . '_.' . $this->archive->extension();
                $this->archive->storeAs('public/documents', $customFileName);
                //guardar el archivo en relacion belonsgtoMany
                $document->archives()->create([
                    'nombre_origen' => $this->archive->getClientOriginalName(),
                    'extension' => $this->archive->extension(),
                    'ruta' => $customFileName,
                ]);
            }
            DB::commit();
            $this->resetUI();
            $this->emit('document-added','Documento Registrado');
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function resetUI(){
        $this->name = '';
        $this->anios = [];
        $this->archive = null;
        $this->categoryid = '';
        $this->selected_id = 0;
    }
}
