<div wire:ignore.self data-backdrop='static' class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar':'Adicionar'}} Cliente</h5>
        <button  type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form wire:submit='{{($edit != '')? 'update':'save'}}' id="basicform">
          <div class="form-group">
              <label for="name">Nome</label>
              <input id="name" type="text" wire:model='name' name="name" placeholder="Informe o Nome" autocomplete="on" class="form-control">
              @error('name') <span class="text-danger">{{$message}}</span> @enderror
          </div>
          <div class="form-group">
              <label for="lastname">Sobrenome</label>
              <input id="lastname" type="text" wire:model='lastname' name="lastname" placeholder="Informe o Sobrenome" autocomplete="on" class="form-control">
              @error('lastname') <span class="text-danger">{{$message}}</span> @enderror
          </div>
          <div class="form-group">
              <label for="lastname">Gênero</label>
              <select name="genre" id="genre" wire:model='genre' class="form-control">
                <option value="">--Selecionar--</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select>
              @error('genre') <span class="text-danger">{{$message}}</span> @enderror
          </div>

          <div class="form-group">
            <label for="email">E-mail</label>
            <input   id="email" type="email" wire:model='email' name="email" class="form-control">
            @error('email') <span class="text-danger">{{$message}}</span> @enderror
          </div>

          <div class="form-group">
            <label for="phone">Telefone</label>
            <input   id="phone" type="text" wire:model='phone' name="phone" class="form-control">
              @error('phone') <span class="text-danger">{{$message}}</span> @enderror
          </div>

          <div class="form-group">
            <label for="provincia">Provincia</label>
            <input   id="provincia" type="text" wire:model='provincia' name="provincia" class="form-control">
              @error('provincia') <span class="text-danger">{{$message}}</span> @enderror
          </div>

          <div class="form-group">
            <label for="municipio">Município</label>
            <input   id="municipio" type="text" wire:model='municipio' name="municipio" class="form-control">
              @error('municipio') <span class="text-danger">{{$message}}</span> @enderror
          </div>

          <div class="form-group">
            <label for="bairro">Bairro</label>
            <input   id="bairro" type="text" wire:model='bairro' name="bairro" class="form-control">
              @error('bairro') <span class="text-danger">{{$message}}</span> @enderror
          </div>

          <div class="form-group">
            <label for="rua">Rua</label>
            <input   id="rua" type="text" wire:model='rua' name="rua" class="form-control">
              @error('rua') <span class="text-danger">{{$message}}</span> @enderror
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
    </div>
  </div>
</div>
  