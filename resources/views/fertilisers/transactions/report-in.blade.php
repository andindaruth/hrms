@extends('layouts.app4')

@section('title', 'fertiliser In Report ')
@section('page_title', 'fertiliser In Report')

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
                <form action="{{ route('fertiliser-in.report') }}" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name of fertiliser</label>
                                        <div class="input-group ">
                                            <select class="form-control select2" id="fertiliser_id" name="fertiliser_id">
                                                <option value="">--All fertilisers</option>
                                                @foreach ($fertilisers as $fertiliser)
                                                    <option value="{{ $fertiliser->id }}">{{ $fertiliser->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('fertiliser_id')
                                                <div class="text-sm text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                               

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
                                        <label>Generate</label>
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
                            <th>Id</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Vehicle</th>
                            <th>Delivery Note No.</th>
                            <th>Internal delivery No.</th>
                            <th>Received By</th>
                            <th>Packs</th>
                            <th>Qty (Kgs)</th>
                            <th>Unit cost (ugx) </th>
                            <th>Trxn cost(UGX)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @unless ($transactions->isEmpty())

                            @foreach ($transactions as $transaction)
                                @php
                                    $quantity = $transaction->no_of_packs * $transaction->fertiliser->quantity_per_pack;
                                    $cost = $quantity * $transaction->fertiliser->unit_price;

                                @endphp
                                <tr class="text-nowrap">
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->fertiliser->name }}</td>
                                    <td>{{ $transaction->vehicle->number_plate }}</td>
                                    <td>{{ $transaction->delivery_note_no }}</td>
                                    <td>{{ $transaction->internal_delivery_no }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>{{ $transaction->no_of_packs }}</td>
                                    <td><b>{{ number_format($quantity, 0, '.', ',') }}</b></td>
                                    <td>{{number_format($transaction->fertiliser->unit_price, 0, '.', ',')}}
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
                            {{-- <td colspan="7" rowspan="1">Total fertiliser Balance is: <b><span class="count-up"
                                data-value="{{ $balance }}">0</span> Kgs</b> in stock</td> --}}

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
