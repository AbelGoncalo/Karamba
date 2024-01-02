<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório de Pedidos</title>
    <style>
        .container{
            width: 100%;
            margin-top: 3rem;

        }
        .title{
            width:30%;
            float: left;
        }
        .dates{
            width:70%;
            float: right;

        }

    </style>
</head>
<body>
 

 
<h3>{{$company->companyname}}</h3>
    <div class="container">
        <div class="title">
            <span style="font-weight: 500;">Relatório de Encomendas</span>
        </div>
    </div>
    <hr style="margin: 4rem 0">

    <table border="1" style="border-collapse: collapse; width:100%; text-align:center">
        <thead>
            <tr>
                <th>Data</th>
                <th>Cliente</th>
                <th>Forma de Pagamento</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
       
            @foreach ($data as $item)
                <tr>
                    <tr>
                        <td>{{Carbon\Carbon::parse($item->created_at)->format("d-m-Y")}}</td>
                        <td>{{$item->customername ?? ''}} {{$item->customerlastname ?? ''}}</td>
                        <td>{{$item->customerpaymenttype}}</td>
                        <td>{{number_format($item->total,2,',','.')}} Kz</td>
                    </tr>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top:5rem; width:100%; text-align:center">
       <p>Total: {{number_format($total,2,",",".")}} Kz</p>
       @php
            $word = new \NumberFormatter('pt-BR', \NumberFormatter::SPELLOUT);
      @endphp
   <p style="text-transform: uppercase">{{$word->format($total)}} kwanzas</p>
    </div>
</body>
</html>