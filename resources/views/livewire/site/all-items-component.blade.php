<div class="container-fluid py-5">
  <div class="container mt-5" >
      <div class="text-center wow fadeInUp" data-wow-delay="0.1s" style="margin-top: 5rem !important">
          <h1 class="mb-5" style="margin-top: 3rem;">Menu - {{$company->companyname}}</h1>
      </div>
      <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
              <div class="row col-md-12 d-flex justify-content-center align-items-center flex-wrap">
                <div class="form-group col-md-6 mb-5" wire:ignore>
                  <select  name="category" id="selectcategory"  class="form-select">
                    @if ($categories->count() > 0)
                    <option value="">--Selecionar--</option>
                        @foreach ($categories as $item)
                           <option value="{{$item->id}}">{{$item->description}}</option>
                        @endforeach
                      @else
                          <option value="">A consulta não retornou nenhum resultado</option>
                      @endif
                    </select>
                </div>
              </div>
            </div>
          <div class="tab-content">
           
              <div id="tab-{{$item->category_id ?? ''}}" class="tab-pane fade show p-0 active">
                  <div class="row g-4">
                    @if ($items->count() > 0)
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
    $('#selectcategory').select2({
      theme: "bootstrap",
      width: '100%'
    });

    $('#selectcategory').change(function (e) { 
      e.preventDefault();
      @this.set('category', $('#selectcategory').val());
    });
});
</script>
@endpush
