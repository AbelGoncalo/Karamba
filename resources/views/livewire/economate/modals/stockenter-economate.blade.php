<div wire:ignore.self data-backdrop='static' class="modal fade" id="stockenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar Entrada de ':'Entrada de '}} Estoque</h5>
          <button wire:click='clearFiled'  type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form wire:submit='{{($edit != '')? 'update':'save'}}' id="basicform">
           <div class="row">
            <div class="form-group col-md-12" wire:ignore>
              <label for="">Ingrediente</label>
              <select  name="product_economate_id" wire:model="product_economate_id" id="product_economate_id" class="form-control">
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
              <label for="description">Unidade</label>
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
            <div class="form-group col-md-6">
              <label for="">Preço de Compra</label>
             <input type="number" name="price" wire:model='price' id="price" class="form-control">
             @error('price') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="form-group col-md-6">
              <label for="">Fonte</label>
             <input type="text" placeholder="Informe a fonte do produto" name="source" wire:model='source' id="source" class="form-control">
             @error('source') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="form-group col-md-6">
              <label for="source_product">Origem</label>
             <input type="text" placeholder="Informe a origem do produto" name="source_product" wire:model='source_product' id="source_product" class="form-control">
             @error('source_product') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="form-group col-md-6">
              <label for="expiratedate">Data de Expiração</label>
             <input type="date"  name="expiratedate" wire:model='expiratedate' id="expiratedate" class="form-control">
             @error('expiratedate') <span class="text-danger">{{$message}}</span> @enderror
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
    