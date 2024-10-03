@extends('layouts.app')

@section('title', 'New lubricant | NASECO')
@section('page_title', 'New lubricant')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href={{ route('lubs.index') }}>
            <li class="breadcrumb-item btn btn-outline-success btn-sm ">lubricant</li>
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('lubs.store') }}">
            @csrf
            <div class="card card-outline card-success pl-5 pr-5">
                <div class="card-body">

                    <div class="form-group">
                        <label for="type">lubricant Type *</label>
                        <input type="text" class="form-control" id="type" name="type" value="{{ old('type') }}"
                            placeholder="Enter type" required>
                        @error('type')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>             
                                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">Create lubricant</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
