 
  <!-- Modal -->
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="dailydish" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header ">
          <h4 class="modal-title fs-5 text-uppercase" id="exampleModalLabel">Prato do dia</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

          <div class="modal-body border-0 ">
            <div class="row">
              <div class="col-md-12 d-flex flex-wrap justify-content-center align-items-start">
                <div class="col-md-6 d-flex flex-column">
                  <img  src="{{asset('/default-food.png')}}" style="height: 14rem; width:100%; border-top-left-radius: 1%;border-top-right-radius: 1%"  alt="{{$item->description}}" class="img-fluid">
                  <div class="card-footer" style="background-color:#0e0c28; color:#fff">
                    <p class="text-center fw-bold text-uppercase" >{{$item->name ?? ""}}</p>
                </div>

                </div>
                <div class="col-md-6 px-3 d-flex flex-column text-uppercase my-2">
                  @if (isset($dailyDishes) && count($dailyDishes) > 0)
                    @foreach ($dailyDishes as $details)
                    <div>
                      <h3 class="fw-bold" style="color:#F5A92B" >{{$details->descriptionItem ?? ""}}</h3>
                    </div>

                    <div>
                      <h4 >Prato: {{$details->name ?? ""}}</h4>
                    </div>

                    <div>
                      <h4>Entrada: {{$details->entrance ?? ""}}</h4>
                    </div>

                    <div>
                      <h4>Prato principal: {{$details->maindish ?? ""}}</h4>
                    </div>

                    <div>
                      <h4>Sobremesa: {{$details->dessert ?? ""}}</h4>
                    </div>

                    <div>
                      <h4>Bebida: {{$details->drink ?? ""}}</h4>
                    </div>
                    
                    @endforeach
                  @endif

                </div>
              </div>
            </div>
          </div>

      </div>
    </div>
    
  </div>
 


  
  