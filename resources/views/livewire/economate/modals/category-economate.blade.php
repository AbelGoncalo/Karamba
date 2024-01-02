<div wire:ignore.self data-backdrop='static' class="modal fade" id="category-economate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <label for="description">Descrição</label>
                <input id="description" type="text" wire:model='description' description="description" placeholder="Descreve a categoria" autocomplete="on" class="form-control">
                @error('description') <span class="text-danger">{{$message}}</span> @enderror
  
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
      </div>
    </div>
  </div>
    