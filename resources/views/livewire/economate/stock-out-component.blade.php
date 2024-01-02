@section('title','Entrada de Estoque')
<div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE GESTÃO DE ECONOMATO</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Entrada de Estoque</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between   align-items-center flex-wrap">
                  
                    <div class="col-md-9 d-flex">
                        <div class="input-group mb-2 mt-2 col-md-4">
                            <input type="date" wire:model.live='startdate' class="form-control form-control-sm" placeholder="Pesquisar por Código">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                         </div>
                         <div class="input-group mb-2 mt-2 col-md-4">
                           <input type="date" wire:model.live='enddate' class="form-control form-control-sm" placeholder="Código">
                           <div class="input-group-prepend">
                             <span class="input-group-text"><i class="fa fa-search"></i></span>
                           </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-sm btn-success mt-1" title="Exportar Excel" wire:click='export'><i class="fas fa-file-excel"></i></button>
                        <button class="btn btn-sm  mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar PDF" wire:click='reportPdf'><i class="fas fa-file-pdf"></i></button>
                        <button class="btn btn-sm btn-primary mt-1" data-toggle="modal" data-target="#stockout"><i class="fa fa-plus"></i> Registrar</button>
                    </div>
                        
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Utilização</th>
                                    <th>Unidade</th>
                                    <th>Responsável</th>
                                    <th>Origem</th>
                                    <th>Destino</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($stockouts) and $stockouts->count() > 0)
                                    @foreach ($stockouts as $item)
                                    <tr>
                                        <td>{{\Carbon\Carbon::parse($item->create_at)->format('d-m-Y')}}</td>
                                        <td>{{$item->product_economate->description}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{$item->usetype}}</td>
                                        <td class="text-uppercase">{{$item->unit}}</td>
                                        <td>{{$item->chef}}</td>
                                        <td>{{$item->from}}</td>
                                        <td>{{$item->to}}</td>
                                        <td>
                                            <button wire:click='editstockout({{$item->id}})' data-toggle="modal" data-target="#stockout" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></button>
                                            {{-- <button wire:click='confirm({{$item->id}})' class="btn btn-sm btn-danger mt-1"><i class="fa fa-trash"></i></button> --}}
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="9">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                            <i class="fa fa-5x fa-caret-down text-muted"></i>
                                            <p class="text-muted">A consulta não retorno nenhum resultado</p>
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
    @include('livewire.economate.modals.stockout-economate')
</div>

@push('select2-from')
<script>
$(document).ready(function() {
    $('.select-from').select2({
      theme: "bootstrap",
      width:"100%",
      dropdownParent: $('#stockout')

    });
  
    $('.select-from').change(function (e) { 
      e.preventDefault();
     
      @this.set('from', $('.select-from').val());
    });
});
</script>
@endpush


@push('select2-to')
<script>
$(document).ready(function() {
    $('.select-to').select2({
      theme: "bootstrap",
      width:"100%",
      dropdownParent: $('#stockout')

    });
  
    $('.select-to').change(function (e) { 
      e.preventDefault();
     
      @this.set('to', $('.select-to').val());
    });
});
</script>
@endpush

@push('select2-economate')
<script>
    $(document).ready(function() {
        $('.select2-stockout').select2({
          theme: "bootstrap",
          width:"100%"
        });
      
        $('.select2-stockout').change(function (e) { 
          e.preventDefault();
         
          @this.set('product_economate_id', $('.select2-stockout').val());
        });
    });
    </script>
@endpush
<script>
    document.addEventListener('close',function(){
       $("#stockout").modal('hide');
    })
    
</script>