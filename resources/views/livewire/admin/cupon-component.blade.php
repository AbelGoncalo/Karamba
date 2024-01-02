@section('title','Cupon')
<div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE ADMINISTRADOR</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Categorias</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header col-md-12 d-flex justify-content-between align-items-center flex-wrap">
                   
                        
                           <div class="col-md-10 d-flex">
                               <div class="input-group mb-2 mt-2 col-md-4">
                                   <input type="text" wire:model.live='codeSearch' class="form-control form-control-sm" placeholder="Pesquisar por Código">
                                   <div class="input-group-prepend">
                                     <span class="input-group-text"><i class="fa fa-search"></i></span>
                                   </div>
                                </div>
                                <div class="input-group mb-2 mt-2 col-md-4">
                                  <input type="date" wire:model.live='search' class="form-control form-control-sm" placeholder="Código">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                  </div>
                               </div>
                           </div>
                      
                   
                           <div class="">
                            <button class="btn btn-sm btn-success mt-1" title="Exportar Excel" wire:click='export("xls")'><i class="fas fa-file-excel"></i></button>
                            <button class="btn btn-sm mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar PDF" wire:click='export("pdf")'><i class="fas fa-file-pdf"></i></button>
                            <button class="btn btn-sm mt-1" style=" background-color: #222831e5;color:#fff;" data-toggle="modal" data-target="#cupon"><i class="fa fa-plus"></i> Adicionar</button>
                        </div>

                   
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <tr>
                       
                                        <th>
                                            Usuário
                                        </th>
                                        
                                         <th>
                                           Tipo
                                         </th>  
                                         <th>
                                           Valor
                                         </th>   
                                          <th>
                                           Código
                                          </th>
                                          <th>
                                           Nº de Uso
                                          </th>
                                        
                                         <th>
                                           Estado
                                         </th>      
                                          <th>
                                            Ações
                                          </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($cupons) and $cupons->count() > 0)
                                    @foreach ($cupons as $item)
                                    <tr>
                                        <td>{{$item->user->name}} {{$item->user->lastname}}</td>
                                        <td>
                        
                                            @if ($item->type == 'percent')
                                              Percentagem
                                            @else
                                            Valor Fixo
                                            @endif
                                           </td>
                                           <td>
                                            @if ($item->type == 'percent')
                                                {{$item->value}}%
                                            @else
                                                 {{number_format($item->value,2,",",".")}} Kz
                                             @endif
                                           </td>
                                           <td>
                                            {{$item->code}}
                                           </td>
                                           <td>
                                            {{$item->times}}
                                           </td>
                                           <td>
                                            @if ($item->status)
                                            <span class="badge badge-success">Válida</span>
                                            @else
                                            <span class="badge badge-danger">Expirada</span>
                                            @endif
                                           </td>
                                        <td>
                                            <button wire:click='editCupon({{$item->id}})' data-toggle="modal" data-target="#cupon" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></button>
                                            <button wire:click='confirmDelete({{$item->id}})' class="btn btn-sm btn-danger mt-1"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="7">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                            <i class="fa fa-5x fa-caret-down text-muted"></i>
                                            <p class="text-muted">Nenhum Cupon Encontrado</p>
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
    @include('livewire.admin.modals.cupon-modal')
</div>


<script>
    document.addEventListener('close',function(){
       $("#cupon").modal('hide');
    })
    
</script>

@push('select2-users')

<script>

    
    $(document).ready(function() {
        
        $('.select2-users').select2({
          theme: "bootstrap"
        });
      
        $('.select2-users').change(function (e) { 
           
          e.preventDefault();
          @this.set('user', $('.select2-users').val());
        });
    });
    </script>

@endpush