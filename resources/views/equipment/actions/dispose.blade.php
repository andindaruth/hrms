@extends('layouts.app6')

@section('title', 'Dispose Equipment')
@section('page_title', 'Dispose Equipment')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right">
        <a href="{{ route('equipment.actions') }}" class="btn float-right bg-success"> <i class="fas fa-tasks"></i> Actions</a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">Dispose Equipment</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('equipment.dispose.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="date">Date</label>
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
                        <label for="name">Equipment Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $equipment->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="quantity_in_stock">Quantity in Stock</label>
                        <input type="text" class="form-control" id="quantity_in_stock" name="quantity_in_stock" value="{{ $equipment->quantity_in_stock }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity to Dispose</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="{{ $equipment->quantity_in_stock }}" required>
                        @error('quantity')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason for disposal</label>
                        <input type="text" class="form-control" id="reason" name="remarks">
                    </div>

                    <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $user->id }}"
                    hidden>
                    <input type="text" class="form-control" id="equipment_id" name="equipment_id" value="{{ $equipment->id }}"
                    hidden>
                <input type="text" class="form-control" id="type" name="type" value="dispose" hidden>

                    <div class="card-footer">
                        <div class="card-tools text-right">
                            <button name="submit" type="submit" class="btn btn-danger">Dispose Equipment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
