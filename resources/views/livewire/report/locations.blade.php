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
            <span style="font-weight: 500;">Relatório de Locais de Entrega</span>
        </div>
    </div>
    <hr style="margin: 4rem 0">

    <table border="1" style="border-collapse: collapse; width:100%; text-align:center">
        <thead>
            <tr>
                <th>Local</th>
                <th>Preço</th>
            </tr>
        </thead>
        <tbody>
       
            @foreach ($data as $item)
                <tr>
                    <tr>
                        <td>{{$item->location}}</td>
                        <td>{{number_format($item->price,2,',','.')}} Kz</td>
                    </tr>
                </tr>
            @endforeach
        </tbody>
    </table>

   
</body>
</html>