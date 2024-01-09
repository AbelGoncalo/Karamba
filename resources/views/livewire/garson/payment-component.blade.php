@section('title','Realizar Pagamento')
<div style="margin-top:-5rem ">

    @if ($paymenttype == 'Transferência' || $paymenttype == 'TPA e Transferência' || $paymenttype == 'Numerário e Transferência')

        <div class="container mt-5">
            <div class="row col-md-12 d-flex justify-content-center align-items-center flex-wrap">
                <ul class="list-group list-group-flush col-md-8 rounded text-center">
                    @if (isset($bankAccounts) and $bankAccounts->count() > 0)
                        @foreach ($bankAccounts as $item)
                             <li style="margin-bottom: -1.4rem" class="list-group-item text-uppercase"><span class="fw-bold">BANCO:</span> <span class="text-muted">{{$item->bank}}</span> | <span class="fw-bold">IBAM:</span> <span class="text-muted">{{$item->ibam}}</span> | <span class="fw-bold">Nº CONTA:</span> <span class="text-muted">{{$item->number}}</span></li>
                        @endforeach
                    @else
                        <li class="list-group-item text-uppercase">NENHUMA COORDENADA BANCARIA DISPONÍVEL</li>
                    @endif
                  </ul>
            </div>
        </div>
        @endif

  
    @if (session('finallyOrder'))
    <div class="col-md-12 d-flex justify-content-center align-items-center flex-wrap mt-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>ENVAR FACTURA POR E-MAIL</h4>
                </div>
                <div class="card-body">
                    <form wire:submit='sendReceipt'>
                      
                        <div class="form-group">
                          <label for="">E-mail</label>
                          <input type="email" placeholder="Informe o email do Cliente" wire:model='email' class="form-control" type="mail">
                          @error('email') <span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="form-group mt-2">
                          <button type="submit" class="w-100 btn btn-md btn-primary-welcome-client">CONCLUIR</button>
                      </div>
                      </form>
                </div>
            </div>
        </div>
       </div>
    @else
 
    <div class="welcome-page" >

        <h4 class="fw-bold text-success">VALOR A PAGAR</h4>
        <h1 class="fw-bold text-success">{{number_format($total,2,',','.')}} Kz</h1>
        @php $formatter = new \NumberFormatter('PT_BR', NumberFormatter::SPELLOUT); @endphp
        <p class="text-uppercase fw-bold text-success">{{ $formatter->format($total);}} Kwanzas</p>
        
    </div>
    <div class="col-md-12 d-flex justify-content-center algin-items-center flex-wrap ">
        <div class="col-md-8">
            <div class="card shadow rounded " id="card-welcome">
                <div class="card-header text-center">
                        <h6 class=" text-uppercase">
                            <i class="fa-solid fa-money-bill"></i>
                            REGISTRAR PAGAMENTO
                        </h6>
                        <h6 class="text-uppercase">
                            <button  id="open_camera" data-bs-toggle="modal" data-bs-target="#modalCapturePicture" class="btn btn-sm btn-primary-welcome-client">
                                <i class="fa-solid fa-camera"></i>
                                CAPTURAR COMPROVATIVO
                            </button>
                            
                        </h6>
                   </div>
                <div class="card-body">
                    <form wire:submit='finallyPayment' method="post" class="container">
                        <div class="row">
                            <div class="form-group" wire:ignore>
                                <label for="table">Mesa<span class="text-danger">*</span></label>
                                <select  required wire:model.live='tableNumber'  name="table" id="table" class="form-select paymentselecttable">
                                    <option value="" select>
                                      --Selecionar Mesa--
                                    </option>
                                    @if (isset($allTables) and $allTables->count() > 0)
                                    @foreach ($allTables as $item)
                                        <option value="{{$item->table}}">{{$item->table}}</option>
                                    @endforeach
                                @endif
                                </select>
                                @error('table')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="clientName">Nome do Cliente <span class="text-success">(opcional)</span></span></label>
                                <input placeholder="Informe do nome do cliente" type="text" name="name" id="name" wire:model='name' class="form-control">
                                @error('name')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="clientName">Contribuente <span class="text-success">(opcional)</span></span></label>
                                <input placeholder="Informe o nif do cliente" type="text" name="nif" id="nif" wire:model='nif' class="form-control">
                                @error('nif')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="clientName">Endereço <span class="text-success">(opcional)</span></span></label>
                                <input placeholder="Informe o Endereço do Cliente" type="text" name="address" id="address" wire:model='address' class="form-control">
                                @error('address')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="clientName">Tipo de Pagamento <span class="text-danger">*</span></label>
                                <select wire:model.live='paymenttype' name="paymenttype" id="paymenttype" class="form-select">
                                    <option value="Transferência">Transferência</option>
                                    <option value="TPA">TPA</option>
                                    <option value="Numerário">Numerário</option>
                                    <option value="TPA e Transferência">TPA e Transferência</option>
                                    <option value="TPA e Numerário">TPA e Numerário</option>
                                    <option value="Numerário e Transferência">Numerário e Transferência</option>
                                </select>
                                @error('paymenttype')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            @if ($paymenttype == 'TPA e Transferência')
                                <div class="form-group col-md-6 mt-2">
                                    <label for="clientName">{{substr($paymenttype,0,3)}}<span class="text-danger">*</span></label>
                                <input type="number" wire:model="firstvalue" placeholder="0,00" name="" id="" class="form-control">
                                    @error('firstvalue')<span class="text-danger">{{$message}}</span>@enderror
                                </div>
                                <div class="form-group col-md-6 mt-2">
                                    <label for="secondvalue">{{substr($paymenttype,6)}}<span class="text-danger">*</span></label>
                                <input type="number" wire:model="secondvalue" placeholder="0,00" name="" id="" class="form-control">
                                    @error('secondvalue')<span class="text-danger">{{$message}}</span>@enderror
                                </div>
                            @endif
                            @if ($paymenttype == 'TPA e Numerário')
                                <div class="form-group col-md-6 mt-2">
                                    <label for="clientName">{{substr($paymenttype,0,3)}}<span class="text-danger">*</span></label>
                                <input type="number" wire:model="firstvalue" placeholder="0,00" name="" id="" class="form-control">
                                    @error('firstvalue')<span class="text-danger">{{$message}}</span>@enderror
                                </div>
                                <div class="form-group col-md-6 mt-2">
                                    <label for="secondvalue">{{substr($paymenttype,6)}}<span class="text-danger">*</span></label>
                                <input type="number" wire:model="secondvalue" placeholder="0,00" name="" id="" class="form-control">
                                    @error('secondvalue')<span class="text-danger">{{$message}}</span>@enderror
                                </div>
                            @endif
                            @if ($paymenttype == 'Numerário e Transferência')
                                <div class="form-group col-md-6 mt-2">
                                    <label for="clientName">{{substr($paymenttype,0,10)}}<span class="text-danger">*</span></label>
                                <input type="number" wire:model="firstvalue" placeholder="0,00" name="" id="" class="form-control">
                                    @error('firstvalue')<span class="text-danger">{{$message}}</span>@enderror
                                </div>
                                <div class="form-group col-md-6 mt-2">
                                    <label for="secondvalue">{{substr($paymenttype,12)}}<span class="text-danger">*</span></label>
                                <input type="number" wire:model="secondvalue" placeholder="0,00" name="" id="" class="form-control">
                                    @error('secondvalue')<span class="text-danger">{{$message}}</span>@enderror
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="clientName">Dividir Conta:<span class="text-danger">*</span></label>
                                <select wire:change="divisor" name="payallaccount" wire:model.live='payallaccount' id="payallaccount" class="form-select">
                                    <option selected value="Pagar Toda Conta">Pagar Toda Conta</option>
                                    <option value="Dividir-2">Dividir 2</option>
                                    <option value="Dividir-3">Dividir 3</option>
                                    <option value="Dividir-4">Dividir 4</option>
                                </select>
                                @error('payallaccount')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            @if ($payallaccount == 'Dividir-2' || $payallaccount == 'Dividir-3' || $payallaccount == 'Dividir-4')
                                <div class="form-group col-md-12 mt-2">
                                    <label for="clientName">Resultado<span class="text-danger">*</span></label>
                                <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" readonly type="txt" wire:model.live="divisorresult" placeholder="0,00" name="divisorresult" id="divisorresult" class="form-control">
                                    @error('divisorresult')<span class="text-danger">{{$message}}</span>@enderror
                                </div>
                             @endif
                            <div class="form-group mt-1">
                                <button type="submit" class="w-100 btn btn-md btn-primary-welcome-client">FINALIZAR <i class="fa fa-check"></i></button>
                            </div>
    
                        </div>
                    </form>
                </div>
            </div>
                
        </div>
    </div>
    @endif
 @include('livewire.garson.modals.send-receipt')
</div>



<script>
    document.addEventListener('reload',function(){
       window.location.reload();

    })
</script>




@push('select-garson')
<script>
     $(document).ready(function() {
        $('.paymentselecttable').select2({
          theme: "bootstrap-5",
          width:'100%',

        });
      
        $('.paymentselecttable').change(function (e) { 
          e.preventDefault();
          @this.getTotal();
          @this.set('tableNumber', $('.paymentselecttable').val());
        });
        });
</script>
@endpush

@push('capture-picture')
<script>
    let btn  = document.querySelector('#open_camera')
    let  video  =  document.querySelector('video');
    
    btn.addEventListener('click',function(){
        navigator.mediaDevices.getUserMedia({video:true,facingMode: "environment"})
        .then(stream =>{
            video.srcObject = stream;
            video.play()
        })
        .catch(error =>{
            console.log(error)
        })

    })


   capture =  document.querySelector('#capturePicture');



     capture.addEventListener('click',()=>{
        let canvas =  document.querySelector('canvas')
        canvas.style.display ='block';
        canvas.height = video.videoHeight
        canvas.width = video.videoWidth
       let context = canvas.getContext('2d');
       context.drawImage(video, 0, 0)
       console.log(canvas.toDataURL());

 
            let link =  document.querySelector('#download');
            link.href = canvas.toDataURL();
            link.classList.remove('d-none')
            video.style.display = 'none';
     })


     document.querySelector('.closecamera').addEventListener('click',()=>{
        let link =  document.querySelector('#download');
        let canvas =  document.querySelector('canvas');
        canvas.style.display ='none';
        link.classList.add('d-none')
        link.classList.remove('d-block')
        video.style.display = 'block';
        $('#modalCapturePicture').modal('hide')

     })

</script>  
@endpush
