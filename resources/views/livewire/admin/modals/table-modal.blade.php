<div wire:ignore.self data-backdrop='static' class="modal fade" id="table" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar':'Adicionar'}} Mesa</h5>
        <button wire:click='clear'  type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form wire:submit='{{($edit != '')? 'update':'save'}}' id="basicform">
          <div class="form-group">
              <label for="number">Número</label>
              <input id="number" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  wire:model='number' number="number" placeholder="Número da Mesa" autocomplete="on" class="form-control">
              @error('number') <span class="text-danger">{{$message}}</span> @enderror

          </div>
          <div class="form-group">
              <label for="location">Localização</label>
              <input   id="location" type="text" wire:model='location' number="location" class="form-control">
              @error('location') <span class="text-danger">{{$message}}</span> @enderror
          </div>
         
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
    </div>
  </div>
</div>
  