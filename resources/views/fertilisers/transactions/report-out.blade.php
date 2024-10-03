@extends('layouts.app4')

@section('title', 'fertiliser Out Report ')
@section('page_title', 'fertiliser Out Report')

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
                <form action="{{ route('fertiliser-out.report') }}" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Name of Fertiliser</label>
                                        <div class="input-group ">
                                            <select class="form-control select2" id="fertiliser_id" name="fertiliser_id">
                                                <option value="">--All fertilisers</option>
                                                @foreach ($fertilisers as $fertiliser)
                                                    <option value="{{ $fertiliser->id }}">{{$fertiliser->code }} - {{ $fertiliser->name }}</option>
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
                                        <label>Destination</label>
                                        <div class="input-group ">
                                            <select class="form-control select2" id="destination" name="destination">
                                                <option value="">--Select Destination</option>
                                                <option value="Factory"> Factory</option>
                                                <option value="Parent Seed">Parent Seed</option>
                                                <option value="Out Grower">Out Grower</option>
                                                <option value="Research">Research</option>
                                                <option value="Others"> Others</option>
                                            </select>
                                            @error('destination')
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
                            <th>Person</th>
                            <th>Receipt No.</th>
                            <th>Destination</th>
                            <th>Issued By</th>
                            <th>Packs</th>
                            <th>Qty(Kg)</th>
                            
                            <th>Rate(kg/ha)</th>
                            <th>Ha</th>                            
                        </tr> 
                    </thead>
                    <tbody>
                        @unless ($transactions->isEmpty())

                            @foreach ($transactions as $transaction)
                                @php
                                    $quantity = $transaction->no_of_packs * $transaction->fertiliser->quantity_per_pack;
                                    // $cost = $quantity * $transaction->fertiliser->unit_price;
                                    $ha = $quantity / $transaction->fertiliser->rate;

                                @endphp
                                <tr class="text-nowrap">
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->fertiliser->code }} - {{ $transaction->fertiliser->name }}</td>        
                                    <td>{{ $transaction->person->name }}</td>
                                    <td>{{ $transaction->receipt_no }}</td>
                                    <td>{{ $transaction->destination }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>{{ $transaction->no_of_packs }}</td>
                                    <td><b>{{ number_format($quantity, 0, '.', ',') }}</b></td>
                                   
                                    <td>{{ $transaction->fertiliser->rate }}</td> 
                                    <td>{{ $ha }}</td> 
                                   
                                </tr>
                            @endforeach
                        @else
                            <tr class="border-gray-300">
                                <td colspan="11">
                                    <p class="text-center">No Transactions Found</p>
                                </td>
                            </tr>
                        @endunless
                    </tbody>
                    
                </table>
            </div>

        </div>
        <div class="pb-3">
            {{ $transactions->links() }}
        </div>
    </div>



@endsection
