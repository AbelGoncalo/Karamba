@section('title','Meus Pedidos')
<div class="container">
    <div class="row  mt-5">
        <div class="col-m-12 d-flex justify-content-between align-items-center flex-wrap">
            <p class="mb-3" style="font-size: 20px"> <span class="fw-bold">Senhor(a) </span> <span>{{$client->client ?? ''}}</span> <br> <span class="fw-bold">Número de Pessoas na Mesa:</span><span>{{$client->clientCount ?? ''}}</span></span><br> <span class="fw-bold">{{$client->tableNumber ?? ''}}</span> <br> <span><a class="text-uppercase nav-link  btn btn-sm button-order" href="{{route('client.orders')}}">Fazer Pedido <i class="fa fa-arrow-right"></i></a></span></p>
            <p class="fw-bold text-success" style="font-size: 1.5rem">POR PAGAR: {{number_format($totalOtherItems + $totalDrinks,2,',','.')}} Kz</p>
        </div>
       
            
        @if (isset($itemsOrder)  || isset($drinksOrder) )
            
       
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
                   @if (isset($itemsOrder) and count($itemsOrder) > 0)
                       
                  
                        @foreach ($itemsOrder as $item)
                        <tr>
                            <td>{{$item->created_at->diffForHumans()}}</td>
                            @if ($item->status == 'PENDENTE')
                            <td class="fw-bold text-danger">{{$item->status}}</td>
                            @elseif($item->status == 'ENTREGUE')

                            <td class="fw-bold text-success }}">{{$item->status}} <br> (Aguardando Pagamento)</td>

                            @else
                            <td class="fw-bold text-warning }}">{{$item->status}}</td>

                            @endif

                            <td>{{$item->name}}</td>
                            <td>{{number_format($item->price,2,',','.')}} Kz</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{number_format(($item->price * $item->quantity),2,',','.')}} Kz</td>
                            <td>
                                @if ($item->status == 'PENDENTE')
                                        <button wire:click='confirm({{$item->id}})' class="btn btn-sm btn-danger">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <button wire:click='findItem({{$item->id}})' data-bs-toggle="modal" data-bs-target="#changequantity" class="btn btn-sm button-order">
                                            <i class="fa fa-list"></i>
                                        </button>
                                @else
                                ...
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="text-uppercase">Nenhum pedido encontrado</td>
                        </tr>
                        @endif
                </tbody>
            </table>
        </div>
        @if (isset($drinksOrder) and $drinksOrder->count() > 0)
        <div class="text-center container">
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
                    
                        @foreach ($drinksOrder as $item)
                        <tr>
                            <td>{{$item->created_at->diffForHumans()}}</td>
                            @if ($item->status == 'PENDENTE')
                            <td class="fw-bold text-danger">{{$item->status}}</td>
                            @elseif($item->status == 'ENTREGUE')

                            <td class="fw-bold text-success }}">{{$item->status}} <br> (Aguardando Pagamento)</td>

                            @else
                            <td class="fw-bold text-warning }}">{{$item->status}}</td>

                            @endif

                            <td>{{$item->name}}</td>
                            <td>{{number_format($item->price,2,',','.')}} Kz</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{number_format(($item->price * $item->quantity),2,',','.')}} Kz</td>
                            <td>
                                @if ($item->status == 'RECEBIDO')
                                <button wire:click='confirm({{$item->id}})' class="btn btn-sm btn-danger">
                                    <i class="fa fa-times"></i>
                                </button>
                                <button wire:click='findItem({{$item->id}})' data-bs-toggle="modal" data-bs-target="#changequantity" class="btn btn-sm button-order">
                                    <i class="fa fa-list"></i>
                                </button>
                                @else
                                ...
                                @endif
                            </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
        @endif
        @else
        <div class="rounded d-flex justify-content-center align-items-center flex-column mt-2" style="height: 20rem;border:1px dashed #000">
            <h5 class="text-muted text-size text-center text-uppercase text-muted">Ainda não fez nenhum pedido</h5>
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


