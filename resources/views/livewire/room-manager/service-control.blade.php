

@section('title','TEMPO DE ENTREGA')
<div>
   <div class="container">
    <div class="row">
       <div class="card">
        <div class="card-header">
            <h4>FILTRAR</h4>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
               
                <div class="form-group col-md-3">
                    <label for="">Data Inicial</label>
                    <input type="date" wire:model.live='startdate' name="startdate" id="startdate" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Data Final</label>
                    <input type="date" wire:model.live='enddate' name="enddate" id="enddate" class="form-control">
                </div>
            </div>
           </div>
        </div>
       </div>

       <div class="card">
        <div class="card-body">
            @if (isset($list) and count($list) > 0)
            <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap mt-1 mb-1">
                <h4 class="text-uppercase  fw-bold" style="color: #222831e5;">Média de Tempo: {{ceil($avgtime)}} Segundos</h4>
                <h4 class="text-uppercase  fw-bold" style="color: #222831e5;">Equivalente à: {{gmdate('H:i:s',$avgtime)}}</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm text-center">
                    <thead class="card-header-custom card-header">
                        <tr>
                            <th>DATA</th>
                            <th>ITEM</th>
                            <th>TEMPO(S)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($list) and count($list) > 0)
                            @foreach ($list as $item)
                            <tr>
                               <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i')}}</td>
                               <td>{{$item->item}}</td>
                               <td>{{$item->time}} s</td>
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
            @else
            <div class="rounded d-flex justify-content-center align-items-center flex-column mt-2" style="height: 5rem;border:1px dashed #000">
                <h5 class="text-muted text-size text-center text-uppercase text-muted">A consulta não retorno nenhum resultado</h5>
            </div>
            @endif
        </div>
       </div>
    </div>
   </div>
</div>




 
