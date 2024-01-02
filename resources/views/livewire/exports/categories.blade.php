<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório de Categorias</title>
   
</head>
<body>
 
    <table class="table table-striped" style="width: 100% !important">
      <thead>
        <tr>
          <td>Restaurante</td>
          <td>Descrição</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($categories as $item)
          <tr>
            <td>{{$item->companyname}}</td>
            <td>{{$item->description}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

 
</body>
</html>


