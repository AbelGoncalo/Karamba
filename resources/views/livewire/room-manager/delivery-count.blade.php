<a  class="nav-link mx-2 {{(Route::Current()->getName() == 'panel.room.manager.delivery') ? 'active':''}} " aria-current="page" href="{{route('panel.room.manager.delivery')}}">Encomendas   <span class="badge badge-danger">{{($deliveriesPendingCount == 99) ? $deliveriesPendingCount .'+' : $deliveriesPendingCount}}</span>
</a>
