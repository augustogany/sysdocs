<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Document;
use App\Models\Year;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Component
{
    use WithFileUploads,WithPagination;

    public $name, $categoryid, $search, $archive, $years,$anios=[], $selected_id, $pageTitle, $componentName;
    
    private $pagination = 5;
    
    protected $paginationTheme = 'bootstrap'; 

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Documentos';
        $this->categoryid = 'Elegir';
        $this->years = Year::all();
    }

    public function render()
    {
        if (Str::length($this->search) > 0) 
            $data = Document::join('categories as c','c.id','documents.category_id')
                             ->select('documents.id','documents.name','documents.user_id','c.name as category')
                             ->where('documents.name','like','%' .$this->search . '%')
                             ->orWhere('c.name','like','%' .$this->search . '%')
                             ->orderBy('documents.name','asc')
                             ->paginate($this->pagination);
        else
            $data = Document::join('categories as c','c.id','documents.category_id')
                            ->select('documents.id','documents.name','documents.user_id','c.name as category')
                            ->orderBy('documents.name','asc')
                            ->paginate($this->pagination);

        return view('livewire.documents.index',[
            'documents' => $data,
            'categories' => Category::orderBy('name','asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function nuevo(){
        return redirect()->route('newdocument');
    }

    public function Store(){
        $rules= [
            'name' => 'required|unique:documents|min:3',
            'categoryid' => 'required|not_in:Elegir'
        ];

        $messages = [
            'name.required' => 'El nombre del producto es requerido',
            'name.unique' => 'Ya existe un producto con ese nombre',
            'name.min' => 'El nombre deve tener al menos 3 caracteres',
            'categoryid.not_in' => 'Selecciona una categoria diferente de Elegir',
        ];

        $this->validate($rules,$messages);

        $document = Document::create([
            'name' => $this->name,
            'category_id' => $this->categoryid
        ]);

        $customFileName;
        if ($this->archive) {
            $customFileName = uniqid() . '_.' . $this->archive->extension();
            $this->archive->storeAs('public/documents', $customFileName);
            //guardar el archivo en relacion belonsgtoMany
            //$document->image = $customFileName;
            $document->save();
        }
        $this->resetUI();
        $this->emit('document-added','Producto Registrado');
    }

    public function Edit(Document $document){
        $this->selected_id = $document->id;
        $this->name = $document->name;
        $this->categoryid = $document->category_id;
        $this->archive = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function Update(){
        $rules= [
            'name' => "required|min:3|unique:documents,name,{$this->selected_id}",
            'categoryid' => 'required|not_in:Elegir'
        ];

        $messages = [
            'name.required' => 'El nombre del documento es requerido',
            'name.unique' => 'Ya existe un documento con ese nombre',
            'name.min' => 'El nombre deve tener al menos 3 caracteres',
            'categoryid.not_in' => 'Selecciona una categoria diferente de Elegir',
        ];

        $this->validate($rules,$messages);

        $document = Document::find($this->selected_id);

        $document->update([
            'name' => $this->name,
            'category_id' => $this->categoryid
        ]);

        $customFileName;
        if ($this->archive) {
            $customFileName = uniqid() . '_.' . $this->archive->extension();
            $this->archive->storeAs('public/documents', $customFileName);
            //actualizar el archivo
            $imageName = $document->image;
            $document->image = $customFileName;
            $document->save();

            if ($imageName != null) {
                if (file_exists('storage/documents/' . $imageName)) {
                    unlink('storage/documents/' . $imageName);
                }
            }
        }
        $this->resetUI();
        $this->emit('document-added','Documento Registrado');
    }

    public function resetUI(){
        $this->name = '';
        $this->archive = null;
        $this->search = '';
        $this->categoryid = 'Elegir';
        $this->selected_id = 0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Document $document){
        $imageTemp = $document->image;
        //eliminar los documentos asociados
        $document->delete();

        if ($imageTemp != null) {
            if (file_exists('storage/documents/' . $imageTemp)) {
                unlink('storage/documents/' . $imageTemp);
            }
        }

        $this->resetUI();
        $this->emit('document-deleted','Documento Eliminado');
    }
}
