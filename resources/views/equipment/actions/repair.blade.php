@extends('layouts.app6')

@section('title', 'Repair | NASECO')
@section('page_title', 'Repair')

@section('bread_crumb')
<ol class="breadcrumb float-sm-right">
        <a href="{{ route('equipment.actions') }}" class="btn float-right bg-success"> <i class="fas fa-tasks"></i> Actions
        </a>
    </ol>
@endsection

@section('main_content')
<div class="col-sm-12">
        <form method="post" action="{{ route('equipment.store_repair' , ['action' => $action->id]) }}">
            @csrf
            <div class="card card-outline card-success pl-5 pr-5">
                <div class="card-body">

                    <div class="form-group">
                        <label for="name">Date Recommended</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $action->date }}"
                            placeholder="Enter name" readonly>
                        @error('name')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Equipment Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $action->equipment->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="user_id">Recommended By</label>
                        <input type="text" class="form-control" id="user_id" name="user_id"
                            value="{{ $action->user->name }}" readonly>
                        @error('user_id')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="remarks">Issues with Equipment</label>
                        <input type="text" class="form-control" id="remarks" name="remarks"
                            value="{{ $action->remarks }}" readonly>
                        @error('remarks')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity *</label>
                        <input type="text" class="form-control" id="quantity" name="quantity"
                            value="{{ $action->quantity }}" readonly>
                        @error('quantity')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>
                    <h3>Equipement Repair Details</h3>
                    <hr>
                    <div class="form-group">
                        <label for="date">Date Repaired*</label>
                        <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                            <div class="input-group-prepend" data-target="#reservationdate1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input id="date_r" name="date_r" type="text" class="form-control datetimepicker-input"
                                data-target="#reservationdate1" value="{{ old('date_r') }}" placeholder="YYYY-MM-DD"
                                required>
                        </div>
                        @error('date_r')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="person_id">Repaired By*</label>
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
                        <label for="comment">Actions taken *</label>
                        <input type="text" class="form-control" id="comment" name="comment" value="{{ old('comment') }}"
                             required>
                        @error('comment')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>   
                    <input type="text" class="form-control" id="action_id" name="action_id" value="{{ $action->id}}" hidden>
                    <input type="text" class="form-control" id="equipment_id" name="equipment_id" value="{{ $action->equipment_id}}" hidden>      
                    <input type="text" class="form-control" id="quantity_r" name="quantity_r" value="{{ $action->quantity}}" hidden>     
    
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection
