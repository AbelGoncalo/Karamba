 
  <!-- Modal -->
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="note-order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="exampleModalLabel">ANOTAR PEDIDO</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="col-md-8">
                  <div class="card" style="height: 30rem">
                     <div class="card-header">
                      <div class="input-group">
                        <input type="search" wire:model.live='searchItems' class=" w-5 form-control form-control-sm" placeholder="Pesquisar items..." aria-label="Pesquisar items..." aria-describedby="basic-addon1">
                        <span class=" input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
                      </div>
                     </div>
                     <div class="card-body"  style="max-height: 100%; overflow-y: auto;">
                      <div class="container">
                        <div class="row modal-dialog-scrollable">
                          @if (isset($items) and $items->count() > 0)
                              @foreach ($items as $item)
                              <div class="col-md-4 mt-2">
                                <div class="card  p-2 text-center" style="height: 5rem; cursor: pointer; font-size:12px">
                                  <p class="fw-bold">{{$item->description}}</p>
                                  <p class="fw-bold">{{number_format($item->price,2,',','.')}} AOA</p>
                                 </div>
                              </div>
                              @endforeach
                          @else
                            <td colspan="3">
                                <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                    <i class="fa fa-5x fa-caret-down text-muted"></i>
                                    <p class="text-muted">Nenhum Item Encontrado</p>
                                </div>
                            </td>
                          @endif

                        </div>
                      </div>
                     </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card" style="height: 30rem">
                    <div class="card-header text-center">
                      <h5 class="fw-bold text-uppercase">Mesa 1</h5>
                    </div>
                    <div class="card-body">
                      {{-- @if (isset($isOpen) and $isOpen->count() == 0)
                          <div class="text-center">
                            <i class="fa-solid fa-coins fa-3x"></i>
                            <p class="text-muted mt-3">Para começar anotar os pedidos deve fazer abertura de caixa</p>
                            <div class="form-group">
                              <input type="number" name="value_open" id="value_open" wire:model='value_open' class="form-control" placeholder="0">
                            </div>
                            <div class="form-group mt-5">
                              <button class="btn btn-md text-white w-100  card-header-custom">
                                <i class="fa-solid fa-coins"></i>
                                  ABRIR CAIXA
                              </button>
                            </div>
                          </div>
                      @else --}}
                          
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-xl card-header-custom">
                          <i class="fa-solid fa-hand-holding-dollar"></i>
                            FINALIZAR
                        </button>
                    </div>
                      {{-- @endif --}}
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
    
  </div>
 


  
  