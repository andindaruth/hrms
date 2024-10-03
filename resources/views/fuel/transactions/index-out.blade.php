@extends('layouts.app')

@section('title', 'Fuel Out ')
@section('page_title', 'Fuel Out')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right">
        <a href="{{ route('fuel-out.create') }}" class="btn float-right bg-success"><i
            class="fa fa-plus"></i> New
        Fuel Out Transaction
    </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <div class="card card-success card-outline">
            <div class="card-header">                
                <h4 class="card-title text-success">Total Fuel Balance:  <b>{{ $fuelbal = number_format($balance, 1, '.', ',') }} Litres</b> in stock</h4>                
            </div>
           
            <div class="card-body table-responsive">
                <table id="example2" class="table table-hover table-head-fixed table-sm table-striped">
                    <thead>
                        <tr>                          
                            <th>Id</th>
                            <th>Date</th>
                            <th>Vehicle Number</th>                 
                            <th>Taken By</th> 
                            <th>Issued by</th> 
                            <th>Quantity (litres)</th> 
                            <th class="text-nowrap">Action/ Comment</th>                                               
                        </tr>
                    </thead>
                    <tbody>
                        @unless ($transactions->isEmpty())
                            @php
                                $cumulativeSum = 0;
                            @endphp
            
                            @foreach ($transactions as $transaction)
                                <tr class=" text-nowrap @if ($transaction->is_reversed or $transaction->reverses) text-muted @endif">
                                    <td class="">{{ $transaction->id }}</td>
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ strtoupper(substr($transaction->vehicle->category->name, 0, 1)) }}/{{ $transaction->vehicle->model }}/{{ $transaction->vehicle->number_plate }}</td>
                                    <td>{{ $transaction->person->name }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td><b>{{ number_format($transaction->quantity, 1, '.', ',') }}</b></td>
                                    <td>

                                        @if ($transaction->reverses)
                                        Reverses #{{ $transaction->reverses }}
                                        @elseif($transaction->is_reversed)
                                        Reversed by #{{ $transaction->reversed_by }} : {{ $transaction->reversal_reason }}                                           
                                        @else
                                            <button name="submit" type="submit" class="btn btn-sm btn-danger p-1"
                                                data-toggle="modal"
                                                data-target="#modal-lg-{{ $transaction->id }}">Reverse</button>
                                        @endif
                                    </td>

                                    <!-- Modal -->
                                <div class="modal fade" id="modal-lg-{{ $transaction->id }}">
                                    <div class="modal-dialog modal-lg">
                                            <form method="post" action="{{ route('fuel-out.reverse') }}">
                                       
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Transaction Reversal</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <p class="bg-danger"> Are you sure you want to reverse this
                                                            transaction ? <br>
                                                            Note that this action cannot be undone!</p>
                                                        <p>
                                                            <b>Transaction Date: </b> {{ $transaction->date }} <br>                                                           
                                                            <b>Fuel Quantity: </b>
                                                            {{ number_format($transaction->quantity, 1, '.', ',') }} Litres
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="reversal_reason">Reason for Reversal? *</label>
                                                            <textarea id="reversal_reason" name="reversal_reason" class="form-control" rows="2"
                                                                placeholder="Enter Reason for the transaction reversal" value="{{ old('reversal_reason') }}" required></textarea>
                                                            @error('reversal_reason')
                                                                <div class="text-sm text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="date">Transaction Date *</label>
                                                            <div class="input-group date" id="date-{{ $transaction->id }}"
                                                                data-target-input="nearest">
                                                                <div class="input-group-prepend"
                                                                    data-target="#reservationdate-{{ $transaction->id }}"
                                                                    data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i
                                                                            class="fa fa-calendar"></i></div>
                                                                </div>
                                                                <input id="date" name="date" type="text"
                                                                    class="form-control datetimepicker-input datepicker"
                                                                    data-target="#reservationdate-{{ $transaction->id }}"
                                                                    value="{{ $transaction->date }}" placeholder="YYYY-MM-DD" required>
                                                            </div>
                                                            <input type="text" name="transaction_id"
                                                                value="{{ $transaction->id }}" required hidden>                                                           
                                                            <input type="text" name="user_id"
                                                                value="{{ $user->id }}" required hidden>
                                                            @error('date')
                                                                <div class="text-sm text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer ">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Reverse
                                                    Transaction</button>
                                            </div>
                                        </div>
                                        </form>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                    
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
                </table>
            </div>
            
        </div>
        <div class="pb-3">
            {{ $transactions->links() }}
        </div>
    </div>

@endsection
