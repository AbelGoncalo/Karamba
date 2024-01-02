 
  <!-- Modal -->
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="changequantity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="exampleModalLabel">ALTERAR QUANTIDADE</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        
              <div class="form-group">
                <label for="quantity">Quantidade</label>
                <input required type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" min="1" wire:model='quantity' name="quantity" id="quantity" class="form-control">
              </div>
            
        </div>
        <div class="modal-footer">
       
              <div class="col-md-12 text-end">
                <button wire:click='updateQuantity' type="button" class="w-100 btn btn-md button-order">
                  Salvar
                </button>
          
          </div>
    
        </div>
      </div>
    </div>
    
  </div>
 


  
  