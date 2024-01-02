 
  <!-- Modal -->
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="send-receipt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>CONCLUIR</h4>
          
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
     
          
          
        </div>
        <div class="modal-body">
          <form wire:submit='sendReceipt'  method="post">
            <div class="form-group">
              <label for="selectchannel">Enviar comprovativo por</label>
              <select wire:model.live='selectchannel' name="selectchannel" id="selectchannel" class="form-control">
                <option value="">--Selecionar--</option>
                <option value="E-mail">E-mail & Download</option>
                <option value="download">Apenas Download</option>
              </select>
             
            </div>
            @if ($selectchannel == 'E-mail')
            <div class="form-group">
              <label for="">E-mail</label>
              <input type="email" placeholder="Informe o email do Cliente" wire:model='email' class="form-control" type="mail">
            </div>
            @elseif($selectchannel == 'Whatsapp')
            <div class="form-group">
              <label for="whatsapp">Telefone</label>
              <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  type="tel" wire:model='whatsapp' class="form-control" type="number">
            </div>
            @endif
            <div class="form-group mt-2">
              <button type="submit" class="w-100 btn btn-md btn-primary-welcome-client">CONCLUIR</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    
  </div>
 