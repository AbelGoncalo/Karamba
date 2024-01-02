<div wire:ignore.self class="modal fade" id="messages" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
       
        <div class="modal-header">
          <h5 style=" color:#222831 " class="modal-title" id="exampleModalLabel">COMENTÁRIO</h5>
          <button wire:click='fresh'  type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
    
            
                <p class="text-justify fw-semi-bold" id="comment">{{$comments ?? 'NENHUM COMENTÁRIO PARA ESTA AVALIAÇÃO'}}</p>
         
        </div>
       
      </div>
    </div>
  </div>