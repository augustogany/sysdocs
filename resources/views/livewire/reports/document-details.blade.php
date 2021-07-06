<div wire:ignore.self id="modalDetails" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Archivos Adjuntos # {{$saleId}}</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-center text-white">FOLIO</th>
                                <th class="table-th text-center text-white">NOMBRE</th>
                                <th class="table-th text-center text-white">EXTENSION</th>
                                <th class="table-th text-center text-white">RUTA</th>
                                <th class="table-th text-center text-white">FECHA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $item)
                                <tr>
                                    <td class="text-center"><h6>{{$item->id}}</h6></td>
                                    <td class="text-center"><h6>{{$item->nombre_origen}}</h6></td>
                                    <td class="text-center"><h6>{{$item->extension}}</h6></td>
                                    <td class="text-center"><h6>{{$item->ruta}}</h6></td>
                                    <td class="text-center"><h6>{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y')}}</h6></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="4">
                                    <h5 class="text-center font-weight-bold">TOTALES:</h5>
                                </td>
                                <td><h5 class="text-center">{{$countDetails}}</h5></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-dark close-btn text-info" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>