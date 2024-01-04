<div wire:ignore.self data-backdrop='static' class="modal fade" id="stockout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar Saida de':'Saida de '}} Estoque</h5>
          <button  type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form wire:submit="{{($edit != '')? 'update':'save'}}" id="basicform">
           <div class="row">
            <div class="form-group col-md-12" wire:ignore>
              <label for="">Produto</label>
              <select  name="product_economate_id" wire:model="product_economate_id" id="product_economate_id" class="form-control select2-stockout">
                <option value="">--Selecionar--</option>
                @if ($items->count() > 0)
                    @foreach ($items as $item)
                       <option value="{{$item->id}}">{{$item->description}}</option>
                    @endforeach
                @endif
              </select>
              @error('product_economate_id') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="form-group col-md-6">
              <label for="">Quantidade</label>
             <input type="number" min="0" name="quantity" wire:model='quantity' id="quantity" class="form-control" >
             @error('quantity') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="form-group col-md-6">
              <label for="unit">Unidade</label>
                <label for="unit">Unidade</label>
                <input readonly type="text" name="unit" id="unit" wire:model='unit' class="form-control">
                @error('unit') <span class="text-danger">{{$message}}</span> @enderror
             </div>
           
            <div class="form-group col-md-6">
              <label for="">Utilização</label>
              <input type="text" name="usetype" wire:model='usetype' id="usetype" class="form-control" >
             @error('usetype') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="form-group col-md-6">
              <label for="">Responsável</label>
              <input type="text" name="chef" wire:model='chef' id="chef" class="form-control" >
             @error('chef') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="form-group col-md-6" wire:ignore>
              <label for="description">Origem</label>
              <select name="from" id="from" wire:model='from' class="form-control select-from">
                <option value="">--Selecionar--</option>
              @if (isset($Compartments) and $Compartments->count() > 0)
                @foreach ($Compartments as $item)
                  <option value="{{$item->description}}">{{$item->description}}</option>
                @endforeach
              @endif
              </select>
              @error('from') <span class="text-danger">{{$message}}</span> @enderror

          </div>

          <div class="form-group col-md-6" wire:ignore>
            <label for="description">Destino</label>
            <select name="to" id="to" wire:model='to' class="form-control select-to">
              <option value="">--Selecionar--</option>
              @if (isset($Compartments) and $Compartments->count() > 0)
                @foreach ($Compartments as $item)
                  <option value="{{$item->description}}">{{$item->description}}</option>
                @endforeach
              @endif
            </select>
            @error('to') <span class="text-danger">{{$message}}</span> @enderror

        </div>
            <div class="form-group col-md-12">
              <label for="">Nota</label>
             <textarea placeholder="Nota Adicional"  name="description" wire:model='description' id="description" class="form-control"></textarea>
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
    