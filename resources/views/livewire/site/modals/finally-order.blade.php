<div wire:ignore.self class="modal fade" id="finnaly" data-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">

        <div class="modal-header">
          <h5 style=" color:#222831 " class="modal-title" id="exampleModalLabel">FINALIZAR ENCOMENDA</h5>
          <button  type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


        <div class="modal-body">
         <form action="" class="container">
          <div class="row">
            <div class="form-group col-md-4">
              <label for="name">Nome <span class="text-danger">*</span></label>
              <input type="text" wire:model='name' name="name" id="name" class="form-control" placeholder="Nome">
              @error('name') <span class="text-danger">{{$message}}</span>@enderror
            </div>
            <div class="form-group col-md-4">
              <label for="">Sobrenome <span class="text-danger">*</span></label>
              <input type="text" wire:model='lastname' name="lastname" id="lastname" class="form-control" placeholder="Sobrenome">
              @error('lastname') <span class="text-danger">{{$message}}</span>@enderror

            </div>
            <div class="form-group col-md-4">
              <label for="">Provincia <span class="text-danger">*</span></label>
              <input type="text" wire:model='province' name="province" id="province" class="form-control" placeholder="Provincia">
              @error('province') <span class="text-danger">{{$message}}</span>@enderror

            </div>
            <div class="form-group col-md-4">
              <label for="">Município <span class="text-danger">*</span></label>
              <input type="text" wire:model='municipality' name="municipality" id="municipality" class="form-control" placeholder="Município">
              @error('municipality') <span class="text-danger">{{$message}}</span>@enderror

            </div>
            <div class="form-group col-md-4">
              <label for="">Bairro <span class="text-danger">*</span></label>
              <input type="text" wire:model='street' name="street" id="street" class="form-control" placeholder="Bairro">
              @error('street') <span class="text-danger">{{$message}}</span>@enderror
            </div>
            <div class="form-group col-md-4">
              <label for="">Telefone <span class="text-danger">*</span></label>
              <input type="text" wire:model='phone' onkeypress="$(this).mask('999-999-999')" name="phone" id="phone" class="form-control" placeholder="999-999-999">
              @error('phone') <span class="text-danger">{{$message}}</span>@enderror

            </div>
            <div class="form-group col-md-4">
              <label for="">Telefone Alternativo</label>
              <input type="text" wire:model='otherPhone' onkeypress="$(this).mask('999-999-999')" name="otherPhone" id="otherPhone" class="form-control" placeholder="999-999-999">
            </div>
            <div class="form-group col-md-4">
              <label for="paymenttype">Forma de Pagamento <span class="text-danger">*</span></label>
              <select disabled wire:model='paymenttype' name="paymenttype" id="" class="form-control">
                {{-- <option value="">--Selecionar--</option> --}}
                <option value="Transferência" selected>Transferência </option>
                {{-- <option value="TPA">TPA</option> --}}
              </select>
              @error('paymenttype') <span class="text-danger">{{$message}}</span>@enderror

            </div>

            <div x-data="{isUploading: false, progress: 0}" class="form-group col-md-4"
              x-on:livewire-upload-start = "isUploading = true"
              x-on:livewire-upload-finish = "isUploading = false"
              x-on:livewire-upload-error = "isUploading = false"
              x-on:livewire-upload-progress = "progress = $event.detail.progress"
              >
              <label for="image">Recibo de Pagamento <span class="text-danger">*</span></label>
              <input accept="pdf"  id="receipt" type="file" wire:model='receipt' description="receipt" class="form-control w-100">
              @error('receipt') <span class="text-danger">{{$message}}</span> @enderror
              <div x-show="isUploading" class="progress progress-striped active w-100 mt-3" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="10">
                <div class="progress-bar progress-bar-success" x-bind:style="`width:${progress}%`" data-dz-uploadprogress></div>
              </div>
              </div>
            <div class="form-group col-md-12">
              <label for="">Refência</label>
              <input type="text" name="otherAddress" id="otherAddress" class="form-control" placeholder="Refência da sua localização">
            </div>
          </div>
         </form>
         
        </div>
        <div class="modal-footer">
          <button type="button" wire:click='finallyOrder' class="btn btn-md " style="background: #ffbe33; color:#fff ">ENCOMENDAR</button>
       </div>
      </div>
    </div>
  </div>