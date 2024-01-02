<div wire:ignore.self data-backdrop='static' class="modal fade" id="item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar':'Adicionar'}} Item</h5>
        <button wire:click='clear'  type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form wire:submit='{{($edit != '')? 'update':'save'}}' id="basicform">
          <div class="form-group">
              <label for="barcode">Código de Barra</label>
              <input id="barcode" type="text" wire:model='barcode'  placeholder="Descreve o item" autocomplete="on" class="form-control">
              @error('barcode') <span class="text-danger">{{$message}}</span> @enderror

          </div>
          <div class="form-group">
              <label for="description">Descrição</label>
              <input id="description" type="text" wire:model='description'  placeholder="Descreve o item" autocomplete="on" class="form-control">
              @error('description') <span class="text-danger">{{$message}}</span> @enderror
          </div>
          <div class="form-group">
              <label for="price">Preço</label>
              <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"   id="price" type="number" wire:model='price' description="price" class="form-control">
              @error('price') <span class="text-danger">{{$message}}</span> @enderror
          </div>
          <div class="form-group">
              <label for="cost">Custo</label>
              <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"   id="cost" type="number" wire:model='cost' description="cost" class="form-control">
              @error('cost') <span class="text-danger">{{$message}}</span> @enderror
          </div>
          <div class="form-group">
              <label for="iva">Imposto(%)</label>
              <select name="iva"  wire:model='iva' id="iva" class="form-control">
                <option value="">--Selecionar Iva %--</option>
                <option value="14">14%</option>
                <option value="7">7%</option>
                <option value="0">0%</option>
              </select>
              @error('iva') <span class="text-danger">{{$message}}</span> @enderror
          </div>
          <div class="form-group">
              <label for="category_id">Categoria</label>
              <select name="category_id"  wire:model='category_id' id="category_id" class="form-control">
                <option value="">--Selecionar Categoria--</option>
                @if ($categories != null)
                    @foreach ($categories as $item)
                    <option value="{{$item->id}}">{{$item->description}}</option>
                        
                    @endforeach
                @endif
              </select>
              @error('category_id') <span class="text-danger">{{$message}}</span> @enderror
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
          @if ($edit != null and isset($image) and $image != null)
          <img class="img-fluid rounded" style="width: 100%;height:8rem; object-fit:cover" src="{{($edit != null) ? $image->temporaryUrl():''}}" alt="">
          @endif
        </div>
         
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
    </div>
  </div>
</div>
  