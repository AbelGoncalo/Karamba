<div wire:ignore.self data-backdrop='static' class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-uppercase" id="exampleModalLabel">Detalhes de Encomenda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">
        
         <span>Endereço de Entrega : {{$item->customerprovince ?? 'N/D'}},{{$item->customerprovince ?? ''}},{{$item->customerstreet ?? ''}}</span> <br>
         <span>Outro Endereço de Entrega :{{$item->customerotheraddress ?? 'N/D'}}</span> <br>
         <span>Forma de Pagamento : {{$item->customerpaymenttype  ?? 'N/D'}}</span>
          
        
        <div class="table-responsive">
          <table class="table-striped table-hover table">
            <thead>
              <tr>
                <th>Item</th>
                <th>Preço</th>
                <th>Qtd.</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @if (isset($items) and count($items) > 0)
                  @foreach ($items as $item)
                  <tr>
                    <td>{{$item->item}}</td>
                    <td>{{number_format($item->price,2,',','.')}} Kz</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{number_format($item->price * $item->quantity,2,',','.')}} Kz</td>
                  </tr>
    
                  @endforeach
              @else
              <tr>
                <td colspan="4">
                    <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                        <i class="fa fa-5x fa-caret-down text-muted"></i>
                        <p class="text-muted">Nenhum Item Encontrado</p>
                    </div>
                </td>
            </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
  