<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css" integrity="sha512-siarrzI1u3pCqFG2LEzi87McrBmq6Tp7juVsdmGY1Dr8Saw+ZBAzDzrGwX3vgxX1NkioYNCFOVC0GpDPss10zQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{asset('/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/libs/css/style.css')}}">
  {{-- Select 2 --}}
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    
  <title>@yield('title')</title>
</head>
<body>
  <nav class="navbar navbar-expand-sm navbar-light" id="neubar">
    <div class="container">
      <a class="navbar-brand" href="{{route('room.manager.home')}}">
        KARAMBA
      </a>
      <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <div class=" collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto ">
          <li class="nav-item">
            <a  class="nav-link mx-2 {{(Route::Current()->getName() == 'room.manager.home') ? 'active':''}} " aria-current="page" href="{{route('room.manager.home')}}">Fluxo de Atendimento</a>
          </li>
          <li class="nav-item">
            <a  class="nav-link mx-2 {{(Route::Current()->getName() == 'room.manager.garson') ? 'active':''}} " aria-current="page" href="{{route('room.manager.garson')}}">Garçons</a>
          </li>
          <li class="nav-item">
            <a  class="nav-link mx-2 {{(Route::Current()->getName() == 'room.manager.report') ? 'active':''}} " aria-current="page" href="{{route('room.manager.report')}}">Relatórios</a>
          </li>
          <li class="nav-item">
            <a  class="nav-link mx-2 {{(Route::Current()->getName() == 'room.manager.review') ? 'active':''}} " aria-current="page" href="{{route('room.manager.review')}}">Avaliações</a>
          </li>
          <li class="nav-item">
            @livewire('room-manager.delivery-count')
          </li>
          <li class="nav-item">
            @livewire('room-manager.order-count')
          </li>
          <li class="nav-item">
            @livewire('room-manager.reserve-count')
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{auth()->user()->name ?? ''}} {{auth()->user()->lastname ?? ''}}
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item text-dark" style="color: #000 !important" href="{{route('room.manager.account')}}"><i class="fas fa-user mr-2"></i> Conta</a></li>
              <li><a class="dropdown-item text-dark" style="color: #000 !important" href="{{route('panel.room.manager.service.control')}}"><i class="fas fa-clock mr-2"></i> Tempo de Entregas</a></li>
              @livewire('auth.logout')
            </ul>
          </li>
  
        </ul>
      </div>
    </div>
  </nav>
    <main class="container">
      <div class="row mt-5">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE CHEFE DE SALA</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          @if (Route::Current()->getName() == 'room.manager.home')
                          <li class="breadcrumb-item"><a href="{{route('room.manager.home')}}" class="breadcrumb-link">Fluxo de Atendimento</a></li>
                          @elseif (Route::Current()->getName() == 'room.manager.garson')
                          
                          <li class="breadcrumb-item"><a href="{{route('room.manager.garson')}}" class="breadcrumb-link">Fluxo de Atendimento</a></li>
                          @elseif (Route::Current()->getName() == 'room.manager.account')
                          
                          <li class="breadcrumb-item"><a href="{{route('room.manager.account')}}" class="breadcrumb-link">Minha Conta</a></li>
                          @elseif (Route::Current()->getName() == 'room.manager.report')
                          <li class="breadcrumb-item"><a href="{{route('room.manager.report')}}" class="breadcrumb-link">Relatórios</a></li>
                          
                          @elseif (Route::Current()->getName() == 'room.manager.review')
                          <li class="breadcrumb-item"><a href="{{route('room.manager.review')}}" class="breadcrumb-link">Avaliações</a></li>
                          @elseif (Route::Current()->getName() == 'panel.room.manager.delivery')
                          <li class="breadcrumb-item"><a href="{{route('panel.room.manager.delivery')}}" class="breadcrumb-link">Encomendas
                          </a></li>

                          @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
      <div class="row">
        {{$slot}}
      </div>
    </main>
      
      <x-livewire-alert::scripts />
      <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/fontawesome.min.js" integrity="sha512-64O4TSvYybbO2u06YzKDmZfLj/Tcr9+oorWhxzE3yDnmBRf7wvDgQweCzUf5pm2xYTgHMMyk5tW8kWU92JENng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

      @stack('select2-garson')
      @stack('select2-tables')
      @stack('selects')
</body>
</html>