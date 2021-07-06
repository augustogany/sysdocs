@push('style')
<link rel="stylesheet" href="{{ asset('css/select2.min.css')}}" type="text/css">
@endpush
<div>
    <style></style>
    <div class="row layout-top-spacing">
        <div class="col-sm-12 col-md-12">
            <!-- DETALLE -->
            @include('livewire.documents.partials.detail')
        </div>
        <div class="col-sm-12 col-md-4">
            <!-- TOTAL -->
           

            <!-- DENOMINACIONES -->
           
        </div>
    </div>
</div>
@push('script')
<script src="{{ asset('js/select2.min.js') }}"></script>
@endpush
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#select2anios').select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Elegir'
            },
            allowClear: true
        });
         $('#selectcategories').select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Elegir'
            },
        });
        // $('#select2anios').on('select2:select', function(e) {
        //     var data = e.params.data;
        //     if (data) {
        //         console.log(data)
        //     }
        // });
        $('#select2anios').on('change', function (e) {
            var data = $('#select2anios').select2("val");
            @this.set('anios', data);
        });
        $('#selectcategories').on('change', function (e) {
            var data = $('#selectcategories').select2("val");
            @this.set('categoryid', data);
        });
       
    })
</script>
