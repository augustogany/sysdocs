@push('style')
<link rel="stylesheet" href="{{ asset('css/select2.min.css')}}" type="text/css">
@endpush
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <p> {{$componentName}} | {{$pageTitle}}</p>
                </h4>
                @can('create', App\Models\Document::class)
                <ul class="tabs tab-pills">
                    <li>
                        <a 
                        href="javascript:void(0)" 
                        class="tabmenu bg-dark" 
                        wire:click.prevent="nuevo()"
                        >
                            Agregar
                        </a>
                    </li>
                </ul>
                @endcan
            </div>
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">DESCRIPCION</th>
                                <th class="table-th text-white text-center">CATEGORIA</th>
                                <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($documents as $document)
                                @can('viewAny', $document)
                                <tr>
                                    <td><h6 class="text-left">{{$document->name}}</h6></td>
                                    <td><h6 class="text-center">{{$document->category}}</h6></td>
                                    <td class="text-center">
                                        @can('view',$document)
                                        <a href="javascript:void(0)" 
                                        wire:click="Edit({{$document->id}})"
                                        class="btn btn-dark mtmobile" 
                                        title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete', $document)
                                        <a href="javascript:void(0)" 
                                        onclick="Confirm('{{$document->id}}')"
                                        class="btn btn-dark mtmobile" 
                                        title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @endcan
                            @empty
                                <tr>
                                    <td colspan="2">Sin Datos</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                   {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.documents.form')
</div>
@push('script')
<script src="{{ asset('js/select2.min.js') }}"></script>
@endpush
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        window.livewire.on('document-added', msg => {
            $('#theModal').modal('hide')
        });

        window.livewire.on('document-updated', msg => {
            $('#theModal').modal('hide')
        });

        window.livewire.on('document-deleted', msg => {
            //noty
        });

        window.livewire.on('show-modal', msg => {
            
            $('#theModal').modal('show')
           
        });

        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });

        $('#theModal').on('hidden.bs.modal', function(e) {
            $('.er').css('display','none')
        })

        $('#select2anios').select2({
            allowClear: true
        });
        $('#selectcategories').select2();
    });
   
    function active() {
        $('#theModal').modal('show')
    }
    function Confirm(id)
    {
        let me = this
        swal({
            title: 'CONFIRMAR',
            text: '¿DESEAS ELIMINAR EL REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3B3F5C',//#3B3F5C
            cancelButtonColor: '#fff',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            closeOnConfirm: false
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow',id)
                toastr.success('info', 'Registro eliminado con éxito')
                swal.close()
            }
        })
    }
</script>

