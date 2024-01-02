@section('title','Reservas')
<div class="container">
    <div class="row  mt-2">
  
       
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm text-center">
                <thead class="card-header-custom card-header">
                    <tr>
                        <th>DATA</th>
                        <th>VALIDADE</th>
                        <th>CLIENTE</th>
                        <th>E-MAIL</th>
                        <th>NºPESSOAS</th>
                        <th>ESTADO</th>
                        <th>AÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($reserves) and count($reserves) > 0)
                        @foreach ($reserves as $item)
                        <tr>
                           <td>{{\Carbon\Carbon::parse($item->datetime)->format('d-m-Y H:i')}}</td>
                           <td>{{\Carbon\Carbon::parse($item->expiratedate)->format('d-m-Y H:i')}}</td>
                           <td>{{$item->client}}</td>
                           <td>{{$item->email}}</td>
                           <td>{{$item->clientCount}}</td>
                           @if ($item->datetime > today())
                           <td class="text-success fw-bold">Válida</td>
                           @else
                           <td class="text-danger fw-bold">Inválida</td>
                           @endif
                           <td>
                            <button wire:click = 'confirm({{$item->id}})' class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                           </td>
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
        
            
      
    </div>
   

</div>


 
