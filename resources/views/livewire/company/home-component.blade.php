@section('title','Restaurante')
<div class="col-md-12 mt-3">
    <div class="card">
        <div class="card-header">
            <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap">
                <h4>Dados da Empresa</h4>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent='update' enctype="multipart/form-data" class="col-md-12 d-flex justify-content-center flex-wrap align-items-center">
                <div class="col-md-2">
                    <label for="companylogo">
                        <img title="Clicar para carregar logotipo" class="img-fluid rounded shadow" src="{{(isset($companylogo) && $companylogo != null)? asset('/storage/'.$companylogo):asset('/not-found.png')}}" alt="Logotipo da Empresa" style="cursor: pointer; height:10rem;width:10rem;">
                    </label>
                    <input  type="file" wire:model="companylogo" id="companylogo" class="d-none" class="hidden">
                </div>
                <div class="col-md-10">
                    <label for="companyname">
                        Designação da Empresa
                    </label>
                    <input  type="text" wire:model="companyname" id="companyname" class="form-control" placeholder="Designação da Empresa">
                    @error('companyname') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-4 mt-4">
                    <label for="companynif">
                       NIF
                    </label>
                    <input type="text" wire:model="companynif" id="companynif" class="form-control" placeholder="Nº de Contribuente">
                    @error('companynif') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-4 mt-4">
                    <label for="companyregime">
                        Moeda
                    </label>
                   <select wire:model="companycoin" id="companycoin" class="form-control">
                   
                    <option value="Kwanza (AOA)" selected>Kwanza (AOA)</option>
                    <option value="Dolar ($)">Dolar ($)</option>
                   </select>
                   @error('companycoin') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-4 mt-4">
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
                <div class="col-md-4 mt-4">
                    <label for="companyphone">
                        Telefone
                    </label>
                    <input type="tel" wire:model="companyphone" id="companyphone" class="form-control" placeholder="999-999-999">
                    @error('companyphone') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-4 mt-4">
                    <label for="companyalternativephone">
                        Telefone Alternativo
                    </label>
                    <input type="tel" wire:model="companyalternativephone" id="companyalternativephone" class="form-control" placeholder="999-999-999">
                </div>
                <div class="col-md-4 mt-4">
                    <label for="companyemail">
                        E-mail
                    </label>
                    <input type="email" wire:model="companyemail" id="companyemail" class="form-control" placeholder="999-999-999">
                    @error('companyemail') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-4 mt-4">
                    <label for="companyemail">
                        Website
                    </label>
                    <input type="text" wire:model="companywebsite" id="companywebsite" class="form-control" placeholder="www.exe.com">
                    @error('companywebsite') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-4 mt-4">
                    <label for="companybusiness">
                        Razão Social
                    </label>
                    <input type="text" wire:model="companybusiness" id="companybusiness" class="form-control" placeholder="Razão Social">
                </div>
                <div class="col-md-4 mt-4">
                    <label for="companyslogan">
                        Slogan
                    </label>
                    <input type="text" wire:model="companyslogan" id="companyslogan" class="form-control" placeholder="Slogan">
                </div>
                <div class="col-md-4 mt-4">
                    <label for="companycountry">
                        País
                    </label>
                    <input type="text" wire:model="companycountry" id="companycountry" class="form-control" placeholder="Provincia">
                    @error('companycountry') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-4 mt-4">
                    <label for="companybusiness">
                        Provincia
                    </label>
                    <input type="text" wire:model="companyprovince" id="companyprovince" class="form-control" placeholder="Provincia">
                    @error('companyprovince') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-4 mt-4">
                    <label for="companymunicipality">
                        Município
                    </label>
                    <input type="text" wire:model="companymunicipality" id="companymunicipality" class="form-control" placeholder="Provincia">
                    @error('companymunicipality') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-4 mt-4">
                    <label for="companyaddress">
                        Código de Pedido
                    </label>
                    <input type="text" readonly wire:model="companyordercode" id="companyordercode" class="form-control" placeholder="Código de Pedido Interno">
                </div>
                <div class="col-md-8 mt-4">
                    <label for="companyaddress">
                        Localização Específica
                    </label>
                    <input type="text" wire:model="companyaddress" id="companyaddress" class="form-control" placeholder="Localização Específica">
                    @error('companyaddress') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-12 mt-2 d-flex justify-content-end align-items-center flex-wrap">
                    <button class="btn btn-md btn-primary ">
                       <i class="fas fa-save"></i>
                       Gravar
                    </button>
                </div>


            </form>
        </div>
        <div class="card-footer text-center text-primary text-sm">

        </div>
    </div>

</div>
<script>
    // document.addEventListener('refresh',function(){
    //     location.reload(); 
    // })
    
</script>