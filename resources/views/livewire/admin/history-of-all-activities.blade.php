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
            <div class="d-flex align-items-center ">
                <div class="form-group col-md-4">
                    <label for="">Selecionar forma de visualização</label>
                    <select wire:model.live="report_type" class="form-control" name="report_type" id="report_type">
                            <option selected  value="">--Selecionar--</option>
                            <option value="Tabela">Tabela</option>
                    </select>
                </div>

                {{-- <div class="form-group col-md-3">
                    <label for="">Selecionar tipo de acção</label>
                    <select  wire:model.live="type_service" class="form-control" name="type_service" id="type_service">
                            <option selected disabled value="">--Selecionar--</option>
                            <option value="Atribuir mesa">Atribuir mesa</option>
                            <option value="Editar mesa atribuída">Editar mesa atribuída</option>
                            <option value="Exportar relatório de pedidos">Exportar relatório de pedidos</option>
                    </select>

                </div> --}}

                <div class="form-group col-md-4">
                    <label for="">Data Final</label>
                    <input type="date" wire:model.live='startdate' name="startdate" id="startdate" class="form-control">
                </div>

                <div class="form-group col-md-4">
                    <label for="">Data Final</label>
                    <input type="date" wire:model.live='enddate' name="enddate" id="enddate" class="form-control">
                </div>

            </div>
        </div>

        <div class="card-body">
            


            <!-- Tabela -->

                @if ($this->report_type == 'Tabela')
                    <div class="table-responsive mt-4">
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

            <div class="col-md-12 d-flex align-items-start my-5">
                
                <div  class="col-md-7 ">
                    <h1>Gráfico de barras</h1>                
                        <canvas id="myChart"></canvas>
                  </div> 
                  
                  
                <div  class="col-md-4 " >
                    <h1>Gráfico de pizza</h1>
                    <canvas id="pie-chart" width="10px"></canvas>                
                        
                  </div>  

            </div>


        </div>

    </div>

    
</div>






@push('chart-log')

<script>
    const ctx = document.getElementById('myChart');
  
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
          label: '# of Votes',
          data: [12, 19, 3, 5, 2, 3],
          borderWidth: 1
        }]
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



<script>
    new Chart(document.getElementById('pie-chart'), {
      type: 'pie',
      data: {
        labels: ["HTML", "CSS", "JavaScript", "PHP", "MySql"],
        datasets: [{
          backgroundColor: ["#e63946", "#254BDD",
            "#ffbe0b", "#1d3557", "#326998"
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