@section('title','Contas Bancarias')

<div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE TESOURARIA</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Entidade Bancárias</a></li>
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
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#bank">Adicionar</button>
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                   
                                    <th>Banco</th>
                                    <th>Ibam</th>
                                    <th>Nº de conta</th>
                                    <th>Estado</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>

                               
                                @if (isset($banks) and $banks->count() > 0)
                                    @foreach ($banks as $bank)
                                    <tr>
                                       
                                        <td>{{$bank->bank}}</td>
                                        <td>{{$bank->ibam}}</td>
                                        <td>{{$bank->number}}</td>
                                        
                                        
                                        @if ($bank->status == '1')
                                        <td><span class="badge badge-success" style="cursor: pointer" wire:click='confirmChangeStatus({{$bank->id}})'>Ativa</span>
                                        </td>
                                        @else
                                        <td><span class="badge badge-danger" style="cursor: pointer" wire:click='confirmChangeStatus({{$bank->id}})'>Inativa</span></td>
                                        @endif
                                        <td>
                                            <button wire:click='editBank({{$bank->id}})' data-toggle="modal" data-target="#bank" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></button>
                                            <button wire:click='confirm({{$bank->id}})' class="btn btn-sm btn-danger mt-1"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="9">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                            <i class="fa fa-5x fa-caret-down text-muted"></i>
                                            <p class="text-muted">Nenhuma conta  bancária</p>
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
    @include('livewire.treasury.modals.bank-modal')
    
</div>
<script>
    document.addEventListener('close',function(){
       $("#bank").modal('hide');
    })
</script>



