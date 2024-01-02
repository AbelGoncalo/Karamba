<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fatura</title>
</head>

<style>
/* Cabecalho da fatura */

body{
        font-size: 12px;
    }
    header,.ticket_info,.sale_info{
        width: 22rem;
        height: auto;
        margin-top: -2.8rem;
        margin-left: -2.8rem;
    }
    #logo{
        width: 45;
        height: 45px;
        border-radius: 3px;
    }
    .img{

        width: 12rem;
        float: left;
        padding: 10px;

     }
    .company_name{
        width: 12rem;
        float: left;
     }
    .company_name p{
        font-size: 13px;
        margin-top: 1.5rem;
        margin-left: -3rem;
        font-weight: bolder;
     }

     .location_company{
        clear: both;
        margin-top: .2rem;
        padding: 4px;
     }
     /* Cabecalho da fatura */

     /* Informacoes da fatura */
     .ticket_info{
        margin-top: .1rem;
        padding: 1px;
     }
     .ticket_info p{
        margin-left: 5rem;
        font-weight: bolder;
     }
     .info{
        padding: .5px;
     }
     /* Informacoes da fatura */
     /* Informacoes de venda */
     .sale_info{
        margin-top: .1rem;
     }
     .sale_info .section_head {
        text-align: center;
     }
     .sale_info .section_head span{
       margin-left: .2px;
     }
     .section_head{
        background-color: #ccc;
     }
     .sale_info .product_info{
        text-align: center;
     }
     /* Informacoes de venda */

     /* Informacoes de pagamento */
     .payment_data{
        width: 22rem;
        height: auto;
        margin-left: -2.8rem;
        font-weight: bolder;
        padding: 2px;
     }

     .payment_data .title{
        width: 11rem;
        float: left;
        padding: 1px;
        margin-left: 1rem;
     }
     .payment_data .values{
         float: right;
         width: 11rem;
         margin-right: 1rem;
     }

     /* Informacoes de pagamento */

     /* Contas bancarias */
     .bank_accounts{
        width: 11rem;
        height: auto;
        margin-left: 4rem;
        text-align: center;
        font-size: 10px;

     }
     /* Contas bancarias */
     /* Nome do operador */
     .user{
         width: 11rem;
         height: auto;
         margin-left: -2rem;

     }
     .user p{
        text-align: left;
        font-weight: bolder;
     }
     /* Nome do operador */
     /* Informacoes do sofware */
     .info_software{
        text-align: center;
        margin-left: 1rem;
        font-weight: bolder;
        width: 8rem;
        height: auto;

    }
     .info_software p{
       font-size: 10px;
       text-align: center;


    }
    /* Informacoes do sofware */
</style>
<body>
    <header>
     
        <div class="img">
            <img src="{{($companie->companylogo != null)?
                 "storage/logo/".$companie->companylogo: "no-image.png"}}" id="logo">
        </div>
        <div class="company_name">
            <p>{{$companie->companyname}}</p>
        </div>

        <div class="location_company" style="margin-left: .5rem">
            <span> {{$companie->companyaddress ?? "N/D"}}</span><br>
            <span>Telf: {{$companie->companyphone ?? "N/D"}} {{($companie->companyalternativephone !=null) ? " / ".$companie->companyalternativephone  : ''}}</span><br>
            <span>Nif: {{$companie->companynif ?? "N/D"}}</span><br>
            <span>Email: {{$companie->companyemail ?? "N/D"}} </span><br>
            <span>WebSite: {{$companie->companywebsite ?? "N/D"}}</span>
        </div>
    </header>
    <span style="margin-left: -2.9rem;">{{str_repeat('............',10)}}</span>

    <section class="ticket_info">
        <p style="margin-left: 1rem">FACTURA Nº FR{{date('Y')}}/{{$order->id}}</p>
        <div class="info" style="margin-left: 1rem">
            <span>DATA: {{date('d-m-Y H:i:s')}}</span><br>
            <span>CLIENTE: CONSUMIDOR FINAL</span><br>
            <span style="font-weight: bolder; font-size: 12px">NIF: 999999</span>
        </div>
    </section>
    <span style="margin-left: -2.9rem;">{{str_repeat('............',10)}}</span>
    <section class="sale_info">
        <div class="section_head" style="margin-left: -1.5rem">
            <p>DESCRIÇÃO</p>
            <span>QTDADE</span> |
            <span>PREÇO</span>  |
            <span>TXA %</span>|
            <span>TOTAL</span>
        </div>

        <div class="product_info" style="margin-left: -1.5rem">
            @foreach ($orderdetails as $item)
                <p>{{$item->item}}</p>
                <span style="margin-left: .5rem">{{$item->quantity}}</span>
                <span style="margin-left: .5rem">{{number_format($item->price,2,",",".")}}</span>
                <span style="margin-left: .5rem">{{$item->tax}}%</span>
                <span style="margin-left: .5rem">{{number_format($item->price * $item->quantity ,2,",",".")}}</span>
            @endforeach

        </div>
    </section>


    <span style="margin-left: -2.9rem;">{{str_repeat('............',10)}}</span>
    <section class="payment_data">
    <div class="title">
        <span style="">SUBTOTAL</span><br>
        <span style="">IMPOSTO</span><br>
        <span style="">DESCONTO</span><br>
        <span style="">TOTAL GERAL</span>
    </div>
    <div class="values">
        <span style="margin-left: 2.8rem">{{number_format($order->total,2,",",".")}} KZ</span><br>
        <span style="margin-left: 3rem"> {{number_format($order->ta,2,",",".")}} KZ</span><br>
        <span style="margin-left: 3rem">{{number_format(0,2,",",".")}} KZ</span><br>
        <span style="margin-left: 2.8rem">{{number_format(Abs($order->total),2,",",".")}} KZ</span><br>
    </div>
    <p style="text-align: center; font-weight: bold; clear: both; width:10rem;margin-left: 55px">
        Bens / Serviços colocados a disposição do adquirente na data do
        documento.
    </p>
    </section>

    <section class="user">
        <p>Utilizador: {{auth()->user()->name}} {{auth()->user()->lastname}} </p>
    </section>
    <section class="info_software">
        <p style="margin-left: 2rem">Regime de {{$companie->companyregime}}</p>
        {{-- <p style="margin-left: 2rem">
            Processado por programa validado nº 00/AGT/2023
            Software SIF (1.0)
        </p> --}}
    </section>
</body>
</html>