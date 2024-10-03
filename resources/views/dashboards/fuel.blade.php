@extends('layouts.app')

@section('title', 'Fuel Dashboard | NASECO')
@section('page_title', 'Welcome to the Fuel Module')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right">
      <h4 class="card-title text-success">Total Fuel Balance: <b>{{  number_format($balance, 1, '.', ',') }} Litres</b> in stock</h4>        
    </ol>
@endsection

@section('main_content')



@endsection
