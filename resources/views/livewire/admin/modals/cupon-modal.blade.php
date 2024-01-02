<div wire:ignore.self data-backdrop='static' class="modal fade" id="cupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar':'Adicionar'}} Cupon</h5>
        <button wire:click='clear'  type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" wire:submit.prevent='{{($edit != null)? 'update':'store'}} ' class="row">
              
          <div class="col-md-12">
           
            <div class="form-group" wire:ignore>
              <label for="user">Utilizador</label>
              <select wire:model.defer="user" id="user"  class="form-control select2-users @error('user') is-invalid @enderror">
                <option value="">Selecionar</option>
                @if ($users->count() > 0)
                    @foreach ($users as $item)
                        <option data-id="{{$item->id}}"  value="{{$item->id ?? old('user')}}">{{$item->name}}</option>
                    @endforeach
                @endif
              </select>
              @error('user') <span class="text-danger">{{$message}}</span> @enderror
                
              

            </div>
       
            <div class="form-group">
              <label for="type">Tipo de Valor</label>
              <select      wire:model.defer='type' class="form-control @error('type') is-invalid @enderror">
                  <option value="" selected>Selecionar</option>
                  <option value="percent">Percentagem (%)</option>
                  <option value="fixed">Valor Fixo</option>
              </select>
              @error('type') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        
            <div class="form-group">
              <label for="value">Valor</label>
             <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"   placeholder="0" value="{{old('value')}}" type="number" min="1" wire:model.defer="value" id="value" class="form-control @error('value') is-invalid @enderror">
             @error('value') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="form-group">
              <label for="value">Máximo de Uso</label>
              <select name="times" wire:model='times' id="times" class="form-control">
                <option value="1">1 Vez</option>
                <option value="2">2 Vezes</option>
                <option value="3">3 Vezes</option>
                <option value="4">4 Vezes</option>
                <option value="5">5 Vezes</option>
                <option value="6">6 Vezes</option>
              </select>
             @error('times') <span class="text-danger">{{$message}}</span> @enderror
            </div>
           
            <div class="form-group">
              <label for="expirateDate">Validade</label>
             <input   type="date" value="{{old('expirateDate')}}" wire:model.defer="expirateDate" id="expirateDate" class="form-control @error('expirateDate') is-invalid @enderror"  >
             @error('expirateDate') <span class="text-danger">{{$message}}</span> @enderror
            </div>
          </div>
          
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
    </div>
  </div>
</div>
  