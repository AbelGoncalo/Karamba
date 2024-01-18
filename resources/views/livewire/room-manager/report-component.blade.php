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
                <div class="form-group col-md-3" wire:ignore>
                    <label for="">Mesas</label>
                    <select wire:model.live='searchByTable' name="searchByTable" id="searchByTable" class="form-select selectTableReport">
                        <option value="">--Selecionar--</option>
                        @if (isset($tables) and count($tables) > 0)
                            
                            @foreach ($tables as $item)
                            <option value="{{$item->number}}">{{$item->number}}</option>
                            @endforeach                            
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-3" wire:ignore>
                    <label for="">Garçons</label>
                    <select wire:model.live='searchByGarson' name="searchByGarson" id="searchByGarson" class="form-select selectGarsonReport">
                        <option value="">--Selecionar--</option>
                        @if (isset($garsons) and count($garsons) > 0)
                            
                        @foreach ($garsons as $item)
                        <option value="{{$item->id}}">{{$item->name}} {{$item->lastname}}</option>
                        @endforeach                            
                    @endif
                    </select>
                </div>
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
            @if (isset($data) and count($data) > 0)
            <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap mt-1 mb-1">
                <h4 class="text-uppercase text-success fw-bold">Total Arrecadado: {{number_format($total,2,',','.')}} Kz</h4>
                <button wire:click='Print' class="btn btn-sm" style=" background-color: #222831e5;color:#fff;">
                    <i class="fa fa-file-pdf"></i>
                    EXPORTAR PDF
                </button>

                {{-- <button class="btn btn-sm  mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar PDF" wire:click='export("pdf")'><i class="fas fa-file-pdf"></i></button>
                <button class="btn btn-sm  mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar Excel" wire:click='export("xls")'><i class="fas fa-file-excel"></i></button> --}}

            </div>
            <div class="table-responsive">
                <table class="table text-center table-striped table-hover">
                    <thead>
                        <tr>
                            <th>DATA</th>
                            <th>Garson</th>
                            <th>Mesa</th>
                            <th>Forma de Pagamento</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i')}}</td>
                            <td>{{$item->user->name ?? ''}} {{$item->user->lastname ?? ''}}</td>
                            <td>{{$item->table}}</td>
                            <td>{{$item->paymenttype}}</td>
                            <td>{{number_format($item->total,2,',','.')}} Kz</td>
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


@push('selects')
     
 
<script>
  $(document).ready(function() {
      $('.selectTableReport').select2({
        theme: "bootstrap-5",
        width:'100%',
      });
    
      $('.selectTableReport').change(function (e) { 
        e.preventDefault();
        @this.set('searchByTable', $('.selectTableReport').val());
      });

      $('.selectGarsonReport').select2({
        theme: "bootstrap-5",
        width:'100%',
      });
    
      $('.selectGarsonReport').change(function (e) { 
        e.preventDefault();
        @this.set('searchByGarson', $('.selectGarsonReport').val());
      });
  });
  </script>

@endpush
