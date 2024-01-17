<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório atividades no sistema</title>
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
 

 @foreach ($companyName as  $company)
    <h3>Restaurante {{$company->companyname ?? ''}}</h3> 
 @endforeach
     

    <div class="container">
        <div class="title">
            <span style="font-weight: 500;">Relatório de Atividades Registadas no sistema</span>
        </div>
    </div>
    <hr style="margin: 4rem 0">

    <table border="1" style="border-collapse: collapse; width:100%; text-align:center">
        <thead>
            <tr>
                <th>Data</th>
                <th>Tipo de Acção</th>
                <th>Descricao</th>
                <th>Responsável</th>
            </tr>
        </thead>
        <tbody>
       
            @foreach ($data as $report)
                <tr>
                    <tr>
                        <td>{{Carbon\Carbon::parse($report->created_at)->format("d-m-Y")}}</td>
                        <td>{{$report->tipo_acao ?? ''}}</td>
                        <td>{{$report->descricao ?? ''}}</td>
                        <td>{{$report->responsavel ?? ''}}</td>
                    </tr>
                </tr>
            @endforeach
        </tbody>
    </table>
   
</body>
</html>