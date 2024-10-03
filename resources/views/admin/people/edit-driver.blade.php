@extends('layouts.app2')

@section('title', 'Edit Driver | NASECO')
@section('page_title', 'Edit Driver')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href={{ route('drivers.index') }}>
            <li class="breadcrumb-item btn btn-outline-success btn-sm ">Drivers</li>
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('drivers.update', ['driver' => $driver]) }}">
            @csrf
            @method('PUT')
            <div class="card card-outline card-success">
                <div class="card-body pl-5 pr-5">                    
                   
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $driver->name }}"
                            placeholder="Enter name" required>
                        @error('name')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                           
                                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">update driver</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
