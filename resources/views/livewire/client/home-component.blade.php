@section('title','Painel Cliente')
<div>
    <div class="welcome-page">
        <h3>SEJA BEM-VINDO AO KARAMBA</h3>
        <p>Data: {{date('d-m-Y')}} | Hora:{{date('H:m')}}</p>
    </div>
    <div class="col-md-12 d-flex justify-content-center algin-items-center flex-wrap ">
        <div class="col-md-8">
            @if (session('ID'))
                <div class="text-center">
                    <h4 class="text-center fw-bold text-muted">Senhor(a), {{App\Models\ClientLocal::find(session('ID'))->client ?? ''}}</h4>
                    <a wire:navigate href="{{route('client.orders')}}" class=" button-order mt-4 btn btn-md">CONTINUAR A PEDIR <i class="fa fa-arrow-right"></i></a>
                </div>
            @else
            <div class="card shadow rounded " id="card-welcome">
                <div class="card-header">
                    <h6 class="text-center text-uppercase">
                        <i class="fa-solid fa-clipboard-list"></i>
                        Adicione as Informações a baixo, para fazer seu pedido
                     
                    </h6>
                </div>
                <div class="card-body">
                    <form wire:submit='createSession' method="post">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="clientName">Seu nome <span class="fw-bold text-success">(Opcional)</span></label>
                                <input type="text" name="clientName" id="clientName" wire:model='clientName' class="form-control" placeholder="Inform seu nome">
                                @error('clientName')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="clientCount">Número de Pessoas <span class="text-danger">*</span></label>
                                <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" type="number" min='1' name="clientCount" id="clientCount" wire:model='clientCount' class="form-control" placeholder="Nº de Pessoas">
                                @error('clientName')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="tableNumber">Número da sua mesa<span class="text-danger">*</span></label>
                                <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" type="number" min='1' name="tableNumber" id="tableNumber" wire:model='tableNumber' class="form-control">
                                @error('tableNumber')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-6" wire:ignore>
                                <label for="orderCode">Restaurante<span class="text-danger">*</span></label>
                                <select wire:model='company' name="company" id="company" class="form-select select-companies">
                                    <option value="">--Selecionar Restaurante</option>
                                        @if (isset($companies) and $companies->count() > 0)
                                            @foreach ($companies as $company)
                                                <option value="{{$company->id}}">{{$company->companyname}}</option>
                                            @endforeach
                                        @endif
                                </select>
                                @error('company')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="w-100 btn btn-md btn-primary-welcome-client">FAZER PEDIDO <i class="fa fa-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
                
            @endif
        </div>
    </div>
</div>

@push('select-company')

  <script>
    $(document).ready(function() {
        $('.select-companies').select2({
          theme: "bootstrap-5",
          width:'100%',
        });
      
        $('.select-companies').change(function (e) { 
          e.preventDefault();
          @this.set('company', $('.select-companies').val());
        });
    });
    </script>



@endpush 
