@section('title','Utilizadores')

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
                            <input type="search" wire:model.live='search' name="search" id="search" class="form-control rounded" placeholder="Pesquisar Utilizador">
                        </div>
                    </div>
                    <button class="btn btn-sm" style=" background-color: #222831e5;color:#fff;" data-toggle="modal" data-target="#user">Adicionar</button>
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Nome</th>
                                    <th>Sobrenome</th>
                                    <th>Gênero</th>
                                    <th>Telefone</th>
                                    <th>E-mail</th>
                                    <th>Acesso</th>
                                    <th>Conta</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($users) and $users->count() > 0)
                                    @foreach ($users as $item)
                                    <tr>
                                        <td style="width:10%">
                                            <img class="img-fluid rounded-full" style="width: 3rem;height:3rem; border-radius: 100%" src="{{($item->photo != null) ? asset('storage/'.$item->photo): asset('/not-found.png')}}" alt="Imagem da categoria {{$item->description}}">
                                        </td>
                                        <td>{{$item->name ?? 'N/D'}}</td>
                                        <td>{{$item->lastname ?? 'N/D'}}</td>
                                        <td>{{$item->genre ?? 'N/D'}}</td>
                                        <td>{{$item->phone ?? 'N/D'}}</td>
                                        <td>{{$item->email ?? 'N/D'}}</td>
                                        <td>{{$item->profile}}</td>
                                        @if ($item->profile != 'client')
                                        @if ($item->status == '1')
                                        <td><span class="badge badge-success" style="cursor: pointer" wire:click='confirmChangeStatus({{$item->id}})'>Ativa</span>
                                        </td>
                                        @else
                                        <td><span class="badge badge-danger" style="cursor: pointer" wire:click='confirmChangeStatus({{$item->id}})'>Inativa</span></td>
                                        @endif
                                        @else
                                        <td>...</td>
                                        @endif
                                        <td>
                                            @if ($item->profile != 'client')
                                            <button wire:click='editUser({{$item->id}})' data-toggle="modal" data-target="#user" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></button>
                                            <button wire:click='confirm({{$item->id}})' class="btn btn-sm btn-danger mt-1"><i class="fa fa-trash"></i></button>
                                            @else
                                            ...
                                            @endif
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="9">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                            <i class="fa fa-5x fa-caret-down text-muted"></i>
                                            <p class="text-muted">Nenhum Utilizador Encontrado</p>
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
    @include('livewire.admin.modals.user-modal')
</div>
<script>
    document.addEventListener('close',function(){
       $("#user").modal('hide');
    })
</script>


