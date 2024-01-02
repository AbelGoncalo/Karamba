<div wire:ignore.self data-backdrop='static' class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar':'Adicionar'}} Utilizador</h5>
        <button wire:click='clear' type="button" class="close" data-dismiss="modal" aria-label="Close">
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
              <label for="phone">Telefone</label>
              <input   id="phone" type="text" wire:model='phone' name="phone" class="form-control">
              @error('phone') <span class="text-danger">{{$message}}</span> @enderror
          </div>
          <div class="form-group">
              <label for="email">E-mail</label>
              <input   id="email" type="email" wire:model='email' name="email" class="form-control">
              @error('email') <span class="text-danger">{{$message}}</span> @enderror
          </div>
          <div class="form-group">
              <label for="photo">Imagem</label>
              <div x-data="{isUploading: false, progress: 0}" class=""
                  x-on:livewire-upload-start = "isUploading = true"
                  x-on:livewire-upload-finish = "isUploading = false"
                  x-on:livewire-upload-error = "isUploading = false"
                  x-on:livewire-upload-progress = "progress = $event.detail.progress"
                  >
              <input   id="photo" type="file" wire:model='photo' name="photo" class="form-control w-100">
              @error('photo') <span class="text-danger">{{$message}}</span> @enderror
              <div x-show="isUploading" class="progress progress-striped active w-100 mt-3" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="10">
                <div class="progress-bar progress-bar-success" x-bind:style="`width:${progress}%`" data-dz-uploadprogress></div>
              </div>
              </div>
          </div>
          <div class="form-group">
            
            @if ($edit != null &&  $photo != null)
            <p>Imagem Existente</p>
            <img class="img-fluid rounded-full" style="width:100%;height:10rem; object-fit:cover " src="{{($photo != null) ? asset('storage/profiles/'.$photo): asset('not-found.png')}}" alt="Imagem do Utilizador {{$name}}">
         
            @endif

          </div>
          <div class="form-group">
            <label for="profile">Nível Acesso</label>
            <select name="profile" id="profile" wire:model='profile' class="form-control">
              <option value="">--Selecionar--</option>
              <option value="administrador">Administrador</option>
              <option value="garçon">Garçon</option>
              <option value="tesoureiro">Tesoureiro</option>
              <option value="gestor-economato">Gestor de Economato</option>
              <option value="chef-de-cozinha">Chefe de Cozinha</option>
              <option value="chef-de-sala">Chefe de Sala</option>
            </select>
            @error('level') <span class="text-danger">{{$message}}</span> @enderror
        </div>

        
         
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
    </div>
  </div>
</div>
  