@section('title','Ingredientes')
<div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE GESTÃO DE ECONOMATO</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Produtos</a></li>
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
                            <input type="search" wire:model.live='search' name="search" id="search" class="form-control rounded" placeholder="Pesquisar Categoria">
                        </div>
                    </div>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#product-economate">Adicionar</button>
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Descrição</th>
                                    <th>Categoria</th>
                                    <th>Custo</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($products) and $products->count() > 0)
                                    @foreach ($products as $item)
                                    <tr>
                                        <td style="width:10%">
                                            <img class="img-fluid rounded-full" style="width: 5rem;height:5rem; border-radius: 100%" src="{{($item->image != null) ? asset('/storage/economato/'.$item->image): asset('/not-found.png')}}" alt="Imagem da categoria {{$item->description}}">
                                        </td>
                                        <td>{{$item->description}}</td>
                                        <td>{{$item->category_economato->description ?? ''}}</td>
                                        <td>{{number_format($item->cost ?? 0,2,',','.')}} Kz</td>
                                        <td>
                                            <button wire:click='editProduct({{$item->id}})' data-toggle="modal" data-target="#product-economate" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></button>
                                            <button wire:click='confirm({{$item->id}})' class="btn btn-sm btn-danger mt-1"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="5">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                            <i class="fa fa-5x fa-caret-down text-muted"></i>
                                            <p class="text-muted">Nenhuma Ingrediente Encontrado</p>
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
    @include('livewire.economate.modals.product-economate')
</div>


<script>
    document.addEventListener('close',function(){
       $("#product-economate").modal('hide');
    })
    
</script>