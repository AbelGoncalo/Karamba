 
  <!-- Modal -->
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="notification" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="exampleModalLabel">NOTIFICAÇÕES</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
       
        <div class="modal-body">
            
            <div class="conteiner">
              <div class="row">
                <div class="table-responsive">
                  <table class="table-bordered table text-muted text-center">
                    <tbody>
                      @if (isset(Auth::user()->unreadNotifications) and count(Auth::user()->unreadNotifications) > 0)
                      @foreach (Auth::user()->unreadNotifications as $item)
                   
                        <tr>
                          <td class="fw-bold" style="width: 10%">{{$item->created_at->diffForHumans()}}</td>
                          <td class="fw-bold text-uppercase" style="width: 80%">{{$item->data['message']}}</td>
                          <td style="width: 10%">
                            <button data-id="{{$item->id}}" class="btn btn-sm btn-success fw-bold remove" title="Marcar como visto">
                              <i class="fa fa-eye"></i>
                           </button>
                          </td>
                        </tr>
                         
                      @endforeach
                      @else
                          <tr class="alert alert-secondary text-center fw-bold">
                            <td colspan="3">Nenhuma notificação disponível</td>
                          </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            
           
        </div>
      </div>
    </div>
    
  </div>
 


  
  