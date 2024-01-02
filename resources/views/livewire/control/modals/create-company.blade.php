<div wire:ignore.self data-backdrop='static' class="modal fade" id="create-company" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> {{($edit != '')? 'Actualizar':'Adicionar'}} Restaurante</h5>
          <button   type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form wire:submit.prevent='{{($edit != '')? 'update':'save'}}' enctype="multipart/form-data" class="container">
                <div class="row">
                <div class="col-md-6">
                    <label for="companyname">
                        Designação da Empresa
                    </label>
                    <input  type="text" wire:model="companyname" id="companyname" class="form-control" placeholder="Designação da Empresa">
                    @error('companyname') <span class="text-danger">{{$message}}</span> @enderror
                </div>

                <div x-data="{isUploading: false, progress: 0}" class="form-group col-md-6"
                x-on:livewire-upload-start = "isUploading = true"
                x-on:livewire-upload-finish = "isUploading = false"
                x-on:livewire-upload-error = "isUploading = false"
                x-on:livewire-upload-progress = "progress = $event.detail.progress"
                >
                <label for="companylogo">Logotipo</label>
                <input accept="png,gif,jpeg,jpg"  id="companylogo" type="file" wire:model='companylogo' description="companylogo" class="form-control w-100">
                <div x-show="isUploading" class="progress progress-striped active w-100 mt-3" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="10">
                  <div class="progress-bar progress-bar-success" x-bind:style="`width:${progress}%`" data-dz-uploadprogress></div>
                </div>
                </div>
                <div class="col-md-6 ">
                    <label for="companynif">
                       NIF
                    </label>
                    <input type="text" wire:model="companynif" id="companynif" class="form-control" placeholder="Nº de Contribuente">
                    @error('companynif') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-6 ">
                    <label for="companyregime">
                        Regime
                    </label>
                   <select wire:model="companyregime" id="companyregime" class="form-control">
                    <option value="" selected>Selecionar</option>
                    <option value="Exclusão (0%)">Exclusão (0%)</option>
                    <option value="Simplificado (7%)">Simplificado (7%)</option>
                    <option value="Geral (14%)">Geral (14%)</option>
                   </select>
                   @error('companyregime') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                
                <div class="col-md-6 ">
                    <label for="companyphone">
                        Telefone
                    </label>
                    <input type="tel" wire:model="companyphone" id="companyphone" class="form-control" placeholder="999-999-999">
                    @error('companyphone') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-6 ">
                    <label for="companyalternativephone">
                        Telefone Alternativo
                    </label>
                    <input type="tel" wire:model="companyalternativephone" id="companyalternativephone" class="form-control" placeholder="999-999-999">
                </div>
                <div class="col-md-6 ">
                    <label for="companyemail">
                        E-mail
                    </label>
                    <input type="email" wire:model="companyemail" id="companyemail" class="form-control" placeholder="999-999-999">
                    @error('companyemail') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-6 ">
                    <label for="companycountry">
                        País
                    </label>
                    <input type="text" wire:model="companycountry" id="companycountry" class="form-control" placeholder="Provincia">
                    @error('companycountry') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-6 ">
                    <label for="companybusiness">
                        Provincia
                    </label>
                    <input type="text" wire:model="companyprovince" id="companyprovince" class="form-control" placeholder="Provincia">
                    @error('companyprovince') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-6 ">
                    <label for="companymunicipality">
                        Município
                    </label>
                    <input type="text" wire:model="companymunicipality" id="companymunicipality" class="form-control" placeholder="Provincia">
                    @error('companymunicipality') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-12">
                    <label for="companyaddress">
                        Localização Específica
                    </label>
                    <input type="text" wire:model="companyaddress" id="companyaddress" class="form-control" placeholder="Localização Específica">
                    @error('companyaddress') <span class="text-danger">{{$message}}</span> @enderror
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
    