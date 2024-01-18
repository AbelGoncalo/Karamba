<div>
    @section('title','Prato do dia')
    <div class="col-md-12 col-sm-12 col-12">
            <div class="row">
                <div class="page-header">
                    <h1 class="pageheader-title">Prato do dia</h1>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Detalhes</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-12">
                        <div class="card">
            
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table  id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Tipo de Menu</th>
                                            <th>Entrada</th>
                                            <th>Prato principal</th>
                                            <th>Sobremesa</th>
                                            <th>Bebida</th>
                                            <th>Café</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($dailyOfTheDay) and count($dailyOfTheDay) > 0)
                                            @foreach ($dailyOfTheDay as $data)
                                                <tr>
                                                    <td>{{$data->menutype ?? ""}}</td>
                                                    <td>{{$data->entrance ?? ""}}</td>
                                                    <td>{{$data->maindish ?? ""}}</td>
                                                    <td>{{$data->dessert ?? ""}}</td>
                                                    <td>{{$data->drink ?? ""}}</td>
                                                    <td>{{$data->coffe ?? ""}}</td>
                                                    <td>
                                                        <button wire:click='' data-toggle="modal" data-target="#item" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i></button>
                                                        <button wire:click='' class="btn btn-sm btn-danger mt-1"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>

                                                
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>               
                            </div>
            
                            </div>
            
                        </div>

                    </div>
            </div>


           
        </div>


</div>
