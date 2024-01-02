@section('title','Fazer Pedidos')
<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5">
                <div class="input-group">
                    <input type="search" wire:model.live='searchCategories' name="searchCategories" id="searchCategories" class="form-control" placeholder="Pesquisar Categoria">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="row">
                @if (isset($allCategories) and $allCategories->count() > 0)
                    @foreach ($allCategories as $item)
                        
                    <div class="col-md-3 mt-3">
                        <div wire:click='getItems({{$item->id}})' class="card shadow rounded category-items" data-bs-toggle="modal" data-bs-target="#make-order">
                            @if ($item->description == 'Pratos')
                            <img  src="{{asset('/default-food.png')}}" style="height: 10rem; width:100%; border-top-left-radius: 1%;border-top-right-radius: 1%"  alt="{{$item->description}}" class="img-fluid">
                            @elseif($item->description == 'Bebidas')  
                            <img  src="{{asset('/default-drink.png')}}" style="height: 10rem; width:100%; border-top-left-radius: 1%;border-top-right-radius: 1%"  alt="{{$item->description}}" class="img-fluid">
                            @else
                            <img  src="{{($item->image != null)? asset('storage/categories/'.$item->image) : asset('not-found.png')}}" style="height: 10rem; width:100%; border-top-left-radius: 1%;border-top-right-radius: 1%"  alt="{{$item->description}}" class="img-fluid">
                            @endif
                            <div class="card-footer" style="background-color:#0e0c28; color:#fff">
                                <p class="text-center fw-bold text-uppercase" >{{$item->description}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                    <i class="fa fa-5x fa-caret-down text-muted"></i>
                    <p class="text-muted">Nenhum Pedido Encontrado</p>
                </div>
                @endif
            </div>
            </div>
        </div>
    </div>
    @include('livewire.client.modals.make-order')
</div>

@push('search-table')
      
<script>
  $(document).ready(function(){  
    
   $('#searchOrder').keyup(function (e) { 
    e.preventDefault();
    let search = $('#searchOrder').val()
 
    $('#table-items tr').each(function(){  
         var found = 'false';  
         $(this).each(function(){  
              if($(this).text().toLowerCase().indexOf(search.toLowerCase()) >= 0)  
              {  
                   found = 'true';  
              }  
         });  
         if(found == 'true')  
         {  
              $(this).show();  
         }  
         else  
         {  
            $(this).hide();
            // $("#tbody").html("<div class='col-md-12 d-flex justify-content-center align-items-center flex-column'>  <i class='fa fa-5x fa-caret-down text-muted'></i> <p class='text-muted'>Nenhum Item Encontrado</p> </div>");
         }  
    });  
   });
  
     
});
</script>
@endpush
