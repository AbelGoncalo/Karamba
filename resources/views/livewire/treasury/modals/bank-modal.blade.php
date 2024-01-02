<div wire:ignore.self data-backdrop='static' class="modal fade" id="bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar':'Adicionar'}} Conta Bancária</h5>
        <button  type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form wire:submit='{{($edit != '')? 'update':'save'}}' id="basicform">
          <div class="form-group">
              <label for="bank">Banco</label>
              <input id="bank" type="text" wire:model='bank' name="bank" placeholder="Informe do Banco" autocomplete="on" class="form-control">
              @error('bank') <span class="text-danger">{{$message}}</span> @enderror
          </div>
          <div class="form-group">
              <label for="ibam">Ibam</label>
              <input id="ibam" type="text" maxlength="21" wire:model='ibam' name="ibam" placeholder="Informe o Ibam" autocomplete="on" class="form-control">
              @error('ibam') <span class="text-danger">{{$message}}</span> @enderror
          </div>
         

          <div class="form-group">
            <label for="number">Conta</label>
            <input   id="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" min="0" type="text" maxlength="" wire:model='number' name="number" class="form-control">
            @error('number') <span class="text-danger">{{$message}}</span> @enderror
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
    </div>
  </div>
</div>
  