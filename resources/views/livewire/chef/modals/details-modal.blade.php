<div wire:ignore.self data-bs-backdrop='static' class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-uppercase" id="exampleModalLabel">Detalhes de Encomenda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">
        
     
        
        <div class="table-responsive">
          <table class="table-striped table-hover table text-center fw-bold">
            <thead>
              <tr>
                <th>ITEMS ENCOMENDADOS</th>
              </tr>
            </thead>
            <tbody>
              @if (isset($details) and count($details) > 0)
                  @foreach ($details as $item)
                  <tr>
                    <td class="fw-bold ">{{$item->item}}</td>
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
  