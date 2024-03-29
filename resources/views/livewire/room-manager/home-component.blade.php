@section('title','Pedidos Anotados')
<div class="container">
    <div class="row  mt-2">
        <div class="col-md-4">
            <div class="input-group" wire:ignore>
              <select wire:model.live='tableNumber'  name="tableNumber" id="tableNumber" class="form-select text-uppercase selectTable">
                <option value="" select>
                  --Selecionar Mesa--
                </option>
                @if (isset($allTables) and $allTables->count() > 0)
                    @foreach ($allTables as $item)
                    <option value="{{$item->number}}">{{$item->number}}</option>
                    @endforeach
                @endif
              </select>
            </div>
        </div> 
        @if (isset($itemsOrder) || isset($drinksOrder))
        <div class="text-start container">
            <hr>
                 <h4 class="text-uppercase">Outros Pedidos</h4>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-striped table-hover table-sm text-center">
                <thead class="card-header-custom card-header">
                    <tr>
                       
                        <th>TEMPO</th>
                        <th>MESA</th>
                        <th>ESTADO</th>
                        <th>ITEM</th>
                        <th>PREÇO</th>
                        <th>QTD</th>
                        <th>SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                        @if (count($itemsOrder) > 0)
                       
                        @foreach ($itemsOrder as $item)
                        <tr>
                             @if($item->status == 'PRONTO')
                              <td>...</td>
                             @else
                                <td>{{($item->created_at != null) ? $item->created_at->diffForHumans(): ''}}</td>
                             @endif
                            <td class="fw-bold">{{$item->table}}</td>
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
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm text-center">
                <thead class="card-header-custom card-header">
                    <tr>
                        <th>TEMPO</th>
                        <th>MESA</th>
                        <th>ESTADO</th>
                        <th>ITEM</th>
                        <th>PREÇO</th>
                        <th>QTD</th>
                        <th>SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($drinksOrder) > 0)
                        @foreach ($drinksOrder as $item)
                        <tr>
                             @if($item->status == 'PRONTO')
                              <td>...</td>
                             @else
                                <td>{{($item->created_at != null) ? $item->created_at->diffForHumans(): ''}}</td>
                             @endif
                            <td class="fw-bold">{{$item->table}}</td>
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


@push('selects')
     
 
<script>
  $(document).ready(function() {
      $('.selectTable').select2({
        theme: "bootstrap-5",
        width:'100%',
      });
    
      $('.selectTable').change(function (e) { 
        e.preventDefault();
        @this.set('tableNumber', $('.selectTable').val());
      });
  });
  </script>

@endpush


 
