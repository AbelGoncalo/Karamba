<!doctype html>
<html lang="pt">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('/admin/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link href="{{asset('/admin/vendor/fonts/circular-std/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/admin/libs/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/vendor/fonts/fontawesome/css/fontawesome-all.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/vendor/charts/morris-bundle/morris.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/vendor/charts/c3charts/c3.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/vendor/fonts/flag-icon-css/flag-icon.min.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
  
    




    <title>@yield('title')</title>
</head>

<body>

  <div class="dashboard-main-wrapper">
  <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" style="color: #000;" href="{{route('panel.admin.home')}}">KARAMBA</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="fa fa-bars"></span>

                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                     
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{(auth()->user()->photo != null)? asset('/storage/profiles/'.auth()->user()->photo) : '/profile.png'}}" alt="Imagem do Utilizador logado" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">{{auth()->user()->name}}</h5>
                                    <span class="status"></span><span class="ml-2">
                                        <span class="indicator_online"></span>
                                        online
                                    </span>
                                </div>
                                <a class="dropdown-item" href="{{route('treasury.myaccount.account')}}"><i class="fas fa-user mr-2"></i>Conta</a>
                                    @livewire('auth.logout')
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
  </div>

  <div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        Menu
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{(Route::Current()->getName() == 'treasury.home') ? 'active':''}}" href="{{route('treasury.home')}}" >
                            <i class="fa fa-chart-pie"></i>
                            Dashboard</a>
                    </li>
                    
               
                    <li class="nav-item ">
                        <a class="nav-link {{(Route::Current()->getName() == 'treasury.make.invoice') ? 'active':''}} " href="{{route('treasury.make.invoice')}}" >
                            <i class="fa fa-file"></i>
                            Emitir Faturas</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{(Route::Current()->getName() == 'panel.tesoureiro.bank') ? 'active':''}} " href="{{route('panel.tesoureiro.bank')}}" >
                            <i class="fa fa-users"></i>
                            Contas Bancárias</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{(Route::Current()->getName() == 'panel.tesoureiro.saida') ? 'active':''}}" href="{{route('panel.tesoureiro.saida')}}" >
                            <i class="fa fa-arrow-left"></i>
                            Saidas</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{(Route::Current()->getName() == 'panel.tesoureiro.report') ? 'active':''}}" href="{{route('panel.tesoureiro.report')}}" >
                            <i class="fa fa-file-pdf"></i>
                            Relatórios</a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>

<div class="dashboard-wrapper">
  <div class="dashboard-ecommerce">
      <div class="container-fluid dashboard-content ">
        {{$slot}}
    </div>
  </div>
 
</div>





<x-livewire-alert::scripts />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{asset('/admin/vendor/jquery/jquery-3.3.1.min.js')}}"></script>
  <script src="{{asset('/admin/vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
  <script src="{{asset('/admin/vendor/slimscroll/jquery.slimscroll.js')}}"></script>
  <script src="{{asset('/admin/libs/js/main-js.js')}}"></script>
  <script src="{{asset('/admin/vendor/charts/sparkline/jquery.sparkline.js')}}"></script>
  <script src="{{asset('/admin/vendor/charts/morris-bundle/raphael.min.js')}}"></script>
  <script src="{{asset('/admin/vendor/charts/c3charts/c3.min.js')}}"></script>
  <script src="{{asset('/admin/vendor/charts/c3charts/d3-5.4.0.min.js')}}"></script>
  <script src="{{asset('/admin/vendor/charts/c3charts/C3chartjs.js')}}"></script>
  {{-- <script src="{{asset('/admin/libs/js/dashboard-ecommerce.js')}}"></script> --}}
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    @stack('select2')
    @stack('chart')


  
  
</body>

</html>