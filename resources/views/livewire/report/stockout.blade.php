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
 

 

    <div class="container">
        <div class="title">
            <span style="font-weight: 500;">Relatório de Saída de Estoque</span>
        </div>
    </div>
    <hr style="margin: 4rem 0">

    <table border="1" style="border-collapse: collapse; width:100%; text-align:center">
        <thead>
            <tr>
                <th>Data</th>
                <th>Item</th>
                <th>Qtd.</th>
                <th>Uso</th>
                <th>Uni.</th>
                <th>Responsável</th>
                <th>Origem</th>
                <th>Destino</th>
            </tr>
        </thead>
        <tbody>
       
            @foreach ($data as $item)
                <tr>
                    <tr>
                        <td>{{\Carbon\Carbon::parse($item->created_at)->format("d-m-Y")}}</td>
                        <td>{{$item->product_economate->description}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->usetype }}</td>
                        <td>{{$item->unit}}</td>
                        <td>{{$item->chef}}</td>
                        <td>{{$item->from}}</td>
                        <td>{{$item->to}}</td>
                    </tr>
                </tr>
            @endforeach
        </tbody>
    </table>
   
</body>
</html>