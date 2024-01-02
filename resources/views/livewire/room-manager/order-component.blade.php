@section('title','Pedidos')

<div>
 
    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                  
          
                    <div class="container">
                        <div class="row">
                            <div class="form-group mb-2 mt-2 col-md-3">
                                <input type="date" wire:model.live='startdate' class="form-control form-control-sm" placeholder="Pesquisar por Código">
                             </div>
                             <div class="form-group mb-2 mt-2 col-md-3">
                               <input type="date" wire:model.live='enddate' class="form-control form-control-sm" placeholder="Código">
                            </div>
                            <div class="col-md-4 form-group">
                                <button class="btn btn-sm btn-success mt-1" title="Exportar Excel" wire:click='export'><i class="fas fa-file-excel"></i></button>
                                <button class="btn btn-sm  mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar PDF" wire:click='exportPdf'><i class="fas fa-file-pdf"></i></button>
                            </div>
                        </div>
                    </div>

                
            </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Forma de Pagamento</th>
                                    <th>Total</th>
                                    <th>Estado de Pagamento</th>
                                    <th>Detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                              @if (isset($data) and $data->count() > 0)
                                  @foreach ($data as $item)
                                      <tr>
                                        <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i')}}</td>
                                        <td>{{$item->paymenttype}}</td>
                                        <td>{{number_format($item->total,2,',','.')}} Kz</td>
                                        @if ($item->status == 'pago')
                                        <td><span class="badge badge-success">Pago</span>
                                        </td>
                                        @else
                                        <td><span class="badge badge-danger">Pendente</span></td>
                                        @endif
                                        <td>
                                            <button class="btn btn-sm" style=" background-color: #222831e5;color:#fff;" wire:click='viewItems({{$item->id}})' data-bs-toggle='modal' data-bs-target='#detailorder'>
                                                <i class="fa fa-list"></i>
                                            </button>
                                        </td>
                                      </tr>
                                  @endforeach
                                  @else
                                  <tr>
                                    <td colspan="5">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                            <i class="fa fa-5x fa-caret-down text-muted"></i>
                                            <p class="text-muted">A consulta não retornou nenhum resultado</p>
                                        </div>
                                    </td>
                                </tr>
                              @endif
                            </tbody>
                         
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    @include('livewire.room-manager.modals.details-order-modal')
</div>



