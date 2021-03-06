<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>{{$componentName}}</b></h4>
            </div>
            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Elige el Usuario</h6>
                                <div class="form-group">
                                    <select wire:model="userId" class="form-control">
                                        <option value="0">Todos</option>
                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <h6>Elige el tipo de reporte</h6>
                                <div class="form-group">
                                    <select wire:model="reportType" class="form-control">
                                        <option value="0">Documentos del dia</option>
                                        <option value="1">Documentos por fechas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha desde</h6>
                                <div class="form-group">
                                    <input 
                                        type="text" 
                                        wire:model="dateFrom"
                                        class="form-control flatpickr"
                                        placeholder="Click para elegir"
                                    >
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha hasta</h6>
                                <div class="form-group">
                                    <input 
                                        type="text" 
                                        wire:model="dateTo" 
                                        class="form-control flatpickr"
                                        placeholder="Click para elegir"
                                    >
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button wire:click="$refresh" class="btn btn-dark btn-block">
                                    Consultar
                                </button>
                                <a 
                                    href="{{url('report/pdf' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                                    class="btn btn-dark btn-block {{count($data) <1 ? 'disabled' : ''}}"
                                    target="_blank"
                                >
                                Generar Pdf
                                </a>
                                <a 
                                    href="{{url('report/excel' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                                    class="btn btn-dark btn-block {{count($data) <1 ? 'disabled' : ''}}"
                                    target="_blank"
                                >
                                Exportar a Excel
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <div class="table-responsive">
                            <table class="table table-bordered striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-white text-center">FOLIO</th>
                                        <th class="table-th text-white text-center">DOCUMENTOS</th>
                                        <th class="table-th text-white text-center">ESTADO</th>
                                        <th class="table-th text-white text-center">USUARIO</th>
                                        <th class="table-th text-white text-center">FECHA</th>
                                        <th class="table-th text-white text-center" width="50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $d)
                                        <tr>
                                            <td class="text-center"><h6>{{$d->id}}</h6></td>
                                            <td class="text-center"><h6>{{$d->archives->count()}}</h6></td>
                                            <td class="text-center"><h6>{{$d->status}}</h6></td>
                                            <td class="text-center"><h6>{{$d->user}}</h6></td>
                                            <td class="text-center">
                                                <h6>{{\Carbon\Carbon::parse($d->created_at)->format('d-m-Y')}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <button wire:click="getDetails({{$d->id}})" class="btn btn-dark btn-sm">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Sin Datos</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.reports.document-details')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        flatpickr(document.getElementsByClassName('flatpickr'),{
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayofWeek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mi??", "Jue", "Vie", "S??b"],
                    longhand: [
                    "Domingo",
                    "Lunes",
                    "Martes",
                    "Mi??rcoles",
                    "Jueves",
                    "Viernes",
                    "S??bado",
                    ],
                },
                months: {
                    shorthand: [
                    "Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"
                    ],
                    longhand: [
                    "Enero","Febrero", "Marzo", "Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre",
                    "Noviembre","Diciembre"
                    ],
                }
            }
        })
        window.livewire.on('show-modal', Msg =>{
            $('#modalDetails').modal('show')
        })
    })
</script>