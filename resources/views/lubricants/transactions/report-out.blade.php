@extends('layouts.app')

@section('title', 'lub Out Report ')
@section('page_title', 'lub Out Report')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right">

    </ol>
@endsection

@section('main_content')
    <!-- filter -->
    <div class="col-sm-12">
        <div class="card card-success card-outline elevation-3">
            <!-- /.card-header -->
            <div class="card-body pb-0">
                <form action="{{ route('lub-out.report') }}" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Filter by Lubricant</label>
                                        <div class="input-group ">
                                            <select class="form-control select2" id="lub_id" name="lub_id">
                                                <option value="">--All Lubs</option>
                                                @foreach ($lubs as $lub)
                                                    <option value="{{ $lub->id }}">{{ $lub->type }}</option>
                                                @endforeach
                                            </select>
                                            @error('lub_id')
                                                <div class="text-sm text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Filter by Vehicle</label>
                                        <div class="input-group ">
                                            <select class="form-control select2" id="vehicle_id" name="vehicle_id">
                                                <option value="">--All Vehicles</option>
                                                @foreach ($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}">
                                                        {{ strtoupper(substr($vehicle->category->name, 0, 1)) }}/{{ $vehicle->model }}/{{ $vehicle->number_plate }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('vehicle_id')
                                                <div class="text-sm text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="from_date" class="form-control datetimepicker-input"
                                                data-target="#reservationdate" required="required" />
                                            <div class="input-group-append" data-target="#reservationdate"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>To:</label>
                                        <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                            <input type="text" name="to_date" class="form-control datetimepicker-input"
                                                data-target="#reservationdate1" />
                                            <div class="input-group-append" data-target="#reservationdate1"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>:</label>
                                        <input type="submit" class="btn bg-success form-control" value="Submit">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div><!-- /.card -->
    </div> <!-- filter -->

    <div class="col-sm-12">
        <div class="card card-success card-outline">
            <div class="card-header">               
                {{-- <h4 class="card-title text-success">Total lub Balance: <b>{{ $lubbal = number_format($balance, 1, '.', ',') }} Litres</b> in stock</h4> --}}

            </div>

            <div class="card-body table-responsive">
                <table id="example2" class="table table-hover table-head-fixed table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Vehicle Number</th>
                            <th>Taken By</th>
                            <th>Issued By</th>
                            <th>Quantity (litres)</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @unless ($transactions->isEmpty())
                            @php
                                $cumulativeSum = 0;
                            @endphp

                            @foreach ($transactions as $transaction)
                                <tr class="text-nowrap">
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->lub->type }}</td>
                                    <td>{{ strtoupper(substr($transaction->vehicle->category->name, 0, 1)) }}/{{ $transaction->vehicle->model }}/{{ $transaction->vehicle->number_plate }}
                                    </td>
                                    <td>{{ $transaction->person->name }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td><b>{{ number_format($transaction->quantity, 1, '.', ',') }}</b></td>

                                    <td><b>{{ number_format($cumulativeSum += $transaction->quantity, 1, '.', ',') }}</b></td>
                                </tr>                                
                            @endforeach
                            
                        @else
                            <tr class="border-gray-300">
                                <td colspan="10">
                                    <p class="text-center">No Transactions Found</p>
                                </td>
                            </tr>
                        @endunless
                    </tbody>
                    <tfoot>
                        <tr class="text-nowrap">
                            {{-- <td colspan="7" rowspan="1">Total lub Balance is: <b><span class="count-up"
                                data-value="{{ $balance }}">0</span> Litres</b> in stock</td> --}}
                           
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
        <div class="pb-3">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection
