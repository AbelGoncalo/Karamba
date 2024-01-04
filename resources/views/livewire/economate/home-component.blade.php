@section('title','Gestão de Economato')
<div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">PAINEL DE GESTÃO DE ESTOQUE</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="ecommerce-widget">

        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">
                            <i class="fa fa-tag"></i>
                            Produtos</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1">{{$products}}</h1>
                        </div>
                    </div>
                    <div id="sparkline-revenue"></div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">
                            <i class="fa fa-box"></i>
                            Categorias</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1">{{$categories}}</h1>
                        </div>
                    </div>
                    <div id="sparkline-revenue2"></div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">
                            <i class="fa fa-users"></i>
                            Entrada de Hoje</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1">{{$stockentertoday}}</h1>
                        </div>
                    </div>
                    <div id="sparkline-revenue3"></div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">
                            <i class="fas fa-clipboard-list"></i>
                            Saídas de Hoje</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1">1</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">
                        <i class="fa fa-chart-pie"></i>
                        Entradas de Estoque Mensal</h5>
                    <div class="card-body">
                        <canvas id="chartStockEnter"></canvas>
                    </div>
                </div>
            </div>
        </div>
     
    </div>
</div>




<script src="{{asset('/admin/libs/js/chart.min.js')}}"></script>

<script>
    const ctx = document.getElementById('chartStockEnter');
    var dv = JSON.parse('{!! json_encode($monthStockEnter ?? '')  !!}');
    var dh = JSON.parse('{!! json_encode($monthStockEnterCount ?? '')  !!}');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dv,
            datasets: [{
                label: 'Estatística Mensal',
                data: dh,
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

 




