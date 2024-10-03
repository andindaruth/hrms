@extends('layouts.app2')

@section('title', 'Drivers ')
@section('page_title', 'Drivers')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right">
        <a href="{{ route('drivers.create') }}" class="btn float-right bg-success"><i
            class="fa fa-plus"></i> New
        Driver
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
                                             
                            <th>Name</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @unless ($drivers->isEmpty())
                            @foreach ($drivers as $driver)
                                <tr class="text-nowrap">
                                    <td><a
                                            href="{{ route('drivers.edit', ['driver' => $driver]) }}">{{ $driver->name }}</a>
                                    </td> 
                                                                       
                                </tr>
                            @endforeach
                        @else
                            <tr class="border-gray-300">
                                <td colspan="10">
                                    <p class="text-center">No drivers Found</p>
                                </td>
                            </tr>
                        @endunless
                    </tbody>
                </table>
            </div> <!-- /.card-body -->
        </div>
    </div>

@endsection
