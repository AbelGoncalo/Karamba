@extends('layouts.site.app')
@section('title','Carrinho')

@section('content')


<div class="container-fluid pt-5 pb-3">
    <div class="container-fluid">
        <div class="row g-4 mt-5">
            @livewire('site.cart-component',['companyid',session('companyid')])
        </div>
    </div>
</div>



@endsection