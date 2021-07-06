<div class="form-group m-0 col-sm-12 col-md-6 col-lg-6 ">
    <label class="m-0 p-0" for="subcategory_id">Subcategoría:</label>
    <div wire:ignore>
        <select 
        class="form-control form-control-sm @error('subcategory_id') is-invalid @enderror"
        name="subcategory_id"
        id="subcategory_id"
        data-livewire="@this">
            <option value="Elegir">Categoria</option>
            @foreach ($categories as $item)
                <select @if ($product->id)
                    @if ($subcategory_id==$subcategory->id)
                        selected = selected
                    @endif
                    @endif
                    value="{{ $subcategory->id }}"> - {{ $subcategory->name }}">
                </select>
            @endforeach
        </select>
    </div>
</div>

$('#subcategory_id').select2({
            theme: 'bootstrap4',
        placeholder: "- Seleccione Categoría -",
        allowClear: true
    }).on('change', function(e) {
        let livewire = $(this).data('livewire')
        eval(livewire).set('subcategory_id', $(this).val());
    });