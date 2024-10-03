@extends('layouts.app3')

@section('title', 'chemical Out Report ')
@section('page_title', 'chemical Out Report')

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
                <form action="{{ route('chemical-out.report') }}" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Name of Chemical</label>
                                        <div class="input-group ">
                                            <select class="form-control select2" id="chemical_id" name="chemical_id">
                                                <option value="">--All chemicals</option>
                                                @foreach ($chemicals as $chemical)
                                                    <option value="{{ $chemical->id }}">{{$chemical->code }} - {{ $chemical->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('chemical_id')
                                                <div class="text-sm text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Category of Chemical</label>
                                        <div class="input-group ">
                                            <select class="form-control select2" id="category" name="category">
                                                <option value="">--Select category</option>
                                                <option value="Seed treatment">Seed treatment (CF)</option>
                                                <option value="Farm">Farm (CC)</option>
                                            </select>
                                            @error('category')
                                                <div class="text-sm text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
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
                            <th>category </th>
                            <th>Taken By</th>
                            <th>Receipt No.</th>
                            <th>Destination</th>
                            <th>Issued By</th>
                            <th>Packs</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>Ha or Ton</th>                            
                        </tr> 
                    </thead>
                    <tbody>
                        @unless ($transactions->isEmpty())

                            @foreach ($transactions as $transaction)
                                @php
                                    $quantity = $transaction->no_of_packs * $transaction->chemical->quantity_per_pack;
                                    // $cost = $quantity * $transaction->chemical->unit_price;
                                    $ha_ton = $quantity / $transaction->chemical->rate;

                                @endphp
                                <tr class="text-nowrap">
                                    {{-- <td>{{ $transaction->id }}</td> --}}
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->chemical->code }} - {{ $transaction->chemical->name }}</td>
                                    <td>{{ $transaction->chemical->category}}</td>
                                    <td>{{ $transaction->person->name }}</td>
                                    <td>{{ $transaction->receipt_no }}</td>
                                    <td>{{ $transaction->destination }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>{{ $transaction->no_of_packs }}</td>
                                    <td><b>{{ number_format($quantity, 0, '.', ',') }}</b> {{ $transaction->chemical->unit_of_measure }}</td>
                              
                                    <td>{{ $transaction->chemical->rate }} @if ($transaction->chemical->category == 'Farm') {{ $transaction->chemical->unit_of_measure }}/Ha @else {{ $transaction->chemical->unit_of_measure }}/Ton @endif</td> 
                                    <td>{{ number_format($ha_ton , 2, '.', ',') }} @if ($transaction->chemical->category == 'Farm') Ha(s) @else Ton(s) @endif</td> 
                                   
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
