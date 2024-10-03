@extends('layouts.app6')

@section('title', 'Repair | NASECO')
@section('page_title', 'Recommend for repair')

@section('bread_crumb')
<ol class="breadcrumb float-sm-right">
        <a href="{{ route('equipment.actions') }}" class="btn float-right bg-success"> <i class="fas fa-tasks"></i> Actions
        </a>
    </ol>
@endsection

@section('main_content')
<div class="col-sm-12">
        <form method="post" action="{{ route('equipment.recommend_store') }}">
            @csrf
            <div class="card card-outline card-success pl-5 pr-5">
                <div class="card-body">

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
                        <label for="quantity_in_stock">Quantity In Stock</label>
                        <input type="text" class="form-control" id="quantity_in_stock" name="quantity_in_stock" value="{{ $equipment->quantity_in_stock }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity to be repaired *</label>
                    <p class="text-sm">The quantity to Recommend for repair is strictly one (1)!</p>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1"
                             required readonly>                      
                        @error('quantity')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>   
                   
                    <div class="form-group">
                        <label for="remarks">Issues with the Equipement</label>                        
                        <input type="text" class="form-control" id="remarks" name="remarks" value="{{ old('remarks') }}" placeholder="Enter Issues with the equipment">
                        @error('remarks')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>    
                    <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $user->id }}"
                    hidden>
                    <input type="text" class="form-control" id="equipment_id" name="equipment_id" value="{{ $equipment->id }}"
                    hidden>
                <input type="text" class="form-control" id="type" name="type" value="recommend" hidden>
                <input type="text" class="form-control" id="status" name="status" value="pending_repair" hidden>
    
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">Recommend</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection
