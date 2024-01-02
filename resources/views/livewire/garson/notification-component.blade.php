    <div>
      <span class="nav-link nav-icon" style="cursor: pointer;color:#fff" data-bs-toggle='modal' data-bs-target="#notification">
          <i class="fas fa-bell"></i>
          <span class="badge rounded-pill badge-notification bg-danger">{{count(Auth::user()->unreadNotifications)}}</span>
        </span>
        @include('livewire.garson.modals.modal-notification')
      </div>

      <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

      <script>
        $(document).ready(function () {
            $('.remove').click(function (event) { 
              event.preventDefault();
              let id = $(event.currentTarget).data('id')
              @this.saw(id)
            });
        });
      </script>
 