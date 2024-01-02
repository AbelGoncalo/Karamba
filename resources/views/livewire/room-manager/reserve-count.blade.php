<a  class="nav-link mx-2 {{(Route::Current()->getName() == 'panel.room.manager.reserves') ? 'active':''}} " aria-current="page" href="{{route('panel.room.manager.reserves')}}">Reservas
    <span class="badge badge-danger">{{($reserveCount == 99) ? $reserveCount .'+' : $reserveCount}}</span>
</a>

