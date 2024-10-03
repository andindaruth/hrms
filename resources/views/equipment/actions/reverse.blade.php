@extends('layouts.app6')

@section('title', 'Reverse | NASECO')
@section('page_title', 'Reverse')

@section('bread_crumb')
<ol class="breadcrumb float-sm-right">
        <a href="{{ route('equipment.actions') }}" class="btn float-right bg-success"> <i class="fas fa-tasks"></i> Actions
        </a>
    </ol>
@endsection

@section('main_content')
<div class="col-sm-12">
        <form method="post" action="{{ route('equipment.store') }}">
            @csrf
            <div class="card card-outline card-success pl-5 pr-5">
                <div class="card-body">

                <div class="form-group">
                        <label for="name">Are you sure you want to reverse? Enter reason*</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Enter name" required>
                        @error('name')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div> 

                    
    
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">save</button>
                    </div>
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection
