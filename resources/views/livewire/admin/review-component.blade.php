@section('title','Avaliações')

<div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE ADMINISTRADOR</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Avaliações</a></li>
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
                   <h4>Avaliações de Items</h4>
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table id="example" class="text-center table table-sm table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Item</th>
                                    <th>Avalicação</th>
                                    <th>Comentário</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($reviews) and $reviews->count() > 0)
                                    @foreach ($reviews as $item)
                                    <tr>
                                        <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i')}}</td>
                                        <td>{{$item->item}}</td>
                                        <td>
                                            @if ($item->star_number == '1')
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #222831e5 !important"></i>
                                            <i class="fa fa-star" style="color: #222831e5 !important"></i>
                                            <i class="fa fa-star" style="color: #222831e5 !important"></i>
                                            <i class="fa fa-star" style="color: #222831e5 !important"></i>
                                            @elseif ($item->star_number == '2')
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #222831e5 !important"></i>
                                            <i class="fa fa-star" style="color: #222831e5 !important"></i>
                                            <i class="fa fa-star" style="color: #222831e5 !important"></i>
                                            @elseif ($item->star_number == '3')
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #222831e5 !important"></i>
                                            <i class="fa fa-star" style="color: #222831e5 !important"></i>
                                            @elseif ($item->star_number == '4')
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #222831e5 !important"></i>
                                            @elseif ($item->star_number == '5')
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            <i class="fa fa-star" style="color: #ffe400 !important"></i>
                                            @endif
                                        </td>
                                        <td>{{$item->comment ?? 'N/D'}}</td>
                                        <td>
                                            <button class="btn btn-sm {{($item->status == 1) ? 'btn-info':'btn-success' }}" wire:click='confirm({{$item->id}})' ><i class="fa {{($item->status == 1) ? 'fa-eye-slash':'fa-eye' }}"></i></button>
                                            <button class="btn btn-sm btn-danger" wire:click='confirmDelete({{$item->id}})'><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="9">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
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
 
</div>



