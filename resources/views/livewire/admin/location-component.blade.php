@section('title','Locais de Entrega')
<div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE ADMINISTRADOR</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Locais</a></li>
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
                        <select name="search" id="search" wire:model.live='search' class="form-control">
                        <option value="">--Pesquisar por Local--</option>
                        <option value="Belas">Belas</option>
                        <option value="Cacuaco">Cacuaco</option>
                        <option value="Cazenga">Cazenga</option>
                        <option value="Icolo e Bengo">Icolo e Bengo</option>
                        <option value="Luanda">Luanda</option>
                        <option value="Quiçama">Quiçama</option>
                        <option value="Kilamba Kiaxi">Kilamba Kiaxi</option>
                        <option value="Talatona">Talatona</option>
                        <option value="Viana">Viana</option>
                        </select>
                    </div>
                    <div class="">
                        <button class="btn btn-sm btn-success mt-1" title="Exportar Excel" wire:click='export'><i class="fas fa-file-excel"></i></button>
                        <button class="btn btn-sm mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar PDF" wire:click='exportPdf'><i class="fas fa-file-pdf"></i></button>
                        <button class="btn btn-sm mt-1" style=" background-color: #222831e5;color:#fff;" data-toggle="modal" data-target="#location">Adicionar</button>
                    </div>
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Local</th>
                                    <th>Preço de Entrega</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($locations) and $locations->count() > 0)
                                    @foreach ($locations as $item)
                                    <tr>
                                        <td>{{$item->location}}</td>
                                        <td>{{number_format($item->price,2,',','.')}} Kz</td>
                                        <td>
                                            <button wire:click='editLocation({{$item->id}})' data-toggle="modal" data-target="#location" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></button>
                                            <button wire:click='confirmDelete({{$item->id}})' class="btn btn-sm btn-danger mt-1"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="3">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                            <i class="fa fa-5x fa-caret-down text-muted"></i>
                                            <p class="text-muted">Nenhum Local Encontrado</p>
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
    @include('livewire.admin.modals.location-modal')
</div>


<script>
    document.addEventListener('close',function(){
       $("#location").modal('hide');
    })
    
</script>