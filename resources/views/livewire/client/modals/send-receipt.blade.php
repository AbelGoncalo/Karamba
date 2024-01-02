 
  <!-- Modal -->
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="send-receipt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="exampleModalLabel">VERIFICAÇÃO DE PAGAMENTO, NÃO SAIR DA PÁGINA</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         
          @if (isset($this->orderfinded['status']) and $this->orderfinded['status'] === 'pendente')
            <div>
              <p class="text-center fw-bold h5">SEU PAGAMENTO FOI RECEBIDO E ESTÁ A SER AVALIADO</p>
              <button type="button" wire:click='verifyPaymentStatus({{$order_veriry}})' class="w-100 btn btn-md btn-primary-welcome-client">
                <i class="fa fa-rotate"></i>
                VERIFICAR</button>
              </div>
            @else
              <p class="text-center fw-bold h5">SEU PAGAMENTO FOI VERIFICADO COM SUCESSO!!</p>
            <div class="form-group mt-2">
              <button type="button" wire:click='download' class="w-100 btn btn-md btn-primary-welcome-client">FAZER DOWNLOAD FACTURA</button>
          </div> 
         {{ Session()->forget('ID')}}
          @endif
        </div>
      </div>
    </div>
    
  </div>