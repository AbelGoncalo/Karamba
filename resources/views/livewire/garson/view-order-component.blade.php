@section('title','Pedidos Anotados')
<div class="container" style="height: 100vh">
    <div class="row  mt-5">
        <div class="col-md-4">
            <div class="input-group" wire:ignore>
              <select wire:model.live='tableNumber'  name="tableNumber" id="tableNumber" class="form-select text-uppercase selectNoteOrder">
                <option value="" select>
                  --Selecionar Mesa--
                </option>
                @if (isset($allTables) and $allTables->count() > 0)
                    @foreach ($allTables as $item)
                            <option value="{{$item->table}}">{{$item->table}}</option>
                    @endforeach
                @endif
              </select>
            </div>
        </div> 
        @if (isset($itemsOrder) ||  count($itemsOrder) > 0  || isset($drinksOrder) ||  count($drinksOrder) > 0)
        <div class="text-start container">
            <hr>
                 <h4 class="text-uppercase">Outros Pedidos</h4>
            <hr>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-striped table-hover table-sm text-center">
                <thead class="card-header-custom card-header">
                    <tr>
                        
                        <th>TEMPO</th>
                        <th>ESTADO</th>
                        <th>ITEM</th>
                        <th>PREÇO</th>
                        <th>QTD</th>
                        <th>SUBTOTAL</th>
                        <th>AÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                        @if (count($itemsOrder) > 0)                       
                        @foreach ($itemsOrder as $item)
                        @include("livewire.garson.modals.dailydish-info")

                        <tr>
                            @if ($item->status != 'ENTREGUE')
                                <td>{{($item->created_at != null) ? $item->created_at->diffForHumans(): ''}}</td>
                            @else
                             <td>...</td>
                            @endif
                            @if ($item->status == 'PENDENTE')

                            <td class="fw-bold text-danger">{{$item->status}}</td>
                            @elseif($item->status == 'ENTREGUE')

                            <td class="fw-bold text-success }}">{{$item->status}} <br> (Aguardando Pagamento)</td>

                            @else
                            <td class="fw-bold text-primary }}">{{$item->status}}</td>

                            @endif

                            <td>{{$item->name}}</td>
                            <td>{{number_format($item->price,2,',','.')}} Kz</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{number_format(($item->price * $item->quantity),2,',','.')}} Kz</td>
                            @if ($item->status != 'ENTREGUE')
                            <td>
                                @if ($item->status == 'PENDENTE')
                                <button wire:click='getDailydish({{$item->id}})' data-bs-toggle="modal" data-bs-target="#dailydish" class="{{$item->name != 'Menu Executivo' or 'Menu Karamba' ? 'd-none' : ''}} btn btn-sm btn-primary mt-1">
                                    <i class="fa  fa-circle-info"></i>
                                </button>                            

                                <button wire:click='confirm({{$item->id}})' class="btn btn-sm btn-danger mt-1">
                                    <i class="fa fa-times"></i>
                                </button>
                                <button wire:click='findItem({{$item->id}})' data-bs-toggle="modal" data-bs-target="#changequantity" class="btn btn-sm button-order mt-1">
                                    <i class="fa fa-list"></i>
                                </button>
                                @endif
                                @if ($item->status == 'PRONTO')
                                <button wire:click='confirmChangeStatus({{$item->id}})' class="btn btn-sm btn-success mt-1" title="Marcar como entregue">
                                    <i class="fa fa-check"></i>
                                </button>
                                @endif
                            </td>
                                
                            @else
                                <td>...</td>
                            @endif
                        </tr>
                        @endforeach
                             
                        @else
                        <tr>
                            <td colspan="7" class="text-uppercase">A consulta não retorno nenhum resultado</td>
                        </tr>
                        @endif
                </tbody>
            </table>
        </div>
        @if (isset($drinksOrder) and count($drinksOrder) > 0)
        <div class="text-start container">
            <hr>
                 <h4 class="text-uppercase">Bebidas</h4>
            <hr>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm text-center">
                <thead class="card-header-custom card-header">
                    <tr>
                        <th>TEMPO</th>
                        <th>ESTADO</th>
                        <th>ITEM</th>
                        <th>PREÇO</th>
                        <th>QTD</th>
                        <th>SUBTOTAL</th>
                        <th>AÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($drinksOrder) > 0)
                        @foreach ($drinksOrder as $item)
                        <tr>
                            @if ($item->status != 'ENTREGUE')
                                <td>{{($item->created_at != null) ? $item->created_at->diffForHumans(): ''}}</td>
                            @else
                            <td>...</td>
                            @endif
                            @if ($item->status == 'PENDENTE')
                            <td class="fw-bold text-danger">{{$item->status}}</td>
                            @elseif($item->status == 'ENTREGUE')

                            <td class="fw-bold text-success }}">{{$item->status}} <br> (Aguardando Pagamento)</td>

                            @else
                            <td class="fw-bold text-primary }}">{{$item->status}}</td>

                            @endif

                            <td>{{$item->name}}</td>
                            <td>{{number_format($item->price,2,',','.')}} Kz</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{number_format(($item->price * $item->quantity),2,',','.')}} Kz</td>
                            @if ($item->status != 'ENTREGUE')
                            <td>
                                @if ($item->status == 'PENDENTE')
                                <button wire:click='confirm({{$item->id}})' class="btn btn-sm btn-danger mt-1">
                                    <i class="fa fa-times"></i>
                                    
                                </button>
                                <button wire:click='findItem({{$item->id}})' data-bs-toggle="modal" data-bs-target="#changequantity" class="btn btn-sm button-order mt-1">
                                    <i class="fa fa-list"></i>
                                </button>
                                @endif
                                @if ($item->status == 'PRONTO')
                                <button wire:click='confirmChangeStatus({{$item->id}})' class="btn btn-sm btn-success mt-1" title="Marcar como entregue">
                                    <i class="fa fa-check"></i>
                                </button>
                                @endif
                            </td>
                            @else
                                 <td>...</td>
                             @endif
                            
                        </tr>
                        @endforeach
                             
                        @else
                        <tr>
                            <td colspan="7" class="text-uppercase">A consulta não retorno nenhum resultado</td>
                        </tr>
                        @endif
                </tbody>
            </table>
        </div>
        @endif
        @else
        <div class="rounded d-flex justify-content-center align-items-center flex-column mt-2" style="height: 20rem;border:1px dashed #000">
            <h5 class="text-muted text-size text-center text-uppercase text-muted">A consulta não retorno nenhum resultado</h5>
        </div>
        @endif
            
      
    </div>
    @include('livewire.client.modals.change-quantity')


</div>



<script>
    document.addEventListener('refresh',function(){
        location.reload();
    })
    
</script>


@push('select-garson')
<script>
     $(document).ready(function() {
        $('.selectNoteOrder').select2({
          theme: "bootstrap-5",
          width:'100%',

        });
      
        $('.selectNoteOrder').change(function (e) { 
          e.preventDefault();
          @this.set('tableNumber', $('.selectNoteOrder').val());
          @this.getOrders();
        });
        });
</script>


<script>
    document.addEventListener('close',function(){
       $("#changequantity").modal('hide');
       @this.getOrders();
    })
    
</script>
@endpush
