<div wire:ignore.self data-backdrop='static' class="modal fade" id="location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar':'Adicionar'}} Categoria</h5>
        <button wire:click='clear'  type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form wire:submit='{{($edit != '')? 'update':'save'}}' id="basicform">
          <div class="form-group">
              <label for="location">Local</label>
              <select name="location" id="location" wire:model='location' class="form-control">
                <option value="Belas">Belas</option>
                <option value="Cacuaco">Cacuaco</option>
                <option value="Cazenga">Cazenga</option>
                <option value="Icolo e Bengo">Icolo e Bengo</option>
                <option value="Luanda">Luanda</option>
                <option value="Quiçama">Quiçama</option>
                <option value="Kilamba Kiaxi">Kilamba Kiaxi</option>
                <option value="Talatona">Talatona</option>
                <option value="Viana">Viana</option>
              </select>
              @error('location') <span class="text-danger">{{$message}}</span> @enderror

          </div>
          <div class="form-group">
              <label for="image">Preço</label>
              <input   id="price" type="number" wire:model='price'  class="form-control">
              @error('price') <span class="text-danger">{{$message}}</span> @enderror
          </div>
         
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
    </div>
  </div>
</div>
  