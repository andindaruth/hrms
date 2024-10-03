@extends('layouts.app3')

@section('title', 'chemical Out')
@section('page_title', 'New chemical Out Transaction')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href={{ route('chemical-out.index') }}>
            <li class="breadcrumb-item btn btn-outline-success btn-sm ">Chemical Out Transactions</li>
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('chemical-out.store') }}">
            @csrf
            <div class="card card-outline card-success pl-5 pr-5">
                <div class="card-body">

                    <div class="form-group">
                        <label for="date">Transaction Date *</label>
                        <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                            <div class="input-group-prepend" data-target="#reservationdate1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input id="date" name="date" type="text" class="form-control datetimepicker-input"
                                data-target="#reservationdate1" value="{{ old('date') }}" placeholder="YYYY-MM-DD"
                                required>
                        </div>
                        @error('date')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="chemical_id">Chemical *</label>
                        <select class="form-control select2" id="chemical_id" name="chemical_id" required>
                            <option value="">--Select Chemical</option>
                            @foreach ($chemicals as $chemical)
                                <option value="{{ $chemical->id }}">
                                    {{ $chemical->code }} - {{ $chemical->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('chemical_id')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="person_id">Taken By *</label>
                        <select class="form-control select2" id="person_id" name="person_id" required>
                            <option value="">--Select Person</option>
                            @foreach ($operators as $operator)
                                <option value="{{ $operator->id }}">
                                    {{ $operator->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('person_id')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="destination">Destination *</label>
                        <select class="form-control select2" id="destination" name="destination" required>
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
                    <div class="form-group">
                        <label for="receipt_no">Receipt Number *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="receipt_no" name="receipt_no"
                                value="{{ old('receipt_no') }}" required>
                            @error('receipt_no')
                                <div class="text-sm text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_of_packs">Number of Packs *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="no_of_packs" name="no_of_packs"
                                value="{{ old('no_of_packs') }}" required>
                            @error('no_of_packs')
                                <div class="text-sm text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $user->id }}"
                        hidden>
                    <input type="text" class="form-control" id="type" name="type" value="Out" hidden>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">Save Transaction</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
