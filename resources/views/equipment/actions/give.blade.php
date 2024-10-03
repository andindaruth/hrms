@extends('layouts.app6')

@section('title', ' Give | NASECO')
@section('page_title', 'Give out an Equipement')

@section('bread_crumb')
<ol class="breadcrumb float-sm-right">
        <a href="{{ route('equipment.actions') }}" class="btn float-right bg-success"> <i class="fas fa-tasks"></i> Actions
        </a>
    </ol>
@endsection


@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('equipment.give_out') }}">
            @csrf
            <div class="card card-outline card-success">
                <div class="card-body pl-5 pr-5">  
                    
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
                        <label for="person_id">Taken By *</label>
                        <select class="form-control select2" id="person_id" name="person_id" required>
                            <option value="">--Select person</option>
                            @foreach ($operators as $operator)
                                <option value="{{ $operator->id }}">{{ $operator->name }}</option>
                            @endforeach
                        </select>
                        @error('person_id')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>   
                    <div class="form-group">
                        <label for="quantity">Quantity taken *</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="{{ $equipment->quantity_in_stock }}" value="{{ old('quantity') }}" required>
                        @error('quantity')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="remarks">Job/Reason *</label>
                        <input type="text" class="form-control" id="remarks" name="remarks" value="{{ old('remarks') }}" required>
                        @error('remarks')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>                    
                    <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $user->id }}"
                        hidden>
                        <input type="text" class="form-control" id="equipment_id" name="equipment_id" value="{{ $equipment->id }}"
                        hidden>
                    <input type="text" class="form-control" id="type" name="type" value="give" hidden>
                </div>
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">Give Out</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

