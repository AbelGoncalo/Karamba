<!DOCTYPE html>
<html lang="pt-ao">
<head>
    <meta charset="utf-8">
    <title>Kytutes</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="karamba" name="keywords">
    <meta content="FortCode" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset("/site/lib/animate/animate.min.css")}}" rel="stylesheet">
    <link href="{{asset("/site/lib/owlcarousel/site/owl.carousel.min.css")}}" rel="stylesheet">
    <link href="{{asset("/site/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css")}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset("/site/css/bootstrap.min.css")}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset("/site/css/style.css")}}" rel="stylesheet">
    <link href="{{asset("/css/showrating.css")}}" rel="stylesheet">
    <script src="{{asset("/js/custom.js")}}" defer></script>

     {{-- Select 2 --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- // --}}
    

</head>

<body>
    <div class="container-fluid bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border"  style="width: 3rem; height: 3rem; color:#cf597a" role="status">
                <span class="sr-only" style="color:#cf597a;">Processando...</span>
            </div>
        </div>
        <!-- Spinner End -->
  <!-- Navbar & Hero Start -->
  <div class="container-fluid position-relative p-0">
  @include('livewire.site.pages.nav')
  <!-- Navbar & Hero End -->
  
  @yield('content')
      
 


        <!-- Testimonial Start -->
      
        <!-- Testimonial End -->
        <a href="#" class="btn btn-lg  btn-lg-square back-to-top text-light" style="background-color: #9a2244;"><i class="bi bi-arrow-up"></i></a>
          <!-- Footer Start -->
  <div class="container-fluid text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="section-title ff-secondary text-start  fw-normal mb-4" style="color: #ffffff">Empresa</h4>
                <a class="btn btn-link" href="{{route('site.about')}}">Sobre Nós</a>
                {{-- <a class="btn btn-link" href="#">Contacte-nos</a> --}}
                <a class="btn btn-link" href="/#book">Marcar Reservar</a>
                <a class="btn btn-link" href="https://www.pachecobarroso.com/pb-privacy-policy">Politicas de privacidade</a>
                <a class="btn btn-link" href="https://www.pachecobarroso.com/pb-terms-conditions">Termos e Condições</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="section-title ff-secondary text-start  fw-normal mb-4" style="color: #ffffff">Contactos</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Ponte Molhada (Talatona)</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+244 928 121 231</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+244 924 102 499</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+244 997 612 235</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>geral@fortcodedev.com</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="section-title ff-secondary text-start  fw-normal mb-4" style="color: #ffffff">Atendimento</h4>
                <h5 class="text-light fw-normal">24/7</h5>
                <p>16:00 - 00:00</p>
                {{-- <h5 class="text-light fw-normal">Domingo</h5>
                <p>08:00 - 23:30</p> --}}
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">PB - Fort Code</a> | Direitos de reservados.
  
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="#">Home</a>
                        <a href="#">Cookies</a>
                        <a href="#">Help</a>
                        <a href="#">FQAs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <!-- Footer End -->
    </div>
   
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset("/site/lib/wow/wow.min.js")}}"></script>
    <script src="{{asset("/site/lib/easing/easing.min.js")}}"></script>
    <script src="{{asset("/site/lib/waypoints/waypoints.min.js")}}"></script>
    <script src="{{asset("/site/lib/counterup/counterup.min.js")}}"></script>
    <script src="{{asset("/site/lib/owlcarousel/owl.carousel.min.js")}}"></script>
    <script src="{{asset("/site/lib/tempusdominus/js/moment.min.js")}}"></script>
    <script src="{{asset("/site/lib/tempusdominus/js/moment-timezone.min.js")}}"></script>
    <script src="{{asset("/site/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js")}}"></script>
    <x-livewire-alert::scripts />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/0.9.0/jquery.mask.min.js" integrity="sha512-oJCa6FS2+zO3EitUSj+xeiEN9UTr+AjqlBZO58OPadb2RfqwxHpjTU8ckIC8F4nKvom7iru2s8Jwdo+Z8zm0Vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- Template Javascript -->
    <script src="{{asset("/site/js/main.js")}}"></script>
    
    @stack('select2')
    @stack('search-company')
    @stack('search-company-reserve')
    @stack('rating-show-comment')
 
     @if(session('empt-cart')) 
    <script>
        $(document).ready(function () {
            Swal.fire({
                title: "AVISO",
                text: "{!!session('empt-cart')!!}",
                icon: "warning",
                 timer:1500,
                 timerProgressBar: true,
                showConfirmButton: false,
             
                });
        });

    </script>
    @endif 
     @if(session('error')) 
    <script>
        $(document).ready(function () {
            Swal.fire({
                title: "ERRO",
                text: "{!!session('error')!!}",
                icon: "error",
                timer:1000,
                timerProgressBar: true,
                showConfirmButton: false,
                });
        });
      
    </script>
    @endif 
 

</body>

</html>