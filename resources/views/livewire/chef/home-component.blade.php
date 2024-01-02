@section('title','PAINEL DE CHEFE DE COZINHA')
<div>
    <div class="container">
      
        <div class="row">
            <div class="col-md-4 mb-2" style="margin-left: 1.8rem" wire:ignore>
                <select wire:model.live='tableNumber'   name="tableNumber" id="tableNumber" class="form-select text-uppercase selectTableChef">
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
            <div class="col-md-12">
                 
                        <div class="container">
                            @if (isset($allOrders) and $allOrders->count() > 0)
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
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allOrders as $item)
                                       
                                            <tr>
                                                <td>{{($item->created_at != null) ? $item->created_at->diffForHumans(): ''}}</td>
                                                <td class="fw-bold">{{ $item->table ?? ''}}</td>
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
                                                <td>
                                                    
                                                    @if($item->status == 'PENDENTE')
                                                    <button wire:click='confirmChangeStatus({{$item->id}},"EM PREPARAÇÃO")' data-bs-toggle="modal" data-bs-target="#changequantity" class="btn btn-sm button-custom">
                                                        <i class="fas fa-rotate"></i>
                                                        PREPARA
                                                    </button>
                                                    @elseif($item->status == 'EM PREPARAÇÃO')
                                                    <button wire:click='confirmChangeStatus({{$item->id}},"PRONTO")' data-bs-toggle="modal" data-bs-target="#changequantity" class="btn btn-sm button-custom">
                                                        <i class="fas fa-rotate"></i>
                                                        PRONTO

                                                    </button>
                                                    {{-- @elseif($item->status == 'A CAMINHO')
                                                    <button wire:click='confirmChangeStatus({{$item->id}},"ENTREGUE")' data-bs-toggle="modal" data-bs-target="#changequantity" class="btn btn-sm btn-success">
                                                        <i class="fa fa-handshake"></i>
                                                        Mar como Entregue
                                                    </button> --}}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                         
                                    </tbody>
                                </table>
                            </div>
                    
                                
                            @else
                            <div class="rounded d-flex justify-content-center align-items-center flex-column mt-2" style="height: 20rem;border:1px dashed #000">
                                <h5 class="text-muted text-size text-center text-uppercase text-muted">A consulta não retorno nenhum resultado</h5>
                            </div>
                            @endif
                        </div>
                    
                
            </div>
        </div>
    </div>
</div>
@push('select-chef')
    <script>
         $(document).ready(function() {
      $('.selectTableChef').select2({
        theme: "bootstrap-5",
        width:'100%',
      });
    
      $('.selectTableChef').change(function (e) { 
        e.preventDefault();
        @this.set('tableNumber', $('.selectTableChef').val());
      });
  });
    </script>
@endpush
