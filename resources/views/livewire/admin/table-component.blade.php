@section('title','Mesas')

<div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE ADMINISTRADOR</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Mesas</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="search" wire:model.live='search' name="search" id="search" class="form-control rounded" placeholder="Pesquisar Mesa">
                        </div>
                    </div>
                    <div class="">
                        <button class="btn btn-sm btn-success mt-1" title="Exportar Excel" wire:click='export("xls")'><i class="fas fa-file-excel"></i></button>
                        <button class="btn btn-sm mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar PDF" wire:click='export("pdf")'><i class="fas fa-file-pdf"></i></button>
                        <button class="btn btn-sm mt-1" style=" background-color: #222831e5;color:#fff;" data-toggle="modal" data-target="#table"><i class="fa fa-plus"></i> Adicionar</button>
                    </div>
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Localização</th>
                                    <th>Estado</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($tables) and $tables->count() > 0)
                                    @foreach ($tables as $item)
                                    <tr>
                                        <td>{{$item->number}}</td>
                                        <td>{{$item->location}}</td>
                                        <td><span class="badge {{($item->status == 0)? 'badge-success':'badge-danger'}} " style="cursor: pointer" wire:click='confirmChangeStatus({{$item->id}})'>{{($item->status == 0)? 'Disponivel':'Ocupada'}}</span>
                                        <td>
                                            <button wire:click='editTable({{$item->id}})' data-toggle="modal" data-target="#table" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></button>
                                            <button wire:click='confirm({{$item->id}})' class="btn btn-sm btn-danger mt-1"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="4">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                            <i class="fa fa-5x fa-caret-down text-muted"></i>
                                            <p class="text-muted">Nenhuma Mesa Encontrada</p>
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
    @include('livewire.admin.modals.table-modal')
</div>
<script>
    document.addEventListener('close',function(){
       $("#table").modal('hide');
    })
</script>


