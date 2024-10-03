@extends('layouts.app3')

@section('title', 'chemical In')
@section('page_title', 'New chemical In Transaction')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href={{ route('chemical-in.index') }}>
            <li class="breadcrumb-item btn btn-outline-success btn-sm ">Chemical In Transactions</li>
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('chemical-in.store') }}">
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
                        <label for="vehicle_id">Vehicle *</label>
                        <select class="form-control select2" id="vehicle_id" name="vehicle_id" required>
                            <option value="">--Select Vehicle</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">
                                    {{ $vehicle->number_plate }}
                                </option>
                            @endforeach
                        </select>
                        @error('vehicle_id')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="delivery_note_no">Delivery Note Number *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="delivery_note_no" name="delivery_note_no"
                                value="{{ old('delivery_note_no') }}" required>
                            @error('delivery_note_no')
                                <div class="text-sm text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="internal_delivery_no">Internal Delivery Number *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="internal_delivery_no" name="internal_delivery_no"
                                value="{{ old('internal_delivery_no') }}" required>
                            @error('internal_delivery_no')
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
                    <input type="text" class="form-control" id="type" name="type" value="In" hidden>
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
