@section('title','Saídas')
<div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE TESOUREIRO</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Saídas</a></li>
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
                    <div class="container">
                        <div class="row">
                            <div class="alert alert-info col-md-12">
                                <i class="fa fa-info-circle text-dark"></i>
                                <span>Para poder visualizar os dados deve filtrar por intervalo de datas, informando a data inicial e a final</span>
                            </div>
                        </div>
                    </div>
          <div class=" d-flex justify-content-between align-items-center flex-wrap">
              
            <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap">
                <div class="col-md-10 d-flex">
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
                <div class="form-group">
                    <button class="btn btn-sm  mt-2" style=" background-color: #222831e5;color:#fff;" wire:click='export'><i class="fas fa-file-excel" title="Exportar Excel"></i> </button>
                    <button class="btn btn-sm btn-primary mt-2" wire:click='exportPdf'><i class="fas fa-file-pdf" title="Exportar PDF"></i> </button>
                    <button class="btn btn-sm btn-danger mt-2" data-toggle="modal" data-target="#saida"><i class="fa fa-minus"></i> Debitar</button>
                </div>
            </div>
          </div>
                    
                </div>
                <div class="card-body">
                    @php 
                        $saldoAtual = $totalDelivery + $totalOrder;
                        $saldoAtual2 =  $saldoAtual - $totalSaque;
                    @endphp
                <div class="container">
                    <div class="row col-md-12 d-flex justify-content-between align-items-center flex-wrap">
                      
                            <div class=" col-md-4 alert border border-success-subtle  text-center text-success font-weight-bold" >Saldo atual: {{number_format($saldoAtual2,2,',','.')}}</div>
                
                            <div class=" col-md-4 alert border fw-bold  text-center text-danger font-weight-bold">Total de Saída: {{number_format($totalSaque,2,',','.')}} Kz</div>
                       
                    </div>
                </div>
                <hr>
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100vw">
                            <thead>
                                <tr>
                                    <tr>
                       
                                        <th>
                                            Utilizador
                                        </th>
                                        <th>
                                            Descrição
                                        </th>
                                        <th>
                                            Valor do saque
                                        </th>
                                          <th>
                                           Data
                                          </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($saques) and $saques->count() > 0)

                                  

                                    @foreach ($saques as $saque)

                                        <tr>
                                            @if ($saque->userSaque->name == 'Administrador')
                                                <td>{{$saque->userSaque->name ?? ''}}</td>
                                            @else
                                                <td>{{$saque->userSaque->name ?? ''}}  {{$saque->userSaque->lastname ?? ''}}</td>
                                            @endif
                                            <td>
                                                {{$saque->description}}  <br> 
                                            </td>
                                            <td>
                                                {{number_format($saque->value,2,',','.')}} <br> 
                                            </td>
                                            <td>
                                                {{$saque->date}} 
                                            </td>
                                        </tr>
                                        
                                    @endforeach

                                  

                                    
                                @else
                                <tr>
                                    <td colspan="10">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column">
                                            <i class="fa fa-5x fa-caret-down text-muted"></i>
                                            <p class="text-muted">A consulta não retornou nenhum resultado</p>
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
   

    @include('livewire.treasury.modals.customer-modal')
    @include('livewire.treasury.modals.saida-modal')



</div>


<script>
    document.addEventListener('close',function(){
       $("#cupon").modal('hide');
    })
    
</script>
