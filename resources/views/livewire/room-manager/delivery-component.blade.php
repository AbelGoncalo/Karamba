@section('title','Encomendas')
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

                            <div class="col-md-4 form-group mt-1">
                                <button class="btn btn-sm btn-success mt-1" title="Exportar Excel" wire:click='export'><i class="fas fa-file-excel"></i></button>
                                <button class="btn btn-sm mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar PDF" wire:click='exportPdf'><i class="fas fa-file-pdf"></i></button>
                            </div>
                        </div>

                    </div>


                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100vw">
                            <thead>
                                <tr>
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
                                           Estado Actual
                                         </th>
                                          <th>
                                           Mudar Estado
                                         </th>
                                          <th>
                                            Ações
                                          </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($deliveries) and $deliveries->count() > 0)
                                    @foreach ($deliveries as $item)
                                    <tr>
                                        <td>{{$item->customername}} {{$item->customerlastname}}</td>
                                        <td>
                                            {{$item->customerphone}} <br>
                                            {{$item->customerphone}} <br>

                                        </td>
                                        <td>
                                            {{$item->customerpaymenttype}}
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
                                                <i wire:click='download({{$item->id}})' style="cursor: pointer" title="Baixar Comprovativo" class="fa fa-file-pdf  text-dark"></i>
                                           </td>
                                             <td>
                                            {{$item->status}}
                                           </td>
                                           <td>
                                            <select wire:change='changeStatus({{$item->id}})' wire:model='statusvalue.{{$item->id}}' name="statusvalue" id="statusvalue" class="form-select form-select-sm">
                                                <option value="">SELECIONAR</option>
                                                @if ($item->status == 'PENDENTE')
                                                    <option  value="ACEITE">ACEITE</option>
                                                @elseif($item->status == 'PRONTO')
                                                     <option  value="A CAMINHO">A CAMINHO</option>
                                                @elseif($item->status == 'A CAMINHO')
                                                    <option value="ENTREGUE">ENTREGUE</option>
                                                @endif
                                         
                                                
                                            </select>
                                           </td>
                                        <td>
                                            
                                            <button wire:click='viewItems({{$item->id}})' data-bs-toggle="modal" data-bs-target="#detail" class="btn btn-sm  mt-1" style=" background-color: #222831e5;color:#fff;"><i class="fa fa-list"></i></button>
                                        </td>
                                    </tr>

                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="10">
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
    @include('livewire.room-manager.modals.details-modal')
</div>


<script>
    document.addEventListener('close',function(){
       $("#cupon").modal('hide');
    })

</script>