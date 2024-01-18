@section('title','Login')
<div class="col-md-12 d-flex justify-content-center align-items-center flex-wrap">
    <div class="card col-md-6">
        <div class="card-header text-center">
           <span class="splash-description">LOGIN</span>
       </div>
        <div class="card-body col-md-12">
            
            <form wire:submit='login' method="POST">
                @method('POST')
                @csrf
                <div class="form-group">
                 
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input wire:model='email' class="form-control form-control-sm form-control-lg" id="email" type="email" placeholder="email" autocomplete="off">
                    @error('email') <span class="text-danger">{{$message}}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input wire:model='password' class="form-control form-control-lg" id="password" type="password" placeholder="Password">
                    @error('password') <span class="text-danger">{{$message}}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                        <input class="custom-control-input" wire:model='remember' type="checkbox"><span class="custom-control-label">Lembrar me</span>
                    </label>
                </div>
                <button type="submit" class="btn  btn-lg btn-block text-light" style="background-color: #cf597a">Entrar</button>
                <div class="form-group text-center mt-4">
                  <span><a href="{{route('auth.signup')}}">Não possui uma conta?</a></span> <br>
                   <span><a href="{{route('auth.reset.password')}}">Esqueceu suas credências?</a></span><br>
                   <span><a href="{{route('site.home')}}">Ir para início</a></span>
                </div>
            </form>
        </div>
    </div>
</div>