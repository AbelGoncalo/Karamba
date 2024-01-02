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
                        <button class="btn btn-sm btn-warning mt-1" data-toggle="modal" data-target="#verifyStock" title="Verificar Estoque" ><i class="fas fa-sync-alt"></i></button>
                        <button class="btn btn-sm btn-success mt-1" title="Exportar Excel" wire:click='export'><i class="fas fa-file-excel"></i></button>
                        <button class="btn btn-sm  mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar PDF" wire:click='reportPdf'><i class="fas fa-file-pdf"></i></button>
                        <button class="btn btn-sm btn-primary mt-1" data-toggle="modal" data-target="#stockenter"><i class="fa fa-plus"></i> Registrar</button>
                    </div>
                        
                    
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Expira</th>
                                    <th>Ingrediente</th>
                                    <th>Unidade</th>
                                    <th>Origem</th>
                                    <th>Fonte</th>
                                    <th>Preço de Compra</th>
                                    <th>Preço Unit. Ponderado</th>
                                    <th>Quantidade</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($stockenters) and $stockenters->count() > 0)
                                    @foreach ($stockenters as $item)
                                    <tr>
                                        <td>{{\Carbon\Carbon::parse($item->create_at)->format('d-m-Y')}}</td>
                                        <td>
                         
                                        @if ($item->expiratedate < date('Y-m-d'))
                                            <span class="badge badge-danger">Expirado</span>
                                        @else
                                        {{\Carbon\Carbon::parse($item->expiratedate)->format('d-m-Y')}}
                                        @endif
                                        </td>
                                        <td>{{$item->product->description}}</td>
                                        <td class="text-uppercase">{{$item->unit}}</td>
                                        <td>{{$item->source}}</td>
                                        <td>{{$item->source_product}}</td>
                                        <td>{{number_format($item->price,2,',','.')}} Kz</td>
                                        <td>{{number_format($item->unit_price,2,',','.')}} Kz</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>
                                            <button wire:click='editStoque({{$item->id}})' data-toggle="modal" data-target="#stockenter" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="10">
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
    
        @include('livewire.economate.modals.verify-stock')
    </div>
    @include('livewire.economate.modals.stockenter-economate')
</div>

@push('select2-economate')
<script>
$(document).ready(function() {
    $('#product_economate_id').select2({
      theme: "bootstrap",
      width:"100%",
      dropdownParent: $('#stockenter')
    });
  
    $('#product_economate_id').change(function (e) { 
      e.preventDefault();
     
      @this.set('product_economate_id', $('#product_economate_id').val());
     
    });
});
</script>
@endpush
@push('select2-verify')
<script>
$(document).ready(function() {
    $('.select-verify-stock').select2({
      theme: "bootstrap",
      width:"100%",
      dropdownParent: $('#verifyStock')
    });
  
    $('.select-verify-stock').change(function (e) { 
      e.preventDefault();
     
      @this.set('product_id', $('.select-verify-stock').val());
     
    });
});
</script>
@endpush
<script>
    document.addEventListener('close',function(){
       $("#stockenter").modal('hide');
    })
    
</script>