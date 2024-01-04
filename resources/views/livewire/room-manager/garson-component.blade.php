@section('title','Garçons')
<div>
    <div class="row ">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header col-md-12">
                    <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap">
                        <div class="col-md-8 d-flex justify-content-start align-items-center flex-wrap">
                            <div class="form-group col-md-4 mt-2">
                                <input type="date" wire:model.live='startdate' class="form-control form-control-sm" placeholder="Pesquisar por Código">
                            </div>
                            <div class="form-group col-md-4 mt-2 mx-2">
                                <input type="date" wire:model.live='enddate' class="form-control form-control-sm" placeholder="Código">
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                           <button class="btn btn-sm " style=" background-color: #222831e5;color:#fff;" data-bs-toggle="modal" data-bs-target="#garsons">
                                Atribuir Mesa
                           </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                       
                        <table id="example" class=" text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Garçon</th>
                                    <th>Mesas</th>
                                    <th>Data de Abertura</th>
                                    <th>Data de Fecho</th>
                                    <th>Estado</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($garsons) and $garsons->count() > 0)
                                    @foreach ($garsons as $item)
                                    <tr>
                                       <td>{{$item->user->name}} {{$item->user->lastname}}</td>
                                        <td>
                                            {{$item->table ?? 'N/D'}}
                                       </td> 

                                       <td>{{\Carbon\Carbon::parse($item->start)->format('d-m-Y')}} {{\Carbon\Carbon::parse($item->starttime)->format('H:i')}}</td>
                                       @if ($item->end != null and $item->endtime)
                                       <td>{{\Carbon\Carbon::parse($item->end)->format('d-m-Y')}} {{\Carbon\Carbon::parse($item->endtime)->format('H:i')}}</td>
                                           
                                       @else
                                       <td>N/D</td>
                                       @endif
                                       <td><span class="badge  {{($item->status === 'Turno Aberto') ? 'badge-success' : 'badge-danger'}}">{{$item->status}}</span></td>
                                       <td>
                                    
                                      
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#garsons"  wire:click='editTable({{$item->id}})' >
                                            <i  class="fa fa-edit"></i>
                                        </button>
                                       </td>
                                    </tr>
                                        
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="6">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                            <i class="fa fa-5x fa-caret-down text-muted"></i>
                                            <p class="text-muted">A CONSULTA NÃO RETORNOU NENHUM RESULTADO</p>
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
 @include('livewire.room-manager.modals.garson-modal') 
</div>



 
@push('select2-garson')

  <script>
    $(document).ready(function() {
        $('.selectgarson').select2({
          theme: "bootstrap-5",
          width:'100%',
          dropdownParent: $('#garsons')
        });
      
        $('.selectgarson').change(function (e) { 
          e.preventDefault();
          @this.set('garson', $('.selectgarson').val());
        });
    });
    </script>



@endpush 

@push('select2-tables')
<script>
    $(document).ready(function() {
        $('.selecttable').select2({
          theme: "bootstrap-5",
          width:'100%',
          dropdownParent: $('#garsons')
        });

      
        $('.selecttable').change(function (e) { 
          e.preventDefault();
          @this.set('table', $('.selecttable').val());
        });
    });
    </script>
@endpush


<script>
    document.addEventListener('clear',function(){
        location.reload();
    })
    
</script>