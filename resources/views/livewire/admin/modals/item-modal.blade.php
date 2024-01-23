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
        {{-- <form method="POST" action="{{route('panel.admin.daily.dish.store')}}"> --}}
          {{-- @csrf --}}

          <div  class="form-group" wire:ignore>
            <label for="category_id">Categoria</label>
            <select wire:ignore name="category_id"  wire:model='category_id' id="category_id" class="form-control">
              <option value="">--Selecionar Categoria--</option>
              @if ($categories != null)
                  @foreach ($categories as $item)
                  <option value="{{$item->id}}">{{$item->description}}</option>
                  @endforeach
              @endif
            </select>                      
            @error('category_id') <span class="text-danger">{{$message}}</span> @enderror
        </div>

         
          <div class="form-group">
              <label for="description">Descrição</label>
              <input name="description" id="description" type="text" wire:model='description'  placeholder="Descreve o item" autocomplete="on" class="form-control">
              @error('description') <span class="text-danger">{{$message}}</span> @enderror
          </div>
          <div class="form-group">
              <label for="price">Preço</label>
              <input  name="price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"   id="price" type="number" wire:model='price' description="price" class="form-control">
              @error('price') <span class="text-danger">{{$message}}</span> @enderror
          </div>
         <div id="quantity-div" class="form-group"  wire:ignore>
              <label for="quantity">Quantidade</label>
              <input name="quantity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"   id="quantity" type="number" wire:model='quantity' description="quantity" class="form-control">
              @error('quantity') <span class="text-danger">{{$message}}</span> @enderror
          </div>        
          
          <!-- Detalhes sobre o prato do dia  -->  
          
              <div id="detail-dishoftheday" class="d-none detail-dishoftheday" wire:ignore>
                <div  class="form-froup">
                    <label for="">Entrada:</label>
                      <select multiple  name="entrance[]" id="entrance"  class="form-control" wire:model="entrance">
                        <option value="">--Selecionar--</option>
                        @foreach ($dishes as $dish)
                          <option value="{{$dish->description ?? ""}}">{{$dish->description ?? ""}}</option>                      
                        @endforeach
                      </select>
                </div>

                <div wire:ignore class="form-group">
                  <label for="">Prato principal:</label>
                  <select name="maindish[]" id="maindish" multiple wire:ignore  class="form-control"  wire:model="maindish">
                    <option value="">--Selecionar--</option>
                      @if (isset($dishes) && count($dishes) > 0)
                        @foreach ($dishes as $dishe)
                          <option value="{{$dishe->description ?? ""}}">{{$dishe->description ?? ""}}</option>
                        @endforeach
                      @endif  
                  </select>

                </div>

                <div wire:ignore class="form-group">
                  <label for="">Sobremesa:</label>
                  <select name="dessert[]" multiple id="dessert" wire:ignore  wire:model="dessert" class="form-control">
                    <option value="">--Selecionar--</option>
                      @if (isset($dessertInput) && count($dessertInput) > 0)
                        @foreach ($dessertInput as $dessert)
                          <option value="{{$dessert->description ?? ""}}">{{$dessert->description ?? ""}}</option>
                        @endforeach
                      @endif
                  </select>
                </div>

                <div wire:ignore class="form-group">
                  <label for="">Bebida:</label>
                  <select name="drink[]" multiple id="drink" wire:ignore class="form-control"   wire:model="drink">
                    <option selected value="">-- Selecionar --</option>
                    @foreach ($drinks as $drink)
                      <option value="{{$drink->description ?? ""}}">{{$drink->description ?? ""}}</option>
                    @endforeach
                  </select>
                </div>

                <div wire:ignore class="form-group">
                  <label for="">Café:</label> 
                  
                  <select name="coffe[]" id="coffe" multiple wire:ignore class="form-control"  wire:model="coffe">
                    <option selected value="">-- Selecionar --</option>
                    @foreach ($coffes as $drink)
                      <option value="{{$drink->description ?? ""}}">{{$drink->description ?? ""}}</option>
                    @endforeach
                  </select>
                  {{-- <input class="form-control" type="text"  id="coffe" wire:model="coffe"> --}}
                </div>


              </div>

          <!-- Detalhes sobre o prato do dia  -->

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
  


