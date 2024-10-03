@extends('layouts.app2')

@section('title', 'New Driver | NASECO')
@section('page_title', 'New Driver')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href={{ route('drivers.index') }}>
            <li class="breadcrumb-item btn btn-outline-success btn-sm ">Driver</li>
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('drivers.store') }}">
            @csrf
            <div class="card card-outline card-success pl-5 pr-5">
                <div class="card-body">                    
                   
                    <div class="form-group">
                        <label for="name">Driver Name *</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Enter name" required>
                        @error('name')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="text" class="form-control" id="role" name="role" value="driver"
                            placeholder="Enter name" hidden>
                                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">Create Driver</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
