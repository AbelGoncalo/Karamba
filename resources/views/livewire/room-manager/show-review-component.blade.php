@section('title','Relatórios')
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
                    <label for="">Data</label>
                    <input type="date" wire:model.live='date' name="startdate" id="date" class="form-control">
                </div>
            </div>
           </div>
        </div>
       </div>

       <div class="card">
        <div class="card-body">
            @if (isset($reviews) and count($reviews) > 0)
            <div class="table-responsive">
                <table class="table text-center table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Comentário</th>
                            <th>Avaliação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $item)
                        <tr>
                            <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i')}}</td>
                            <td>{{$item->comment ?? 'N/D'}}</td>
                            <td> 
                         
                           
                             @if ($item->star_number == '1')
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star"></i>
                             <i class="fa fa-star"></i>
                             <i class="fa fa-star"></i>
                             <i class="fa fa-star"></i>
                             @elseif ($item->star_number == '2')
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star"></i>
                             <i class="fa fa-star"></i>
                             <i class="fa fa-star"></i>
                             @elseif ($item->star_number == '3')
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star"></i>
                             <i class="fa fa-star"></i>
                             @elseif ($item->star_number == '4')
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star"></i>
                             @elseif ($item->star_number == '5')
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             <i class="fa fa-star" style="color: #ffe400"></i>
                             @endif
                             
                            
                              
                            </td>
                        </tr>
                        @endforeach
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
