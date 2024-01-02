<nav style="{{(Route::Current()->getName() == 'site.companies' || Route::Current()->getName() == 'site.company' || Route::Current()->getName() == 'site.about' || Route::Current()->getName() == 'site.cart') ? 'background-color: var(--primary) !important; margin-bottom:5rem !important':''}}" class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0"  style="background-color: red">
    <a href="{{route('site.home')}}" class="navbar-brand p-0">
        <h1 class="text-light m-0"><i class="fa fa-utensils me-3"></i>KARAMBA</h1>
        <!-- <img src="img/logo.png" alt="Logo"> -->
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0 pe-4">
            <a href="{{route('site.home')}} "   class="nav-item nav-link active">Home</a>
            <a href="{{route('site.companies')}}" style='{{(Route::Current()->getName() == 'site.companies') ? 'color:#0f172b !important':''}}' class="nav-item nav-link">Menu</a>
            <a href="{{route('site.about')}}" class="nav-item nav-link" style='{{(Route::Current()->getName() == 'site.about') ? 'color:#0f172b !important':''}}'>Sobre</a>
            <a href="{{route('auth.login')}}" class="nav-item nav-link">
              Entrar
            </a>
            <a href="{{route('site.cart')}}" class="nav-item nav-link">
                <i class="fa fa-shopping-cart"></i>
                @livewire('site.cart-count')
            </a>
        </div>
    </div>
</nav>

  @if (Route::Current()->getName() == 'site.home' )

  <div class="container-fluid py-5 bg-dark hero-header mb-5">
     <div class="container my-5 py-5">
         <div class="row g-5 mt-3">
             <div class="col-lg-12  text-lg-center">
                 <h1 class="display-1 text-white slideInLeft" style="font-size: 12vw;">KARAMBA</h1>
                 <p class="text-white animated slideInLeft mb-4 pb-2">Faça já o seu pedido online, Espaço Karamba</p>
                 <p class="text-white animated slideInLeft mb-4 pb-2"><i class="fa fa-map-marker-alt me-3"></i>Ponte Molhada (Talatona)</p>
                 <a href="{{route('site.companies')}}" class="btn  py-sm-3 px-sm-5 me-3 animated slideInLeft text-light" style="background-color: var(--primary);">Ver Menu</a>
             </div>
         </div>
     </div>
 </div>
      
  @endif
</div>