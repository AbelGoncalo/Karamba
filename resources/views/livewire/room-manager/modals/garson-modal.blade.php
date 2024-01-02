<div wire:ignore.self data-bs-backdrop='static' class="modal fade" id="garsons" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'ACTUALIZAR DADOS':'ATRIBUIR MESA'}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" wire:submit.prevent='{{($edit != null)? 'update':'store'}} ' class="row">
              
          <div class="col-md-12">
           
               <div class="form-group" wire:ignore>
                <label for="user">Garçon</label>
                <select  wire:model.live="garson" id="garson"  class="form-control selectgarson @error('garson') is-invalid @enderror">
                  <option value="">Selecionar</option>
                  @if ($users->count() > 0)
                      @foreach ($users as $item)
                          <option  value="{{$item->id}}">{{$item->name}} {{$item->lastname}}</option>
                      @endforeach
                  @endif
                </select>
                @error('garson') <span class="text-danger">{{$message}}</span> @enderror
              </div> 
               <div class="form-group"  wire:ignore>
                <label for="table">Mesas</label>
                <select multiple wire:model.live="table" id="table" name="table"  class="form-control selecttable @error('table') is-invalid @enderror">
                  @if ($tables->count() > 0)
                      @foreach ($tables as $item)
                          <option   value="{{$item->number ?? old('table')}}">{{$item->number}}</option>
                      @endforeach
                  @endif 
                </select>

                
                @error('table') <span class="text-danger">{{$message}}</span> @enderror
              </div> 
          </div>
      </div>

      
      <div class="modal-footer">
        <button type="submit" class="btn btn-sm" style=" background-color: #222831e5;color:#fff;">Salvar</button>
      </div>
    </form>
    </div>
  </div>
</div>
  