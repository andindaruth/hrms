@extends('layouts.app2')

@section('title', 'Add User | NASECO')
@section('page_title', 'New User')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href={{ route('admin.users.index') }}>
            <li class="breadcrumb-item btn btn-outline-success btn-sm ">Users</li>
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="card card-outline card-success">
                <div class="card-body">                    
                   
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" autocomplete="off" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Enter name" required>
                        @error('name')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" autocomplete="off" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" placeholder="Enter email" required>
                        @error('email')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">User Role *</label>
                        <select class="form-control select2" id="role" name="role" required>
                            <option value="">--Select User Role</option>
                            @if($user->role == 'Admin')
                            <option value="Admin">Admin</option>
                            <option value="Manager">Manager</option>
                            @endif
                            <option selected value="Store Keeper">Store Keeper</option>                           
                        </select>
                        @error('role')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">Password *</label>
                                <p class="text-sm">*password should be atleast 8 characters.</p>
                                <input type="password" autocomplete="off" class="form-control" id="password" name="password"
                                    value="" required>
                                @error('password')
                                    <div class="text-sm text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password_confirmation">Password Confirmation *</label>
                                <p class="text-sm">*Enter the password here again.</p>
                                <input type="password" autocomplete="off" class="form-control" id="password_confirmation"
                                    name="password_confirmation" value="" required>
                                @error('password_confirmation')
                                    <div class="text-sm text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>                    
                                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">Create User</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
