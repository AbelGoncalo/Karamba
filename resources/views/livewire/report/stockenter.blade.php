<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório</title>
    <style>
        .container{
            width: 100%;
            margin-top: 3rem;

        }
        .title{
            width:100%;
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
            <span style="font-weight: 500;">Relatório de Entrada de Estoque</span>
        </div>
    </div>
    <hr style="margin: 4rem 0">

    <table border="1" style="border-collapse: collapse; width:100%; text-align:center">
        <thead>
            <tr>
                <th>Data</th>
                <th>Validade</th>
                <th>Item</th>
                <th>Un.</th>
                <th>Origem</th>
                <th>Fonte</th>
                <th>Custo</th>
                <th>Preço Ponderado</th>
                <th>Qtd.</th>
            </tr>
        </thead>
        <tbody>
       
            @foreach ($data as $item)
                <tr>
                    <tr>
                        <td>{{\Carbon\Carbon::parse($item->created_at)->format("d-m-Y")}}</td>
                        <td>{{\Carbon\Carbon::parse($item->expiratedate)->format("d-m-Y")}}</td>
                        <td>{{$item->product->description}}</td>
                        <td>{{$item->unit}}</td>
                        <td>{{$item->source_product }}</td>
                        <td>{{$item->source}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->unit_price}}</td>
                        <td>{{$item->quantity}}</td>
                    </tr>
                </tr>
            @endforeach
        </tbody>
    </table>
   
</body>
</html>