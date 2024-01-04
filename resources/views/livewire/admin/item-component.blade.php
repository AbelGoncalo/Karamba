@section('title','Items')

<div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE ADMINISTRADOR</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Item</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                        <div class="col-md-12 d-flex justify-content-between align-items-start flex-wrap">
                            <div class="form-group col-md-5 ">
                                <input type="search" wire:model.live='search' name="search" id="search" class="form-control rounded" placeholder="Pesquisar Item">
                            </div>
                            <div class="form-group col-md-5" wire:ignore>
                                <select name="searchCategory" wire:model.live='searchCategory' id="searchCategory" class="form-control">
                                    <option value="">Categorias</option>
                                    @if (isset($categories) and $categories->count() > 0)
                                        @foreach ($categories as $item)
                                            <option value="{{$item->id}}">{{$item->description}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="">
                                <button class="btn btn-sm btn-success" title="Exportar Excel" wire:click='export'><i class="fas fa-file-excel"></i></button>
                                <button class="btn btn-sm" style=" background-color: #222831e5;color:#fff;" title="Exportar PDF" wire:click='exportPdf'><i class="fas fa-file-pdf"></i></button>
                                <button class="btn btn-sm" style=" background-color: #222831e5;color:#fff;" data-toggle="modal" data-target="#item"><i class="fa fa-plus"></i> Adicionar</button>
                             </div>
                        </div>
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Categoria</th>
                                    <th>Descrição</th>
                                    <th>Preço</th>
                                     <th>Quantidade</th>
                                    {{-- <th>Iva(%)</th> --}} 
                                    <th>Estado</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($items) and $items->count() > 0)
                                    @foreach ($items as $item)
                                    <tr>
                                        <td style="width:10%">
                                            <img class="img-fluid rounded-full" style="width: 5rem;height:5rem; border-radius: 100%" src="{{($item->image != null) ? asset('/storage/'.$item->image): asset('/not-found.png')}}" alt="Imagem da categoria {{$item->description}}">
                                        </td>
                                        <td>{{$item->category->description}}</td>
                                        <td>{{$item->description}}</td>
                                        <td>{{number_format($item->price,2,',','.')}} AOA</td>
                                        <td>{{$item->quantity}}</td>
                                       {{--  <td>{{number_format($item->iva,1,',','.')}} %</td> --}}

                                        @if ($item->status == 'DISPONIVEL')
                                        <td><span class="badge badge-success" style="cursor: pointer" wire:click='confirmChangeStatus({{$item->id}})'>DISPONIVEL</span>
                                        </td>
                                        @else
                                        <td><span class="badge badge-danger" style="cursor: pointer" wire:click='confirmChangeStatus({{$item->id}})'>INDISPONIVEL</span></td>
                                        @endif
                                        <td>
                                            <button wire:click='editItem({{$item->id}})' data-toggle="modal" data-target="#item" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></button>
                                            <button wire:click='confirm({{$item->id}})' class="btn btn-sm btn-danger mt-1"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="8">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                            <i class="fa fa-5x fa-caret-down text-muted"></i>
                                            <p class="text-muted">Nenhum Item Encontrado</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                              
                            </tbody>
                         
                        </table>
                        {{-- <div class="container">
                            <div class="row">
                                {{$items->links('pagination::bootstrap-4')}}
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    @include('livewire.admin.modals.item-modal')
</div>
<script>
    document.addEventListener('close',function(){
       $("#item").modal('hide');
    })
</script>

@push('select2-categories')
<script>
$(document).ready(function() {
    $('#searchCategory').select2({
      theme: "bootstrap",
      width:"100%",
   
    });
  
    $('#searchCategory').change(function (e) { 
      e.preventDefault();
     
      @this.set('searchCategory', $('#searchCategory').val());
     
    });
});
</script>
@endpush


