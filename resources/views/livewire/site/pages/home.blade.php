@extends('layouts.site.app')
@section('content')
      <!-- Service Start -->
  <div class="container-fluid  py-5" id="about">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-user-tie mb-4" style="color: var(--primary);"></i>
                        <h5>Master Chefs</h5>
                        <p>Os Melhores chefes de cuzinha encontras cá na nice food</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-utensils mb-4" style="color: var(--primary);"></i>
                        <h5>Comida de qualidade</h5>
                        <p>A boa alimentação encontras aqui</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-cart-plus mb-4" style="color: var(--primary);"></i>
                        <h5>Pedido Online</h5>
                        <p>Se tiveres fome é só pedires a comida online</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-headset mb-4" style="color: var(--primary);"></i>
                        <h5> Atendimento 24 por dia / 7  dias por semana </h5>
                        <p>Ó nosso horario é flexivel para facilitar os nossos clientes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <!-- Service End -->

    
  <!-- About Start -->
  <div class="container-fluid py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6 text-start">
                        <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s" src="/site/img/about-1.jpg">
                    </div>
                    <div class="col-6 text-start">
                        <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.3s" src="/site/img/about-2.jpg" style="margin-top: 25%;">
                    </div>
                    <div class="col-6 text-end">
                        <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.5s" src="/site/img/about-3.jpg">
                    </div>
                    <div class="col-6 text-end">
                        <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.7s" src="/site/img/about-4.jpg">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h5 class="section-title ff-secondary text-start fw-normal" style="color: var(--primary);">Sobre Nós</h5>
                <h1 class="mb-4">Bem-Vindo ao <i class="fa fa-utensils me-2" style="color: var(--primary);"></i>KARAMBA</h1>
                <p class="mb-4">O Espaço Karamba oferece uma variedade de opções para atender às
                    suas necessidades de entrega de comida com conveniência e qualidade</p>
                <p class="mb-4">O Espaço Karamba oferece uma variedade de opções para atender às
                        suas necessidades de entrega de comida com conveniência e qualidade</p>
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center border-start border-5 border-secundary px-3">
                            <h1 class="flex-shrink-0 display-5 mb-0" data-toggle="counter-up">{{$companies}}</h1>
                            <div class="ps-4">
                                @if ($companies > 1)
                                <p class="mb-0">Restaurantes do</p>
                                @else
                                <p class="mb-0">Restaurante do</p>
                                @endif
                                <h6 class="text-uppercase mb-0">Espaço Karamba</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="btn  py-3 px-5 mt-2 text-light" style="background-color: var(--primary);" href="{{route('site.about')}}">Saber Mais</a>
            </div>
        </div>
    </div>
  </div>
  <!-- About End -->

  @livewire('site.make-book-component')
  @livewire('site.show-rating-component')
 
  
@endsection