@extends('layouts.app2')

@section('title', 'New Vehicle | NASECO')
@section('page_title', 'New Vehicle')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href={{ route('vehicles.index') }}>
            <li class="breadcrumb-item btn btn-outline-success btn-sm ">Vehicles</li>
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('vehicles.store') }}">
            @csrf
            <div class="card card-outline card-success pl-5 pr-5">
                <div class="card-body">   
                    
                    <div class="form-group">
                        <label for="category_id">Vehicle Category *</label>
                        <select class="form-control select2" id="category_id" name="category_id" required>
                            <option value="">--Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    <div class="form-group">
                        <label for="number_plate">Vehicle Number Plate *</label>
                        <input type="text" class="form-control" id="number_plate" name="number_plate" value="{{ old('number_plate') }}"
                            placeholder="Enter Number Plate" required>
                        @error('number_plate')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="model">Vehicle Model *</label>
                        <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}"
                            placeholder="Enter Model" required>
                        @error('model')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">Add Vehicle</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
