<div wire:ignore.self data-backdrop='static' class="modal fade" id="verifyStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">VERIFICAR ESTOQUE</h5>
          <button wire:click='clear'  type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
          <div class="form-group" wire:ignore>
            <select required name="product_id" class="form-control select-verify-stock"  wire:model='product_id' id="product_id">
              <option value="">--SELECIONAR--</option>
              @if (isset($items) and $items->count() > 0)
                  @foreach ($items as $item)
                    <option value="{{$item->id}}">{{$item->description}}</option>
                  @endforeach
              @endif
            </select>
          </div>
          <div class="form-group mt-3 text-center" >
            @if (isset($quantityStock) and $quantityStock != 0)
            <p style="font-size: .8rem;color:#222831e5">DISPONIBILIDADE EM ESTOQUE</p>
                <p class=" font-weight-bold" style="font-size: 2rem; color:#222831e5">{{number_format($quantityStock,0,',','.')}}</p>
            @endif
          </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" wire:click="verifyQuantity" class="btn  w-100" style=" background-color: #222831e5;color:#fff;">Verificar</button>
        </div>
      </div>
    </div>
  </div>
    