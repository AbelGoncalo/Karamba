<div wire:ignore.self data-backdrop='static' class="modal fade" id="saida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar':'Registrar'}} Saída</h5>
        <button  type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form wire:submit='{{($edit != '')? 'update':'save'}}' id="basicform">
          <div class="form-group">
              <label for="description">Motivo da Saída</label>
              <textarea wire:model='description' name="description" id="description" cols="30" rows="5" placeholder="Digite aqui o motivo" style="resize: none" class="form-control"></textarea>

              @error('description') <span class="text-danger">{{$message}}</span> @enderror
          </div>
          <div class="form-group">
              <label for="value">Valor</label>
              <input id="value" placeholder="0" type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" min="0" wire:model='value' name="value" placeholder="Informe o valor" autocomplete="on" class="form-control">
              @error('value') <span class="text-danger">{{$message}}</span> @enderror
          </div>
    
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
    </div>
  </div>
</div>
  