@section("title", "Histórico de actividades")

<div>
    {{-- Care about people's approval and you will be their prisoner. --}}    
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Histórico de actividades</h2>
                
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card">

        <div class="card-header">
            <div class="d-flex flex-wrap align-items-center ">
              <div class="form-group col-md-3">
                <label for="">Selecionar Empresa</label>
                <select wire:model.live="companyname" class="form-control" name="companyname" id="companyname">
                        <option  >--Selecionar--</option>
                        @if (isset($companyData) and count($companyData) > 0)
                        @foreach ($companyData as $data)
                            <option value="{{$data->id ?? ""}}">{{$data->companyname ?? ""}}</option>
                        @endforeach
                        @endif
                </select>
              </div>
                         

                

                 <div class="form-group col-md-3">
                    <label for="">Selecionar  responsável</label>
                    <select  wire:model.live="authorOfActivity" class="form-control" name="authorOfActivity" id="authorOfActivity">
                            <option selected value="">--Selecionar--</option>
                            <option value="Todos">Todos</option>
                            @foreach ($responsable as $user)
                              <option value="{{$user->name.' '.$user->lastname ?? ''}}">{{$user->name.' '.$user->lastname ?? ''}}</option> 
                            @endforeach
                    </select>

                </div> 

                <div class="form-group col-md-3">
                    <label for="">Data Inicial</label>
                    <input type="date" wire:model.live='startdate' name="startdate" id="startdate" class="form-control">
                </div>

                <div class="form-group col-md-3">
                    <label for="">Data Final</label>
                    <input type="date" wire:model.live='enddate' name="enddate" id="enddate" class="form-control">
                </div>

            </div>
        </div>

        <div class="card-body">
          
           <!-- Chart js -->           
           <div  id="chartjsContent" class="col-md-12 d-flex align-items-start flex-wrap my-5">
                  
                <h1>Gráfico de barras</h1>                
                    <canvas id="myChart"></canvas>
            </div> 
              
              
 
      <!-- Chart js -->           

            <!-- Tabela -->

                @if (count($historyOfActivities) > 0)

                <div class="col-md-12 d-flex justify-content-end align-items-center flex-wrap mt-1 mb-1">
                    <button wire:click='printHistoryOfAllActivities' class="btn btn-sm mx-1" style=" background-color: #222831e5;color:#fff;">
                        <i class="fa fa-file-pdf"></i>
                        EXPORTAR PDF
                    </button> 
                    <button class="btn btn-sm btn-success mx-1" title="Exportar Excel" wire:click='exportExcel'>
                      <i class="fas fa-file-excel"></i>
                      Exportar EXCEL
                    </button>

                </div>
                    <div id="table" class="table-responsive mt-4">
                        <table class="table table-hover table-striped">
                            <thead class="container">
                                <tr>
                                    <th>Tipo de acao</th>
                                    <th>Descricao</th>
                                    <th>Responsavel</th>
                                    <th>Data de actividade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historyOfActivities as $data)
                                    <tr>
                                        <td>{{$data->tipo_acao ?? ''}}</td>
                                        <td>{{$data->descricao ?? ''}}</td>
                                        <td>{{$data->responsavel ?? ''}}</td>
                                        <td>{{$data->created_at->format('d/m/Y') ?? ''}}</td>
                                    </tr>
                                @endforeach                                
                            </tbody>
                        </table>
        
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </div>    
                    
                  @endif
                  <!-- Tabela -->                   



           

                                    
          
         
              



            


        </div>

    </div>

    
</div>






@push('chart-log')

<script>
    const ctx = document.getElementById('myChart').getContext('2d');
  
    new Chart(ctx, {
      type: 'bar',
      animation:false,
      data: {
        labels: {!! json_encode($labels) !!},
        datasets: {!! json_encode($datasets) !!},              
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>


<!-- Gráfico de Pizza -->
<script>
    new Chart(document.getElementById('pie-chart'), {
      type: 'pie',
      data: {
         labels: [{!! $actionLabel !!}],
        datasets: [{
          backgroundColor: [
      'rgb(255, 99, 132)',
      'rgb(54, 162, 235)',
      'rgb(255, 205, 86)'
    ],
    
          data: [418, 263, 434, 586, 332]
        }],
      
      },
      options: {
        title: {
          display: true,
          text: 'Pie Chart for admin panel',
          responsive: true,
        },
        responsive: true
      }
    });
  </script>
    
@endpush

@push("show-type-report")
  <script src="{{asset('admin/vendor/jquery/jquery-3.3.1.min.js')}}"></script>
  <script>
    $(document).ready(function(){      

      $('#report_type').on('change', function() {
        if (this.value == "Tabela"){
         $(".barChart").addClass('d-none');
         $(this).off('load');
        }else if(this.value == 'Grafico'){
          $("#chartjs").show();

        }

      //alert(this.value );
});


    });     

  </script>
  
@endpush