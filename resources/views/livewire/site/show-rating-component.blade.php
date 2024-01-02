

  <div class="container" >
    <div class="text-center">
        <h5 class="section-title ff-secondary text-center fw-normal" style="color: var(--primary);">Depoimento</h5>
        <h1 class="mb-5" >Nossos clientes dizem!!!</h1>
    </div>
  <div class="container">

    <div class="row">
      <div class="wrapper">
        <i id="left" class="fa fa-angle-left"></i>
        <ul class="carousel">
          @if (isset($ratings) and $ratings->count() > 0)
              @foreach ($ratings as $item)
              <li class="card">
                <div class="img"><img src="/rating.png" alt="img" draggable="false"></div>
                <h2>{{$item->company->companyname}}</h2>
                <span>
                  @if ($item->star_number == '1')
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    @elseif ($item->star_number == '2')
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    @elseif ($item->star_number == '3')
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    @elseif ($item->star_number == '4')
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    @elseif ($item->star_number == '5')
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    @endif

                </span>

                
                {{-- <button   data-id='{{$item->id}}' data-bs-toggle="modal" data-bs-target="#messages" class="btn btn-sm mt-5 btn-show-more" style="background-color: #0f172b;color:#fff">
                  Vêr Mais 
                </button> --}}
              </li>
              @endforeach
          @else
          <li class="card">
            <div class="img"><img src="/rating.png" alt="img" draggable="false"></div>
            <span>
              <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
            </span>
          </li>
          <li class="card">
            <div class="img"><img src="/rating.png" alt="img" draggable="false"></div>
            <span>
              <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
            </span>
          </li>
          <li class="card">
            <div class="img"><img src="/rating.png" alt="img" draggable="false"></div>
            <span>
              <span class="fa fa-star" style="color: #ffe400 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
                    <span class="fa fa-star" style="color: #222831e5 !important"></span>
            </span>
          </li>
          @endif
         
         
        </ul>
        <i id="right" class="fa fa-angle-right"></i>
      </div>
    </div>
  </div>
  @include('livewire.site.modals.show-message')
</div>

<script>
  document.addEventListener('reload',function(){
    setti
    location.reload(); 
  })
  
</script>

