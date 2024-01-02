<div id="book">
  <div class="container-fluid py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
    <div class="row g-0">
        <div class="col-md-6">
            <div class="video">
                <button type="button" class="btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                    <span></span>
                </button>
            </div>
        </div>
        <div class="col-md-6 bg-dark d-flex align-items-center">
            <div class="p-5 wow fadeInUp" data-wow-delay="0.2s">
                <h5 class="section-title ff-secondary text-start text-light fw-normal">Reserva Mesa</h5>
                <h1 class="text-white mb-4">Marque já a sua Reserva</h1>
                <form wire:submit='save'>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input wire:model='name' type="text" class="form-control" id="name" placeholder="Nome">
                                <label for="name">Nome</label>
                                @error('name') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div wire:model='email' class="form-floating">
                                <input type="email" class="form-control" id="email" placeholder="Email">
                                <label for="email">Email</label>
                                @error('email') <span class="text-danger">{{$message}}</span> @enderror

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating date" id="date3" data-target-input="nearest">
                                <input wire:model='datetime' type="datetime-local" class="form-control datetimepicker-input" id="datetime" placeholder="Data e hora"  />
                                <label for="datetime">Date e Hora</label>
                                @error('datetime') <span class="text-danger">{{$message}}</span> @enderror

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="select1" wire:model='amountOfPeople'>
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="10">+ 3</option>
                                </select>
                                <label for="select1">Quantidade de pessoas</label>
                                @error('amountOfPeople') <span class="text-danger">{{$message}}</span> @enderror

                              </div>
                        </div>
                        <div class="col-md-6" wire:ignore>
                            <div class="form-floating">

                                  

                                <select  class="form-select selectcompany" style="height: 50% !important" id="select1" wire:model='companyid'>
                                  <option value="">--Selecionar--</option>
                                  @if ($companies->count() > 0)
                                      @foreach ($companies as $item)
                                        <option value="{{$item->id}}">{{$item->companyname}}</option>
                                      @endforeach
                                  @endif
                                </select>
                                <label for="select1">Restaurantes</label>
                                @error('companyid') <span class="text-danger">{{$message}}</span> @enderror

                              </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea wire:model='description' class="form-control" placeholder="Escreva aqui seu pedido" id="message" style="height: 100px"></textarea>
                                <label for="message">Informação Adicional</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn text-light w-100 py-3" type="submit" style="background-color: var(--primary);">Marcar Reserva</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ilustração do nosso restaurante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- 16:9 aspect ratio -->
                <div class="ratio ratio-16x9">
                    <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
                        allow="autoplay">
                        <video src="img/karamba (10).jpg" controls></video>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reservation Start -->




</div>
{{-- 
@push('search-company-reserve')
<script>
    $(document).ready(function() {
        $('.selectcompany').select2({
          theme: "bootstrap"
        });
      
        $('.selectcompany').change(function (e) { 
          e.preventDefault();
          @this.set('companyid', $('.selectcompany').val());
        });
    });
    </script>
@endpush --}}