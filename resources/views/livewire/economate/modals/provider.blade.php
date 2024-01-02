<div wire:ignore.self data-backdrop='static' class="modal fade" id="provider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar':'Adicionar'}} Fornecedor</h5>
          <button wire:click='clear'  type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form wire:submit='{{($edit != '')? 'update':'save'}}' id="basicform">
           <div class="row">
            <div class="form-group col-md-6">
              <label for="description">Tipo</label>
              <select wire:model.live='type' name="type" id="type" class="form-control">
                <option value="">--Selecionar--</option>
                <option value="Empresa">Empresa</option>
                <option value="Particular">Particular</option>
              </select>
              @error('type') <span class="text-danger">{{$message}}</span> @enderror
          </div>
            <div class="form-group col-md-6">
              <label for="description">Nif</label>
              <input  id="nif" type="text" wire:model='nif' name="nif" placeholder="Nif do fornecedor" autocomplete="on" class="form-control">
              @error('nif') <span class="text-danger">{{$message}}</span> @enderror
          </div>
            <div class="form-group col-md-6">
              <label for="description">Nome</label>
              <input id="description" type="text" wire:model='name' name="name" placeholder="Nome do Fornecedor" autocomplete="on" class="form-control">
              @error('name') <span class="text-danger">{{$message}}</span> @enderror
          </div>
            <div class="form-group col-md-6">
              <label for="description">E-mail</label>
              <input id="email" type="email" wire:model='email' name="email" placeholder="E-mail do Fornecedor" autocomplete="on" class="form-control">
              @error('email') <span class="text-danger">{{$message}}</span> @enderror
          </div>
            <div class="form-group col-md-6">
              <label for="phone">Telefone</label>
              <input id="phone" type="text" wire:model='phone' name="phone"  autocomplete="on" class="form-control">
              @error('phone') <span class="text-danger">{{$message}}</span> @enderror
          </div>
            <div class="form-group col-md-6">
              <label for="alternativephone">Telefone Alternativo</label>
              <input id="alternativephone" type="text" wire:model='alternativephone' name="alternativephone"  autocomplete="on" class="form-control">
              @error('alternativephone') <span class="text-danger">{{$message}}</span> @enderror
          </div>
            <div class="form-group col-md-12">
              <label for="address">Endereço</label>
              <input id="address" type="text" wire:model='address' name="address" placeholder="Endereço do fornecedor"  autocomplete="on" class="form-control">
              @error('address') <span class="text-danger">{{$message}}</span> @enderror
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
    