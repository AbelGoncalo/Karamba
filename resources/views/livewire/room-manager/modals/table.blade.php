<div wire:ignore.self data-backdrop='static' class="modal fade" id="transferMOdal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="form-group">
                        <label for="table">Mesas</label>
                        <select name="" wire:model='table' id="table" class="form-control">
                            <option value="">--Selecionar--</option>
                            @if (isset($allTables) and $allTables->count()  > 0)
                                @foreach ($allTables as $item)
                                    <option value="{{$item->number}}">{{$item->number}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <button  wire:click='trasnferirItems' class="w-100 btn btn-md" style=" background-color: #222831e5;color:#fff;" >
                            OK</button>

                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
    