@section('title','Categorias')
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
                    <div class="form-group col-md-4">
                        <input type="search" wire:model.live='search' name="search" id="search" class="form-control rounded" placeholder="Pesquisar Categoria">
                    </div>
                    <div class="">
                        <button class="btn btn-sm btn-success mt-1" title="Exportar Excel" wire:click='export("xls")'><i class="fas fa-file-excel"></i></button>
                        <button class="btn btn-sm  mt-1" style=" background-color: #222831e5;color:#fff;" title="Exportar PDF" wire:click='export("pdf")'><i class="fas fa-file-pdf"></i></button>
                        <button class="btn btn-sm  mt-1" style=" background-color: #222831e5;color:#fff;" data-toggle="modal" data-target="#category"><i class="fa fa-plus"></i> Adicionar</button>
                    </div>
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Descrição</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($categories) and $categories->count() > 0)
                                    @foreach ($categories as $item)
                                    <tr>
                                        <td style="width:10%">
                                            <img class="img-fluid rounded-full" style="width: 5rem;height:5rem; border-radius: 100%" src="{{($item->image != null) ? asset('storage/'.$item->image): asset('not-found.png')}}" alt="Imagem da categoria {{$item->description}}">
                                        </td>
                                        <td style="width:70%">{{$item->description}}</td>
                                        <td style="width:20%">
                                            @if ($item->description == 'Bebidas' || $item->description == 'Pratos')
                                                ....
                                            @else
                                                
                                            <button wire:click='editCategory({{$item->id}})' data-toggle="modal" data-target="#category" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></button>
                                            <button wire:click='confirm({{$item->id}})' class="btn btn-sm btn-danger mt-1"><i class="fa fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="3">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                            <i class="fa fa-5x fa-caret-down text-muted"></i>
                                            <p class="text-muted">Nenhuma Categoria Encontrada</p>
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
    @include('livewire.admin.modals.category-modal')
</div>


<script>
    document.addEventListener('close',function(){
       $("#category").modal('hide');
    })
    
</script>