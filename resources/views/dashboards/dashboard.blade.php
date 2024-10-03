@extends('layouts.app2')

@section('title', 'Main Dashboard | NASECO')
@section('page_title', 'Main Dashboard')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right">
        
    </ol>
@endsection

@section('main_content')

<div class="col-lg-6 col-12">
    <!-- small box -->
    <div class="small-box bg-light elevation-4">
      <div class="inner">
        <!-- <h3 class="text-success">150</h3> -->

        <p>Fuel and Lubricants</p>
      </div>
      <div class="icon">
      <i class="fas fa-gas-pump"></i>

      </div>
      <a href="{{ route('fuel-out.report-sum') }}" class="small-box-footer">Go to Fuel Module <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  
  <!-- ./col -->
  <div class="col-lg-6 col-12">
    <!-- small box -->
    <div class="small-box bg-light elevation-4">
      <div class="inner">
        <!-- <h3 class="text-success">150</h3> -->

        <p>chemicals</p>
      </div>
      <div class="icon">
      <i class="fas fa-flask"></i>

      </div>
      <a href="{{ route('chemicals.index') }}" class="small-box-footer">Go to dashboard <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-6 col-12">
    <!-- small box -->
    <div class="small-box bg-light elevation-4">
      <div class="inner">
        <!-- <h3 class="text-success">53</h3> -->

        <p>fertilizers</p>
      </div>
      <div class="icon">
      <i class="fas fa-seedling"></i>

      </div>
      <a href="{{ route('fertilisers.index') }}" class="small-box-footer">Go to dashboard <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <!-- ./col -->
  <div class="col-lg-6 col-12">
    <!-- small box -->
    <div class="small-box bg-light elevation-4">
      <div class="inner">
        <!-- <h3 class="text-success">53</h3> -->

        <p>Packaging</p>
      </div>
      <div class="icon">
      <i class="fas fa-box"></i>

      </div>
      <a href="{{ route('packagings.index') }}" class="small-box-footer">Go to dashboard <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <!-- ./col -->
  <div class="col-lg-6 col-12">
    <!-- small box -->
    <div class="small-box bg-light elevation-4">
      <div class="inner">
        <!-- <h3 class="text-success">53</h3> -->

        <p>Others</p>
      </div>
      <div class="icon">
      <i class="fas fa-leaf"></i>
      </div>
      <a href="#" class="small-box-footer">Go to dashboard <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-6 col-12">
    <!-- small box -->
    <div class="small-box bg-light elevation-4">
      <div class="inner">
        <!-- <h3 class="text-success">53</h3> -->

        <p>Workshop</p>
      </div>
      <div class="icon">
      <i class="fas fa-wrench"></i>

      </div>
      <a href="{{ route('equipment.actions') }}" class="small-box-footer">Go to dashboard <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <!-- ./col -->
    
@endsection
