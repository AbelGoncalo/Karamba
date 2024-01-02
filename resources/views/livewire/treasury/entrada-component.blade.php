<div>
    @section('title','Encomendas')
    <div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">PAINEL DE TESOUREIRO</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Entradas</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
    
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
    
    
                            <div class="col-md-10 d-flex">
                                <div class="input-group mb-2 mt-2 col-md-4">
                                    <input type="date" wire:model.live='startdate' class="form-control form-control-sm" placeholder="Pesquisar por Código">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    </div>
                                 </div>
                                 <div class="input-group mb-2 mt-2 col-md-4">
                                   <input type="date" wire:model.live='enddate' class="form-control form-control-sm" placeholder="Código">
                                   <div class="input-group-prepend">
                                     <span class="input-group-text"><i class="fa fa-search"></i></span>
                                   </div>
                                </div>
    
                                <div class="col-md-4 " style="margin-left: 15rem">
                                    <button class="btn btn-sm btn-primary mt-2" wire:click='exportExcel'><i class="fas fa-file"></i> Exportar Excel</button>
                                    <button class="btn btn-sm btn-primary mt-2" wire:click='exportCsv'><i class="fas fa-file"></i> Exportar CVS</button>
    
                                </div>
                            </div>
    
                    </div>
                    <div class="card-body">
                        @if (isset($deliveries) and $deliveries->count() > 0)
    
                        <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap mt-1 mb-1">
                            <h4 class="text-uppercase text-success fw-bold">Total Arrecadado: {{number_format($totalDelivery,2,',','.')}} Kz</h4>
    
    
                            {{-- <button class="btn btn-sm  mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar PDF" wire:click='export("pdf")'><i class="fas fa-file-pdf"></i></button>
                            <button class="btn btn-sm  mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar Excel" wire:click='export("xls")'><i class="fas fa-file-excel"></i></button> --}}
    
                        </div>
                        <div class="table-responsive-xl">
                            <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100vw">
                                <thead>
                                    <tr>
    
    
                                            <th>
                                                Cliente
                                            </th>
                                            <th>
                                                Telefones
                                            </th>
    
    
                                              <th>
                                               Forma de Pagamento
                                              </th>
                                              <th>
                                               Tot. Desconto
                                              </th>
                                              <th>
                                               Valor Entrega
                                              </th>
                                              <th>
                                               Total
                                              </th>
                                              <th>
                                               Recibo
                                              </th>
    
                                             <th>
                                               Estado
                                             </th>
                                              <th>
                                                Ações
                                              </th>
                                    </tr>
                                </thead>
                                <tbody>
    
                                        @foreach ($deliveries as $item)
    
    
                                        <tr>
                                            <td>{{$item->customername}} {{$item->customerlastname}}</td>
                                            <td>
                                                {{$item->customerphone}} <br>
                                                {{$item->customerotherPhone}}
                                            </td>
                                               <td>
                                                {{$item->customerprovince}} <br>
                                                {{$item->customermunicipality}} <br>
                                                {{$item->customerstreet}} <br>
                                               </td>
    
                                               <td>
                                                {{number_format($item->discount,2,',','.')}}Kz
                                               </td>
                                               <td>
                                                {{number_format($item->locationprice,2,',','.')}}Kz
                                               </td>
                                               <td>
                                                {{number_format($item->total,2,',','.')}}Kz
                                               </td>
                                               <td>
                                                    <i wire:click='download({{$item->id}})' style="cursor: pointer" title="Baixar Comprovativo" class="fa fa-file-pdf fa-3x"></i>
                                               </td>
                                               <td>
                                                <select wire:change='changeStatus({{$item->id}})' wire:model='statusvalue.{{$item->id}}' name="statusvalue" id="statusvalue" class="form-control">
                                                    <option value="" selected >{{$item->status}}</option>
                                                    <option value="Em Transito">Em Transito</option>
                                                    <option value="Entregue">Entregue</option>
                                                    <option value="Pendente">Pendente</option>
                                                </select>
                                               </td>
                                            <td>
                                                <button wire:click='viewItems({{$item->id}})' data-toggle="modal" data-target="#detail-delivery" class="btn btn-sm btn-primary mt-1"><i class="fa fa-list"></i></button>
                                            </td>
                                        </tr>
    
                                        @endforeach
    
                                    @else
                                    <tr>
                                        <td colspan="10">
                                            <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                                <i class="fa fa-5x fa-caret-down text-muted"></i>
                                                <p class="text-muted">Nenhuma Entrada </p>
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
    
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
    
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item pageheader-title"><a href="#" class="breadcrumb-link">Pedidos</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
    
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
    
    
                            <div class="col-md-10 d-flex">
    
                                <div class="col-md-4 " style="margin-left: 54rem">
                                    <button class="btn btn-sm btn-primary mt-2" wire:click='exportExcel'><i class="fas fa-file"></i> Exportar Excel</button>
                                    <button class="btn btn-sm btn-primary mt-2" wire:click='exportCsv'><i class="fas fa-file"></i> Exportar CVS</button>
    
                                </div>
                            </div>
    
                    </div>
                    <div class="card-body">
    
                        <div class="table-responsive-xl">
                            <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100vw">
                                <thead>
                                    <tr>
    
                                            <th>Company</th>
                                            <th> Cliente </th>
                                            <th> user </th>
                                            <th> Forma de Pagamento</th>
                                            <th>  Tot. Desconto </th>
                                            <th> Valor Entrega </th>
                                            <th>  Total  </th>
                                            <th>Recibo </th>
                                            <th>Estado </th>
                                            <th> Ações </th>
    
    
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($orders) and $orders->count() > 0)
                                        @foreach ($orders as $order)
    
    
                                        <tr>
                                            <td>{{$order->company_id}} </td>
                                            <td>
                                                {{$order->client}}
    
                                            </td>
                                            <td>
                                                {{$order->user_id}} <br>
    
                                            </td>
    
                                            <td>
                                                {{$order->paymenttype}} <br>
    
                                            </td>
    
                                               <td>
                                                {{number_format($order->discount,2,',','.')}}Kz
                                               </td>
                                               <td>
                                                {{number_format($order->locationprice,2,',','.')}}Kz
                                               </td>
                                               <td>
                                                {{number_format($order->total,2,',','.')}}Kz
                                               </td>
                                               <td>
                                                    <i wire:click='download({{$order->id}})' style="cursor: pointer" title="Baixar Comprovativo" class="fa fa-file-pdf fa-3x"></i>
                                               </td>
                                               <td>
                                                <select wire:change='changeStatus({{$order->id}})' wire:model='statusvalue.{{$order->id}}' name="statusvalue" id="statusvalue" class="form-control">
                                                    <option value="" selected >{{$order->status}}</option>
                                                    <option value="Em Transito">Em Transito</option>
                                                    <option value="Entregue">Entregue</option>
                                                    <option value="Pendente">Pendente</option>
                                                </select>
                                               </td>
                                            <td>
                                                <button wire:click='viewItems({{$order->id}})' data-toggle="modal" data-target="#detail-order" class="btn btn-sm btn-primary mt-1"><i class="fa fa-list"></i></button>
                                            </td>
                                        </tr>
    
                                        @endforeach
                                        <p>Total de Pedidos:  {{number_format($totalOrder,2,',','.')}} </p>
                                    @else
                                    <tr>
                                        <td colspan="10">
                                            <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                                <i class="fa fa-5x fa-caret-down text-muted"></i>
                                                <p class="text-muted">Nenhuma Entrada </p>
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
        @include('livewire.treasury.modals.details-delivery-modal')
        @include('livewire.treasury.modals.details-order-modal')
    
    </div>
</div>


<script>
    document.addEventListener('close',function(){
       $("#cupon").modal('hide');
    })
    
</script>
