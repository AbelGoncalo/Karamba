@section('title','Relatórios')

<div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE ADMINISTRADOR</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Relatórios</a></li>
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
                  
          
                    <div class="col-md-10 d-flex">
                        <div class="input-group mb-2 mt-2 col-md-4">
                            <input type="date" wire:model.live='initialDate' class="form-control form-control-sm" placeholder="Pesquisar por Código">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                         </div>
                         <div class="input-group mb-2 mt-2 col-md-4">
                           <input type="date" wire:model.live='finaldate' class="form-control form-control-sm" placeholder="Código">
                           <div class="input-group-prepend">
                             <span class="input-group-text"><i class="fa fa-search"></i></span>
                           </div>
                        </div>
                    </div>
                
            </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Descrição</th>
                                    <th>Preço</th>
                                    <th>Estado</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                             
                              
                            </tbody>
                         
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</div>



