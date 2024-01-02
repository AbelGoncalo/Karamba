@section('title','Recuperar Senha')
<div class="col-md-12 d-flex justify-content-center align-items-center flex-wrap">
    <div class="card col-md-6">
        <div class="card-header text-center">
           <span class="splash-description">RECUPERAR SENHA</span>
       </div>
        <div class="card-body col-md-12">
            
            <form wire:submit='resetPassword' method="POST">
                @method('POST')
                @csrf
                <div class="form-group">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input wire:model='email' class="form-control form-control-sm form-control-lg" id="email" type="email" placeholder="email" autocomplete="off">
                    @error('email') <span class="text-danger">{{$message}}</span>@enderror
                </div>
                <button type="submit" class="btn  btn-lg btn-block text-light" style="background-color: #cdb81a">Recuperar</button>
                <div class="form-group text-center mt-4">
                     <span><a href="{{route('site.home')}}">Ir para início</a></span>
                  </div>
                
            </form>
        </div>
    </div>
</div>