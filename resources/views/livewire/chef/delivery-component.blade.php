@section('title','PAINEL DE CHEFE DE COZINHA')
<div>
    <div class="container">
      
        <div class="row">
           
            <div class="col-md-12">
                 
                        <div class="container">
                            @if (isset($deliveries) and $deliveries->count() > 0)
                            <div class="table-responsive mt-3">
                                <table class="table table-striped table-hover table-sm text-center">
                                    <thead class="card-header-custom card-header">
                                        <tr>
                                            <th>TEMPO</th>
                                            <th>ESTADO</th>
                                            <th>ITEMS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($deliveries as $item)
                                       
                                            <tr>
                                                <td style="width: 30%">{{($item->created_at != null) ? $item->created_at->diffForHumans(): ''}}</td>
                                                <td style="width: 50%">
                                                    <select wire:change='changeStatus({{$item->id}})' wire:model='statusvalue.{{$item->id}}' name="statusvalue" id="statusvalue" class="form-select form-select">
                                                       <option value="">--SELECIONAR--</option>
                                                        <option {{($item->status == 'EM PREPARAÇÃO') ? 'selected':''}} value="EM PREPARAÇÃO">EM PREPARAÇÃO</option>
                                                        <option {{($item->status == 'PRONTO') ? 'selected':''}} value="PRONTO">PRONTO</option>
                                                    </select>
                                                </td>
                                                <td style="width: 30%">
                                                    <button class="btn btn-sm" wire:click='getDetail({{$item->id}})' style=" background-color: #222831e5;color:#fff;" data-bs-toggle="modal" data-bs-target="#detail">
                                                        <i class="fa fa-list"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                         
                                    </tbody>
                                </table>
                            </div>
                    
                                
                            @else
                            <div class="rounded d-flex justify-content-center align-items-center flex-column mt-2" style="height: 20rem;border:1px dashed #000">
                                <h5 class="text-muted text-size text-center text-uppercase text-muted">A consulta não retorno nenhum resultado</h5>
                            </div>
                            @endif
                        </div>
                    
                
            </div>
        </div>
    </div>
    @include('livewire.chef.modals.details-modal')
</div>
