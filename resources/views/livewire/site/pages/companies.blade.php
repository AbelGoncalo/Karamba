@extends('layouts.site.app')
@section('title','Sobre')

@section('content')

        <div class=" container-fluid pt-5 pb-3">
            <div class=" container">
               
                <div class="row g-4 mt-5" id="main-container">
                    <div class="input-group mb-3">
                        <input type="search" id="searchcompany" class="form-control" placeholder="Buscar Restaurante" aria-label="company" aria-describedby="basic-addon1">
                      </div>
                            <h5 class=" ff-secondary text-sm-center  text-md-start text-primary fw-normal mt-5 mb-5" style="color: var(--primary) !important">Restaurantes Karamba</h5>
                    </div>
                    @if ($companies->count() > 0)
                    @foreach ($companies as $item)
                    
                    <a href="{{route('site.company',['id'=>$item->id])}}" id="card-company">
                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-item text-center rounded overflow-hidden p-5">
                                <div class="rounded-circle overflow-hidden m-4">
                                    @if ($item->companylog != null)
                                        <img class="img-fluid" src="{{asset('/storage/log/'.$item->companylogo)}}" alt="{{$item->companyname}}">
                                    @else
                                        <i class="fa fa-utensils me-3 fa-4x" style="color: var(--primary);"></i>
                                    @endif
                                </div>
                                <h5 class="mb-0">{{$item->companyname}}</h5>
                            </div>
                        </div>
                    </a>
                    @endforeach
                    
                @endif
                </div>
            </div>
        </div>
      

@endsection

@push('search-company')
      
<script>
  $(document).ready(function(){  
    
   $('#searchcompany').keyup(function (e) { 
    e.preventDefault();
    let search = $('#searchcompany').val()
 
    $('#card-company').each(function(){  
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

                Swal.fire({
                title: "AVISO",
                text: "A consulta não retornou nenhum resultado...",
                icon: "warning",
                timer:2000,
                timerProgressBar: true,
                showConfirmButton: false,
                });


                //$('#searchcompany').val('')
                $(this).show(); 
            
         }  
    });  
   });
  
     
});
</script>
@endpush