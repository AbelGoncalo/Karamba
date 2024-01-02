<a  class="nav-link mx-2 {{(Route::Current()->getName() == 'panel.room.manager.order') ? 'active':''}} " aria-current="page" href="{{route('panel.room.manager.order')}}">Pedidos <span class="badge badge-danger">{{($ordersPendingCount == 99) ? $ordersPendingCount .'+' : $ordersPendingCount}}</span></a>

