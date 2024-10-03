@extends('layouts.app2')

@section('title', 'Vehicles ')
@section('page_title', 'Vehicles')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right">
        <a href="{{ route('vehicles.create') }}" class="btn float-right bg-success"><i
            class="fa fa-plus"></i> New
        Vehicle
    </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <div class="card card-success card-outline">
           
            <div class="card-body table-responsive">
                <table id="example2" class="table table-hover table-head-fixed table-sm table-striped">
                    <thead>
                        <tr>                          
                                             
                            <th>Id</th>
                            <th>Vehicle Number</th>
                            <th>Category</th>
                            <th>Model</th>
                            <th>Number Plate</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @unless ($vehicles->isEmpty())
                            @foreach ($vehicles as $vehicle)
                                <tr class="text-nowrap">
                                    <td>{{ $vehicle->id }}</td>
                                    <td><a
                                            href="{{ route('vehicles.edit', ['vehicle' => $vehicle]) }}">{{ strtoupper(substr($vehicle->category->name, 0, 1)) }}/{{ $vehicle->model }}/{{ $vehicle->number_plate }}</a>
                                    </td> 
                                    <td>{{ $vehicle->category->name }}</td>
                                    <td>{{ $vehicle->model }}</td>
                                    <td>{{ $vehicle->number_plate }}</td>
                                                                       
                                </tr>
                            @endforeach
                        @else
                            <tr class="border-gray-300">
                                <td colspan="10">
                                    <p class="text-center">No vehicles Found</p>
                                </td>
                            </tr>
                        @endunless
                    </tbody>
                </table>
            </div> <!-- /.card-body -->
        </div>
    </div>

@endsection
