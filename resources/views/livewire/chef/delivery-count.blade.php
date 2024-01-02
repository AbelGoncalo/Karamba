<a  class="nav-link mx-2 {{(Route::Current()->getName() == 'chefs.deliveries') ? 'active':''}}" href="{{route('chefs.deliveries')}}">
    Encomendas
   <span class="badge badge-danger">{{($deliveriesPendingCount == 99) ? $deliveriesPendingCount .'+' : $deliveriesPendingCount}}</span> 
</a>
