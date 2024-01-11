@section('title','Transferir Items')
<div class="container">
    <div class="row  mt-2">
       
        <div  class="row d-flex justify-content-between align-items-start flex-wrap">
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
           
            <button   data-bs-toggle="modal" data-bs-target="#transferMOdal" class="col-md-2 btn btn-md" style=" background-color: #222831e5;color:#fff;" >
                <i class="fa-solid fa-right-left"></i>
                Transferir</button>
           
        </div>
       
     
        @if (isset($orders) and count($orders) > 0)
    
        <div class="table-responsive mt-3">
            <table class="table table-striped table-hover table-sm text-center">
                <thead class="card-header-custom card-header">
                    <tr>
                      
                        <th style="cursor: pointer"><i class="fa fa-check"></i></th>
                        <th>MESA</th>
                        <th>ESTADO</th>
                        <th>ITEM</th>
                        <th>PREÇO</th>
                        <th>QTD</th>
                        <th>SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                 
                       
                        @foreach ($orders as $item)
                        <tr>
                            <td class="fw-bold">
                                <input  style="cursor: pointer" class="inputCheck" type="checkbox" wire:model='check'  value="{{$item->id}}" name="check" id="check">
                            </td>
                            <td class="fw-bold">{{$item->table}}</td>
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
  
@include('livewire.room-manager.modals.table')
</div>


@push('checkAll')
    <script>
        
        $('.mark').click((e)=>{
            e.preventDefault()
           
            if ($(".inputCheck").prop( "checked")) {
                
                $(".inputCheck").prop( "checked",false)
            }else{
               
                $(".inputCheck").prop( "checked",true)       

            }
        })
        
 
    </script>
@endpush



 
