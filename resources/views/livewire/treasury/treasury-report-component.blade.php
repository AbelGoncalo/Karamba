@section('title','Relatórios')
<div>
   <div class="container">
   
       <div class="card">
            <div class="card-header">
                <div class="container">
                    <div class="row">
                        <div class="alert alert-info col-md-12">
                            <i class="fa fa-info-circle text-dark"></i>
                            <span>Para poder visualizar os dados deve filtrar por intervalo de datas, informando a data inicial e a final</span>
                        </div>
                    </div>
                </div>
              <div class="container">
                <div class="row">
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
                </div>
              </div>
             
            </div>
        <div class="card-body">
            @if (isset($data) and count($data) > 0)
            <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap mt-1 mb-1">
                <div class="form-group">
                    <h4>RELATÓRIO DE ENCOMENDAS</h4>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm  mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar EXCEL" wire:click='export("delivery")'>
                        <i class="fas fa-file-excel"></i>
                    </button>
                    <button wire:click='PrintDelivery' class="btn btn-primary btn-sm mt-1" title="Exportar dados em PDF">
                        <i class="fa fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="container ">
                <div class="row text-start">
                      <h4 class="text-uppercase text-success fw-bold">Total Arrecadado: {{number_format($totalDelivery,2,',','.')}} Kz</h4>
                  </div>
              </div>
            <div class="table-responsive">
                <table class="table text-center table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Forma de Pagamento</th>
                            <th>Desconto</th>
                            <th>Total</th>
                            <th>Telefones </th>
                            <th>Estado</th>
                            
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{$item->customername ?? ''}} {{$item->customerlastname ?? ''}}</td>
                            
                            <td>{{$item->customerpaymenttype}}</td>
                            <td>{{$item->discount ?? ''}} </td>
                            <td>{{number_format($item->total,2,',','.')}} Kz</td>
                            <td>{{$item->customerphone ?? ''}} </td>
                            <td>{{$item->status ?? ''}} </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            @else
            <div class="rounded d-flex justify-content-center align-items-center flex-column mt-2" style="height: 5rem;border:1px dashed #000">
                <h5 class="text-muted text-size text-center text-uppercase text-muted">A consulta não retorno nenhuma encomenda</h5>
            </div>
            @endif
        </div>
       </div>

       <div class="card">
        <div class="card-body">
            @if (isset($data) and count($data) > 0)
            <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap mt-1 mb-1">
                <div class="form-group">
                    <h4>RELATÓRIO DE PEDIDOS</h4>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm  mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar EXCEL" wire:click='export("orders")'>
                        <i class="fas fa-file-excel"></i>
                    </button>
                    <button wire:click='PrintOrder' class="btn btn-primary btn-sm mt-1" title="Exportar dados em PDF">
                        <i class="fa fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="container text-start">
                    <h4 class="text-uppercase text-success fw-bold">Total Arrecadado: {{number_format($totalOrder,2,',','.')}} Kz</h4>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-center table-striped table-hover">
                    <thead>
                        <tr>
                           
                                   
                                
                                <th> Cliente </th>   
                               
                                <th> Forma de Pagamento</th> 
                                <th>  Tot. Desconto </th>
                                <th> Valor Entrega </th>
                                <th>  Total  </th>
                                <th>Estado </th>      
                               
                                 
                       
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)

                                       
                                    <tr>
                                       
                                        <td>
                                            {{$order->client}}
                                           
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
                                           <td>{{$order->status}}</td>
                                          
                                           
                                       
                                    </tr>
                                        
                                    @endforeach

                    </tbody>
                </table>
                
            </div>
            @else
            <div class="rounded d-flex justify-content-center align-items-center flex-column mt-2" style="height: 5rem;border:1px dashed #000">
                <h5 class="text-muted text-size text-center text-uppercase text-muted">A consulta não retorno nenhum pedido</h5>
            </div>
            @endif
        </div>
       </div>

   </div>
</div>

