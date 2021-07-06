@include('common.modalHeader')
<div class="row">
    <div class="col-sm-12 col-md-6">
         <label>Gestion</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit"></span>
                </span>
            </div>
            <input 
            type="text" 
            wire:model.lazy="gestion" 
            class="form-control" 
            placeholder="ej: 2021"
            maxlength="25">
        </div>
        @error('gestion')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
</div>
@include('common.modalFooter')