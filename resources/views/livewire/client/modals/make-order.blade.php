 
  <!-- Modal -->
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="make-order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="exampleModalLabel">FAÇA SEU PEDIDO</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <div class="input-group">
                    <input type="searchOrder"    name="searchOrder" id="searchOrder" class="form-control" placeholder="Pesquisar Item">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                </div>
            </div> 
           <div class="table-responsive mt-2">
            <table class="table table-lg table-striped table-hover text-center" id="table-items">
              <thead>
                <tr>
                  <th>ESTADO</th>
                  <th>ITEM</th>
                  <th>PREÇO</th>
                  <th>QTD.</th>
                  <th>PEDIR</th>
                </tr>
              </thead>
                <tbody id="tbody">
                  
                    @if (isset($allItems) and count($allItems) > 0 )
                    @foreach ($allItems as $key=> $item)
                    <tr>
                      <td class="{{($item->status == 'DISPONIVEL')? 'text-success fw-bold':'text-danger fw-bold'}}">{{$item->status}}</td>
                        <td style="width: 30%">{{$item->description}}</td>
                        <td style="width:20% ">{{$item->price}} AOA</td>
                        <td style="width: 20%">
                          <input placeholder="0" type="number" wire:model='qtd.{{$item->id}}' value="0" min="0" name="qtd" id="qtd" class=" w-100">
                        </td>
                        <td style="width: 30%" >
                          <button wire:click="makeOrder({{$item->id}})" class="btn btn-md" style="background-color: #0e0c28; color:#fff">
                            <i class="fa fa-clipboard-list"></i>
                            PEDIR
                          </button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="5">
                            <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                <i class="fa fa-5x fa-caret-down text-muted"></i>
                                <p class="text-muted">Nenhum Item Encontrado</p>
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
 


  
  