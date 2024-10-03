@extends('layouts.app5')

@section('title', 'packaging In Report ')
@section('page_title', 'packaging In Report')

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
                <form action="{{ route('packaging-in.report') }}" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name of packaging</label>
                                        <div class="input-group ">
                                            <select class="form-control select2" id="packaging_id" name="packaging_id">
                                                <option value="">--All packagings</option>
                                                @foreach ($packagings as $packaging)
                                                    <option value="{{ $packaging->id }}">{{ $packaging->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('packaging_id')
                                                <div class="text-sm text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Category of packaging</label>
                                        <div class="input-group ">
                                            <select class="form-control select2" id="category" name="category">
                                                <option value="">--All categories</option>
                                                <option value="roll">Rolls</option>
                                                <option value="bell">Bells</option>
                                            </select>
                                            @error('category')
                                                <div class="text-sm text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
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
                                <div class="col-md-2">
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
                                <div class="col-md-1">
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

            <div class="card-body table-responsive">
                <table id="example2" class="table table-hover table-head-fixed table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            {{-- <th>Id</th> --}}
                            <th>Date</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Vehicle</th>
                            <th>Delivery Note No.</th>
                            <th>Internal delivery No.</th>
                            <th>Received By</th>
                            <th>Packs</th>
                            <th>QTY</th>
                            <th>Unit cost</th>
                            <th>Trxn cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @unless ($transactions->isEmpty())

                            @foreach ($transactions as $transaction)
                                @php
                                    $cost = $transaction->total_quantity * $transaction->packaging->unit_price;

                                @endphp
                                <tr class="text-nowrap">
                                    {{-- <td>{{ $transaction->id }}</td> --}}
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->packaging->code }} - {{ $transaction->packaging->name }}</td>  
                                    <td>{{ $transaction->packaging->category }}</td>                                          
                                    <td>{{ $transaction->vehicle->number_plate }}</td>
                                    <td>{{ $transaction->delivery_note_no }}</td>
                                    <td>{{ $transaction->internal_delivery_no }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>{{ $transaction->no_of_packs }}</td>
                                    <td><b>{{ number_format($transaction->total_quantity, 1, '.', ',') }}</b> @if ($transaction->packaging->category == 'bell') psc @else Kgs @endif</td>
                                    <td>{{ number_format($transaction->packaging->unit_price,0, '.',',') }} 
                                    <td><b>{{ number_format($cost, 0, '.', ',') }}</b></td>
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
                            {{-- <td colspan="7" rowspan="1">Total packaging Balance is: <b><span class="count-up"
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
