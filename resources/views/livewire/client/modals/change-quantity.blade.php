 
  <!-- Modal -->
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="changequantity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="exampleModalLabel">EDITAR QUANTIDADE</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form wire:submit='updateQuantity' action="" method="post">
              <div class="form-group">
                <label for="quantity">Quantidade</label>
                <input required type="number" min="1" wire:model='quantity' name="quantity" id="quantity" class="form-control">
              </div>
            
        </div>
        <div class="modal-footer">
          <div class="container">
            <div class="row">
              <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-md button-order">
                  <i class="fa fa-edit"></i>
                  Editar
                </button>
              </div>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
    
  </div>
 


  
  