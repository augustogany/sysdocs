@include('common.modalHeader')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ej: Informes de POA">
            @error('name')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <label>Categoria</label>
        <div class="form-group">
            <select wire:model="categoryid" id="selectcategories" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            @error('categoryid')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Gestiones</label>
            <select class="form-control" multiple>
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($years as $year)
                    <option value="{{$year->id}}">{{$year->gestion}}</option>
                @endforeach
            </select>
            @error('anios')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-12">
        <div class="form-group custom-file">
            <input 
            type="file" 
            wire:model="archive" 
            class="custom-file-input form-control" 
            accept="image/x-png, image/gif, image/jpeg, image/jpg">
            <label class="custom-file-label">Archivo {{$archive}}</label>
            @error('archive')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')
