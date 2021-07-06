<div class="connect-sorting">
    <div class="connect-sorting-content">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                <h5 class="text-center text-muted"><b>{{$componentName}} | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR'}}</b></h5>
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
                        <div wire:ignore class="form-group">
                            <select id="selectcategories" class="form-control">
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
                        <div wire:ignore class="form-group">
                            <label>Gestiones</label>
                            <select id="select2anios" class="form-control" multiple>
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
                            accept=".pdf, .xls, .xlsx">
                            <label class="custom-file-label">Archivo {{$archive}}</label>
                            @error('archive')
                                <span class="text-danger er">{{ $message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div wire:loading.inline wire:target="saveSale">
                    <h4 class="text-danger text-center">Guardando Venta....</h4>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            <button type="button" wire:click.prevent="cancelar()" class="btn btn-dark close-btn text-info" data-dismiss="modal">
                Cancelar
            </button>
            @if($selected_id < 1)
            <button type="button" wire:click.prevent="Store()" class="btn btn-dark close-modal">
                GUARDAR
            </button>
            @else
            <button type="button" wire:click.prevent="Update()" class="btn btn-dark close-modal">
                ACTUALIZAR
            </button>
            @endif
        </div>
    </div>
</div>
<script>

</script>