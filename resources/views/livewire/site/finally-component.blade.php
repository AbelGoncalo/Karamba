<div class="container">
   <div class="row col-md-12 d-flex justify-content-center align-items-center flex-wrap">
      <div class="col-md-5">
         <div class="input-group mb-3 mt-5 ">
            <input type="search" wire:model.live='search' value="{{session('finddetail')}}" class="form-control" placeholder="Pesquisar" aria-label="Pesquisar" aria-describedby="basic-addon1">
            <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
          </div>
      </div>
   </div>
   <div class="row col-md-12 d-flex justify-content-center align-items-center flex-wrap mt-5">
      <div class="col-md-10">
         @if (isset($orders) and $orders->count() > 0)
           @if ($status->status == 'PENDENTE')
               <h4>ESTADO: <span class="text-danger text-uppercase">{{$status->status ?? ''}}</span></h4>
        
               @else
               <h4>ESTADO: <span class="text-success text-uppercase">{{$status->status ?? ''}}</span></h4>
           @endif
         @endif
         @if (isset($orders) and $orders->count() > 0)
             
         <div class="table-responsive">
          <table class="table table-striped table-hover text-center">
             <thead>
                <tr>
                   <th>ITEM</th>
                   <th>QUANTIDADE</th>
                </tr>
             </thead>
             <tbody>
               @foreach ($orders as $item)
               <tr>
                  <td>{{$item->item ?? ''}}</td>
                  <td>{{$item->quantity ?? ''}}</td>
               </tr>
                   
               @endforeach
             </tbody>
          </table>
         </div>
         @else
            <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
               <i class="fa fa-5x fa-caret-down text-muted"></i>
               <p class="text-muted">Nenhuma encomenda encontrado</p>
            </div>
         @endif
      </div>
   </div>
</div>
<script>
   document.addEventListener('redirect',function(){
      setTimeout(() => {
         window.location.replace("/");
      }, 1000);
   })
   
</script>
