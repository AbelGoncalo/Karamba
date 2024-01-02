
    @section('title','Registrar-se')
    <form   method="POST" wire:submit='createAccount' class="col-md-12 d-flex justify-content-center align-items-center flex-wrap">
        @csrf
        @method('POST')
        
            <div class="card col-md-6">
                
                <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Nome<span class="text-danger">*</span></label>
                                <input class="form-control  form-control-lg form-control  form-control-lg-lg" wire:model='name' type="text" name="name"  placeholder="Informe o Nome" autocomplete="off">
                                @error('name')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lastname">Sobrenome<span class="text-danger">*</span></label>
                                <input class="form-control  form-control-lg form-control  form-control-lg-lg" wire:model='lastname' type="text" name="lastname"  placeholder="Informe o Sobrenome" autocomplete="off">
                                @error('lastname')<span class="text-danger">{{$message}}</span>@enderror
                            </div>

                        </div>
                   <div class="row">
                    <div class="form-group col-md-6">
                        <label for="email">E-mail<span class="text-danger">*</span></label>
                        <input class="form-control  form-control-lg form-control  form-control-lg-lg" wire:model='email' id="email" type="email"  placeholder="Informe o E-mail">
                        @error('email')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Senha<span class="text-danger">*</span></label>
                        <input class="form-control  form-control-lg form-control  form-control-lg-lg" type="password" wire:model='password' id="password" name="password"  placeholder="Informe a Senha">
                        @error('password')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                   </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                        <label for="cpassword">Confirmar Senha<span class="text-danger">*</span></label>
                        <input class="form-control  form-control-lg form-control  form-control-lg-lg" type="password" wire:model='cpassword' id="cpassword" name="cpassword"  placeholder="Confirmar Senha">
                        @error('cpassword')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
             
                        <div class="form-group col-md-6" wire:ignore>
                            <label for="company">Restaurante<span class="text-danger">*</span></label>
                            <select wire:model="companyid" name="company" id="companyselect" class="form-control">
                                <option value="">--Restaurante--</option>
                                @if ($companies->count() > 0)
                                    @foreach ($companies as $item)
                                        <option value="{{$item->id}}">{{$item->companyname}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('company')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group pt-2">
                        <button style="background-color: #cdb81a; color:#fff" class="btn btn-block text-light" type="submit">Registrar minha Conta</button>
                    </div>
                    <div class="form-group col-md-12 d-flex justify-content-center flex-wrap align-items-center">
                        <label class="custom-control custom-checkbox" style="cursor: pointer">
                            <input required class="custom-control-input" wire:model='acceptterms' type="checkbox"><span class="custom-control-label">Ao criar uma conta, você concorda com os <a href="#" class="text-secondary">termos e condições</a></span>
                    </div>
                </div>
                <div class="card-footer bg-white text-center" style="margin-top:-2rem">
                    <span>Já tem uma conta? <a href="{{route('auth.login')}}" class="text-secondary">Fazer Login.</a></span><br>
                    <span><a href="{{route('site.home')}}">Ir para início</a></span>

                </div>
            </div>
      
    </form>


    @push('companyselect')
    <script>
        $(document).ready(function() {
            $('#companyselect').select2({
              theme: "bootstrap-5"
            });
        
            $('#companyselect').change(function (e) { 
              e.preventDefault();
              @this.set('companyid', $('#companyselect').val());
            });
        });
        </script>
    @endpush

