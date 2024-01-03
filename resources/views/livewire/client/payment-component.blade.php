@section('title','Realizar Pagamento')
<div>
    @if ($paymenttype == 'Transferência' || $paymenttype == 'TPA e Transferência' || $paymenttype == 'Numerário e Transferência')

    <div class="container mt-2">
        <div class="row col-md-12 d-flex justify-content-center align-items-center flex-wrap">
            <ul class="list-group list-group-flush col-md-8 rounded text-center">
                @if (isset($bankAccounts) and $bankAccounts->count() > 0)
                    @foreach ($bankAccounts as $item)
                    <li style="margin-bottom: -1.4rem" class="list-group-item text-uppercase"><span class="fw-bold">BANCO:</span> <span class="text-muted">{{$item->bank}}</span> | <span class="fw-bold">IBAM:</span> <span class="text-muted">{{$item->ibam}}</span> | <span class="fw-bold">Nº CONTA:</span> <span class="text-muted">{{$item->number}}</span></li>
                    @endforeach
                @else
                    <li class="list-group-item text-uppercase">NENHUMA COORDENADAS BANCARIAS DISPONÍVEIS</li>
                @endif
              </ul>
        </div>
    </div>
    @endif

  @if (session('finallyOrder'))
    <div class="col-md-12 d-flex justify-content-center align-items-center flex-wrap mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>SEU PAGAMENTO FOI RECEBIDO E ESTÁ A SER AVALIADO</h4>
                </div>
                <div class="card-body">
                    @if (isset($this->orderfinded['status']) and $this->orderfinded['status'] === 'pendente')
                    <div>
                    <button type="button" wire:click='verifyPaymentStatus({{$order_veriry}})' class="w-100 btn btn-md btn-primary-welcome-client">
                    <i class="fa fa-rotate"></i>
                    VERIFICAR</button>
                    </div>
                    @else
                    <p class="text-center fw-bold h5">SEU PAGAMENTO FOI VERIFICADO COM SUCESSO!!</p>
                    <p class="text-center fw-bold h5">INFORME SEU EMAIL, PARA RECEBER PO COMPROVATIVO DE PAGAMENTO</p>
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
                    {{ Session()->forget('ID')}}
                    @endif
                </div>
            </div>
        </div>
       </div>
    @else

        
    
    <div class="welcome-page">
        <h4 class="fw-bold text-success">VALOR A PAGAR</h4>
        <h1 class="fw-bold text-success">{{number_format($total,2,',','.')}} Kz</h1>
        @php $formatter = new \NumberFormatter('PT_BR', NumberFormatter::SPELLOUT); @endphp
        <p class="text-uppercase fw-bold text-success">{{ $formatter->format($total);}} Kwanzas</p>
        
    </div>
    <div class="col-md-12 d-flex justify-content-center algin-items-center flex-wrap ">
        <div class="col-md-8">
            <div class="card shadow rounded " id="card-welcome">
                <div class="card-header">
                    <h6 class="text-center text-uppercase">
                        <i class="fa-solid fa-money-bill"></i>
                        REALIZE SEU PAGAMENTO AQUI
                    </h6>
                </div>
                <div class="card-body">
                    <form wire:submit='finallyPayment' method="post" class="container">
                        <div class="row">
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
                            
                            @if ($paymenttype == 'Transferência' || $paymenttype == 'TPA e Transferência' || $paymenttype == 'Numerário e Transferência')
                            <div class="form-group">
                                <label for="file_receipt">Comprovativo de Pagamento:<span class="text-danger">*</span></label>
                                <input type="file"  wire:model='file_receipt' name="file_receipt" id="file_receipt" class="form-control">
                                @error('file_receipt')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            @endif

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
                            <div class="form-group mt-2">
                                <button  type="submit" class="w-100 btn btn-md btn-primary-welcome-client">FINALIZAR <i class="fa fa-check"></i></button>
                            </div>
    
                        </div>
                    </form>
                </div>
            </div>
                
        </div>
    </div>
    @endif
    {{-- @else
    <div class="rounded d-flex justify-content-center align-items-center flex-column mt-5" style="height: 20rem;border:1px dashed #000">
        <h5 class="text-muted text-size text-center text-uppercase text-muted">Ainda não fez nenhum pedido</h5>
        <p><a wire:navigate href="{{route('client.orders')}}" class=" button-order mt-4 mb-4 btn btn-md">COMEÇAR A PEDIR <i class="fa fa-arrow-right"></i></a></p>

    </div>
    @endif --}}
    @include('livewire.client.modals.send-receipt')
</div>

<script src="{{asset('/admin/vendor/jquery/jquery-3.3.1.min.js')}}"></script>

<script>

    document.addEventListener('open-modal',function(){
        $("#send-receipt").modal('show');
    
   
    })
   



</script>

