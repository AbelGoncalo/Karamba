@extends('layouts.site.app')
@section('title','Sobre')

@section('content')

 <!-- About Start -->
 <div class="container-fluid py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
           
            <div class="col-lg-12" style="margin-top: 8rem">
                <h5 class="section-title ff-secondary text-start fw-normal" style="color: var(--primary);">Sobre Nós</h5>
                <p class="mb-4">
                    O Espaço Karamba oferece uma variedade de opções para atender às
                    suas necessidades de entrega de comida com conveniência e qualidade
                    O Espaço Karamba oferece uma variedade de opções para atender às
                    suas necessidades de entrega de comida com conveniência e qualidade
                </p>
            </div>
            <div class="col-lg-12">
                <h5 class="section-title ff-secondary text-start fw-normal" style="color: var(--primary);">Restaurantes Karamba</h5>
               

                 <!-- Team Start -->
        <div class="container-xxl pt-5 pb-3">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                </div>
                <div class="row g-4">
                    @if ($companies->count() > 0)
                        @foreach ($companies as $item)
                            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="team-item text-center rounded overflow-hidden">
                                    <div class="rounded-circle overflow-hidden m-4">
                                        @if ($item->companylog != null)
                                            <img class="img-fluid" src="{{asset('/storage/log/'.$item->companylogo)}}" alt="{{$item->companyname}}">
                                        @else
                                            <i class="fa fa-utensils me-3 fa-4x" style="color: var(--primary);"></i>
                                        @endif
                                    </div>
                                    <h5 class="mb-0">{{$item->companyname}}</h5>
                                    <div class="d-flex justify-content-center mt-3">
                                        <a class="btn btn-square text-light mx-1" style="background-color: var(--primary);" href="{{route('site.companies')}}" title="Vêr Menu"><i class="fa fa-handshake"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                    @endif
                </div>
            </div>
        </div>
        <!-- Team End -->
            </div>
        </div>
    </div>
  </div>
  <!-- About End -->

@endsection