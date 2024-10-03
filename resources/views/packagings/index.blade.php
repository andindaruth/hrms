@extends('layouts.app5')

@section('title', 'Packaging ')
@section('page_title', 'Packaging')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right">
        <a href="{{ route('packagings.create') }}" class="btn float-right bg-success"><i class="fa fa-plus"></i> New Packaging
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <div class="card card-success card-outline">
            <div class="card-header">
            </div>
            <div class="card-body table-responsive">
                <table id="example2" class="table table-hover table-head-fixed table-sm table-striped">
                    <thead>
                        <tr>
                            
                            <th>Name</th>
                            <th>Code</th>
                            <th>Purpose</th>
                            <th>category</th>
                            <th>Rate</th>                           
                            <th>unit cost</th>
                            <th>Bal.Qty</th>
                            <th>Bal.Tons</th>
                            <th>Bal.cost</th>
                        </tr>
                    </thead>
                    <tbody>
                    @unless ($packagings->isEmpty())
                            @foreach ($packagings as $packaging)                          
                            @php
                           
                            $balance_cost =  $packaging->balance * $packaging->unit_price;
                            $balance_tons = ($packaging->balance * $packaging->rate) / 1000;

                            @endphp
                                <tr class="text-nowrap">
                                    <td><a href="{{ route('packagings.edit', ['packaging' => $packaging]) }}">{{ $packaging->name }}</a>
                                    </td>
                                    <td>{{ $packaging->code }}</td>
                                    <td>{{ $packaging->purpose }}</td>
                                    <td>{{ $packaging->category }}</td>
                                    <td>{{ $packaging->rate }} @if ($packaging->category === 'roll') kg/kglm @else kg/psc @endif</td>
                                    <td>{{ number_format($packaging->unit_price, 0, '.', ',') }}</td>
                                    {{-- <td>{{ number_format($packaging->balance, 0, '.', ',') }}</td> --}}
                                    <td>{{ number_format($packaging->balance, 0, '.', ',') }}</td>
                                    <td>{{ number_format($balance_tons, 2, '.', ',') }}</td>                          
                                    <td>{{ number_format($balance_cost, 0, '.', ',') }} </td>  

                                </tr>
                            @endforeach
                        @else
                            <tr class="border-gray-300">
                                <td colspan="10">
                                    <p class="text-center">No Packaging Found</p>
                                </td>
                            </tr>
                        @endunless
                    </tbody>
                </table>
            </div> <!-- /.card-body -->
        </div>
    </div>

@endsection
