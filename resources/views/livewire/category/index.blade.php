<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <p> {{$componentName}} | {{$pageTitle}}</p>
                </h4>
                @can('create', App\Models\Category::class)
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">
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
                                <th class="table-th text-white">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td><h6>{{$category->name}}</h6></td>
                                    <td class="text-center">
                                        @can('update', $category)
                                        <a href="javascript:void(0)" 
                                        wire:click="Edit({{$category->id}})"
                                        class="btn btn-dark mtmobile" 
                                        title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete', $category)
                                        <a href="javascript:void(0)" 
                                        onclick="Confirm('{{$category->id}}')"
                                        class="btn btn-dark" 
                                        title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                         @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">Sin Datos</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                   {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.category.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        });

        window.livewire.on('category-added', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });

        window.livewire.on('category-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });

        window.livewire.on('category-deleted', msg => {
            noty(msg)
        });
    });
    function Confirm(id)
    {
        let me = this
        swal({
            title: 'CONFIRMAR',
            text: '??DESEAS ELIMINAR EL REGISTRO?',
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
                swal.close()
            }
        })
    }
</script>
