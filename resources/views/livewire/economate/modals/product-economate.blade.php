<div wire:ignore.self data-backdrop='static' class="modal fade" id="product-economate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar':'Adicionar'}} Produto</h5>
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
            <div class="form-group">
              <label for="unit">Unidade</label>
              <select name="unit" id="unit" wire:model='unit' class="form-control">
                <option value="">--Selecionar--</option>
                <option value="g">G</option>
                <option value="un">UN</option>
                <option value="ml">ML</option>
                <option value="unidade de medida">Unidade de Medida</option>
                <option value="Hr">Hr</option>
              </select>
              @error('unit') <span class="text-danger">{{$message}}</span> @enderror

          </div>
        <div x-data="{isUploading: false, progress: 0}" class="form-group"
        x-on:livewire-upload-start = "isUploading = true"
        x-on:livewire-upload-finish = "isUploading = false"
        x-on:livewire-upload-error = "isUploading = false"
        x-on:livewire-upload-progress = "progress = $event.detail.progress"
        >
        <label for="image">Imagem</label>
        <input accept="png,gif,jpeg,jpg"  id="image" type="file" wire:model='image' description="image" class="form-control">
        @error('image') <span class="text-danger">{{$message}}</span> @enderror
        <div x-show="isUploading" class="progress progress-striped active w-100 mt-3" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="10">
          <div class="progress-bar progress-bar-success" x-bind:style="`width:${progress}%`" data-dz-uploadprogress></div>
        </div>
        </div>
            <div class="form-group">
                <label for="description">Categoria</label>
                <select name="category" id="category" wire:model='category' class="form-control">
                  <option value="">--Selecionar--</option>
                    @if ($categories->count() > 0)
                      @foreach ($categories as $item)
                        <option value="{{$item->id}}">{{$item->description}}</option>
                      @endforeach
                    @endif
                </select>
                @error('category') <span class="text-danger">{{$message}}</span> @enderror
  
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
      </div>
    </div>
  </div>
    