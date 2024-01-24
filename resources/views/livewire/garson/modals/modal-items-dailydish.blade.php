 
  <!-- Modal -->
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="items-dailydish" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="exampleModalLabel">ITEMS DO PRATO DO DIA</h4>
          <button wire:click='clealAllFields' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <div class="container">
            <div class="row">
              <div class="col-md-8 mt-1">
                <div class="input-group">
                    <input type="searchOrder"    name="searchOrder" id="gsearchOrder" class="form-control" placeholder="Pesquisar Item">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                </div>
            </div> 
            <div class="col-md-4 mt-1">
                <div class="input-group" wire:ignore>
                  <select wire:model='tableNumber'  name="tableNumber" id="tableNumber" class="form-select text-uppercase selectTableg">
                    <option value="" select>
                      --Selecionar Mesa--
                    </option>
                    @if (isset($allTables) and $allTables->count() > 0)
                        @foreach ($allTables as $item)
                            <option value="{{$item->table}}">{{$item->table}}</option>
                        @endforeach
                    @endif
                  </select>
                </div>
            </div> 
            </div>
           </div>

           <!-- Inputs-->
           <div class="col-md-12 d-flex  align-items-start">
            <div class="container">
              <div class="row">
                <div class="col-md-6">
                  
                  <div class="form-group">
                    <label for="">Menu Prato do Dia</label>
                  <select wire:ignore wire:change="getItemsOfDailydishMenu"  wire:model.live='getItemsOfDailydishMenu'  wire:model="type_dailydishMenu" class="form-control" name="type_dailydishMenu" id="type_dailydishMenu">
                    <option value="">--Selecionar--</option>
                    @foreach ($typesMenuDailydishes as $item)
                      <option value="{{$item->id ?? ""}}">{{$item->description ?? ""}}</option>
                    @endforeach
                  </select>
                  </div>

                  <div class="form-group">
                    <label for="">Entrada</label>
                  <select  wire:model="client_entrance" class="form-control" name="client_entrance" id="client_entrance">
                    <option value="">--Selecionar--</option>
                    @if(isset($filteredMenuDailydish) and count($filteredMenuDailydish) > 0)
                      @foreach ($filteredMenuDailydish as $item)
                          @foreach ($item->entrance as $data)
                            <option value="{{$data ?? ""}}">{{$data  ?? ""}}</option>
                            @endforeach
                        @endforeach                                      
                      @endif

                  </select>
                  </div>

                  <div class="form-group">
                    <label for="">Bebida</label>
                  <select  wire:model="client_drink" class="form-control" name="client_drink" id="client_drink">
                    <option value="">--Selecionar--</option>
                    @if(isset($filteredMenuDailydish) and count($filteredMenuDailydish) > 0)
                      @foreach ($filteredMenuDailydish as $item)
                          @foreach ($item->drink as $data)
                            <option value="{{$data ?? ""}}">{{$data  ?? ""}}</option>
                            @endforeach
                        @endforeach  
                      @endif                                  
                  </select>
                  </div>

                

                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Prato principal</label>
                    <select wire:model="client_maindish" class="form-control" name="client_maindish" id="client_maindish">
                      <option value="">--Selecionar--</option>
                      @if(isset($filteredMenuDailydish) and count($filteredMenuDailydish) > 0)
                        @foreach ($filteredMenuDailydish as $item)
                            @foreach ($item->maindish as $data)
                              <option value="{{$data ?? ""}}">{{$data  ?? ""}}</option>
                              @endforeach
                          @endforeach
                      @endif
                          
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">Sobremesa</label>
                    <select  wire:model="client_dessert" class="form-control" name="client_dessert" id="client_dessert">
                      <option value="">--Selecionar--</option>
                      @if(isset($filteredMenuDailydish) and count($filteredMenuDailydish) > 0)
                      @foreach ($filteredMenuDailydish as $item)
                        @foreach ($item->dessert as $data)
                          <option value="{{$data ?? ""}}">{{$data  ?? ""}}</option>
                          @endforeach
                    @endforeach
                    @endif                                    

                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">Café</label>
                  <select wire:model='client_coffe' class="form-control" name="client_coffe" id="client_coffe">
                    <option value="">--Selecionar--</option>
                    @if(isset($filteredMenuDailydish) and count($filteredMenuDailydish) > 0)
                      @foreach ($filteredMenuDailydish as $item)
                          @foreach ($item->coffe as $data)
                            <option value="{{$data ?? ""}}">{{$data  ?? ""}}</option>
                            @endforeach
                        @endforeach
                      @endif
                          
                  </select>
                  </div>

                </div>

              </div>
            </div>
          </div>
          <!-- Inputs-->                   

          
              <div class="table-responsive mt-2">
                <table class="table table-lg table-striped table-hover text-center" id="table-items-g">
                  <thead>
                    <tr>
                      <th>ESTADO</th>
                      <th>ITEM</th>
                      <th>PREÇO</th>
                      <th>PEDIR</th>
                    </tr>
                  </thead>
                    <tbody id="tbody">
                        @if (isset($allItems) and count($allItems) > 0 )
                        @foreach ($allItems as $key=> $item)
                        <tr>
                          <td class="{{($item->status == 'DISPONIVEL')? 'text-success fw-bold':'text-danger fw-bold'}}">{{$item->status}}</td>
                            <td name="descriptionItem" wire:model="descriptionItem" value="{{$item->description}}" style="width: 30%">{{$item->description}}</td>
                            <td style="width:20% ">{{$item->price}} AOA</td>
                          
                            <!-- Opção para trazer a categoria do produto selecionado e assim ser util para a opçao do prato do dia-->
                            <td style="width: 30%" >
                              <button wire:click="makeOrder({{$item->id}})" class="btn btn-md" style="background-color: #0e0c28; color:#fff">
                                <i class="fa fa-clipboard-list"></i>
                                ANOTAR 
                              </button>
                            </td>
                        </tr>
                        @endforeach

                        @else
                        <tr>
                            <td colspan="5">
                                <div class="col-md-12 d-flex justify-content-center align-items-center flex-column" style="height: 25vh">
                                    <i class="fa fa-5x fa-caret-down text-muted"></i>
                                    <p class="text-muted">Nenhum Item Encontrado</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                      
                      </tbody>
                </table>
              </div>
            
        </div>
      </div>
    </div>
    
  </div>


 


  
  