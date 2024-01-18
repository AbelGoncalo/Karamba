<div class="container-fluid py-5"  >
  <div class="container mt-5" >

      <!-- Estilização do Menu -->
    

        


  <!-- =======   Menu Section   ======= -->
            <section id="menu" class="menu">
              <div class="container" data-aos="fade-up">

                <div class="section-header">
                  <p class="text-uppercase" style="font-size: 3vw">Menu {{$company->companyname}}</p>
                </div>

                
                <div  class="row col-md-12 d-flex justify-content-center align-items-center flex-wrap">
                  <ul data-aos="fade-up" data-aos-delay="200" class="list-group-flush list-group-horizontal position-relative overflow-auto w-75 col-md-12 d-flex justify-content-center align-items-center " style="border:none">
                    @foreach ($categories as $item)
                      <li  class="list-group-item p-2"  style="cursor: pointer;list-style: none; ">
                       <button class="btn btn-sm  category" style="border-bottom: 1px solid #ccc" data-id="{{$item->id}}">
                         {{$item->description}}
                      </button>
                      </li>
                    @endforeach
                  </ul>
                </div>

              
{{-- 
                <div class="tab-content" data-aos="fade-up" data-aos-delay="300">

                  <div class="tab-pane fade active show" id="menu-breakfast-{{$item->category_id ?? ''}}">

                    <div class="tab-header text-center">
                      <p>Menu</p>
                      <h3>Pequeno Almoço</h3>
                    </div>

                    <div class="row gy-5">
                      @foreach ($items as $item)
                      <div class="col-lg-4 menu-item">
                        <a href="assets/img/menu/menu-item-1.png" class="glightbox"><img src="{{($item->image != null) ? asset('storage/'.$item->image) : asset('not-found.png')}}" class="menu-img img-fluid" alt=""></a>
                        <h4><span >{{$item->description}}</span></h4>
                        <p class="ingredients">
                          Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                          {{number_format($item->price,2,',','.')}} Kz 
                        </p>
                      </div><!-- Menu Item -->
                      @endforeach

                    </div>
                  </div><!-- End Breakfast Menu Content -->

                  <div class="tab-pane fade" id="menu-lunch">

                    <div class="tab-header text-center">
                      <p>Menu</p>
                      <h3>Almoço</h3>
                    </div>

                    <div class="row gy-5">

                      <div class="col-lg-4 menu-item">
                        <a href="assets/img/menu/menu-item-1.png" class="glightbox"><img src="assets/img/menu/menu-item-1.png" class="menu-img img-fluid" alt=""></a>
                        <h4>Magnam Tiste</h4>
                        <p class="ingredients">
                          Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                          Kz 1.000 
                        </p>
                      </div><!-- Menu Item -->


                    </div>
                  </div><!-- End Lunch Menu Content -->

                  <div class="tab-pane fade" id="menu-dinner">

                    <div class="tab-header text-center">
                      <p>Menu</p>
                      <h3>Jantar</h3>
                    </div>

                    <div class="row gy-5">

                      <div class="col-lg-4 menu-item">
                        <a href="assets/img/menu/menu-item-1.png" class="glightbox"><img src="assets/img/menu/menu-item-1.png" class="menu-img img-fluid" alt=""></a>
                        <h4>Magnam Tiste</h4>
                        <p class="ingredients">
                          Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                          Kz 1.000 
                        </p>
                      </div><!-- Menu Item -->




                    </div>
                  </div><!-- End Dinner Menu Content -->

                </div> --}}

              </div>
            </section>
  <!-- ======= End Menu Section ======== -->

      <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
          

          <div class="tab-content">
           
              <div id="tab-{{$item->category_id ?? ''}}" class="tab-pane fade show p-0 active">
                  <div class="row g-4">
                    @if (count($items) > 0)
                    @foreach ($items as $item)
                            <div class="col-lg-12">
                              <div class="d-flex align-items-center">
                                  <img class="flex-shrink-0 img-fluid rounded" src="{{($item->image != null) ? asset('storage/'.$item->image) : asset('not-found.png')}}" alt="" style="width: 80px;">
                                  <div class="w-100 d-flex flex-column text-start ps-4">
                                      <h5 class="d-flex justify-content-between border-bottom pb-2">
                                          <span >{{$item->description}}</span>
                                          <span  style="color: #0f172b">{{number_format($item->price,2,',','.')}} Kz</span>
                                      </h5>
                                       <small class="fst-italic text-end">
                                        <button class="btn btn-sm "style="background-color: var(--primary);" wire:click='addToCart({{$item->id}})'><i class="text-light fa fa-cart-plus"></i></button>  
                                        <button class="btn btn-sm "style="background-color: var(--primary);" wire:click = 'getItemId({{$item->id}})' data-bs-toggle="modal" data-bs-target="#review-item-site"><i class="text-light fa fa-heart"></i></button>  
                                      </small> 
                                  </div>
                              </div>
                          </div>
                          @endforeach
                          @else
                          <div class="rounded d-flex justify-content-center align-items-center flex-column mt-2" style="height: 20rem;border:1px dashed #000">
                            <h5 class="text-muted text-size text-center text-uppercase text-muted">A consulta não retorno nenhum resultado</h5>
                        </div>
                          @endif
                      </div>
                  </div>
                    
                    
          </div>
      </div>
  </div>
  @include('livewire.site.modals.review-menu')
</div>
<script>
  document.addEventListener('close',function(){
     $("#review-item-site").modal('hide');
  })
  
</script>

@push('select2')
    
<script>
$(document).ready(function() {
    

    $('.category').click((e)=>{
      let id =  $(e.target).data('id')
      console.log(id);
      @this.set('category', id);
    })

  

    
});
</script>
@endpush
