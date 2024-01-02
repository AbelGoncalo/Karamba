@extends('layouts.site.app')
@section('title','Sobre')

@section('content')

 
@livewire('site.all-items-component',['companyid'=>$company->id])

@endsection