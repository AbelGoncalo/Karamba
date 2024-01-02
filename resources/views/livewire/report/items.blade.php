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
            <span style="font-weight: 500;">Relatório de Produtos</span>
        </div>
    </div>
    <hr style="margin: 4rem 0">

    <table border="1" style="border-collapse: collapse; width:100%; text-align:center">
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Quantidade </th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
       
            @foreach ($data as $item)
                <tr>
                    <tr>
                        <td>{{$item->category->description}}</td>
                           <td>{{$item->description}}</td>
                           <td>{{number_format($item->price,2,',','.')}} Kz</td>
                           <td>{{$item->quantity}}</td>
                           <td>{{$item->status}}</td>
                           
                           
                    </tr>
                </tr>
            @endforeach
        </tbody>
    </table>

   
</body>
</html>