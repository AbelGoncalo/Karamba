
@section('title','Restaurantes')
<div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE CONTROLO</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Adicionar Restaurantes</a></li>
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
                            <input type="search" wire:model.live='search' name="search" id="search" class="form-control rounded" placeholder="Buscar por nome ou nif">
                        </div>
                    </div>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create-company">Adicionar</button>
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Logotipo</th>
                                    <th>Designação</th>
                                    <th>Nif</th>
                                    <th>Telefone</th>
                                    <th>Telefone Alternativo</th>
                                    <th>E-mail</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($companies) and $companies->count() > 0)
                                    @foreach ($companies as $item)
                                    <tr>
                                        <td style="width:10%">
                                            <img class="img-fluid rounded-full" style="width: 5rem;height:5rem; border-radius: 100%" src="{{($item->companylogo != null) ? asset('/storage/logo/'.$item->companylogo): asset('/not-found.png')}}" alt="Imagem da categoria {{$item->description}}">
                                        </td>
                                        <td>{{$item->companyname}}</td>
                                        <td>{{$item->companynif}}</td>
                                        <td>{{$item->companyphone}}</td>
                                        <td>{{$item->companyalternativephone}}</td>
                                        <td>{{$item->companyemail}}</td>
                                        <td>
                                            <button wire:click='editCompany({{$item->id}})' data-toggle="modal" data-target="#create-company" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></button>
                                            {{-- <button wire:click='confirm({{$item->id}})' class="btn btn-sm btn-danger mt-1"><i class="fa fa-trash"></i></button> --}}
                                            {{-- <button  class="btn btn-sm btn-dark mt-1"><i class="fa fa-list"></i></button> --}}
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="8">
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
    @include('livewire.control.modals.create-company')
</div>
<script>
    document.addEventListener('close',function(){
       $("#create-company").modal('hide');
    })
</script>


