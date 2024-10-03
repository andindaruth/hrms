@extends('layouts.app1')

@section('title', 'Login | NASECO')

@section('main_content')

    <div class="login-logo">
        <a href="#" class="text-success"><b>NASECO </b>Store MS</a>
    </div>
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p class="text-sm"> {{ Session::get('error') }} </p>
        </div>
    @endif
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session </p>
            <form method="post" action="{{ route('loggedin') }}">
                @csrf
                
                
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="User name" id="email" name="email"
                    value="{{ old('email') }}" required>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                    @error('email')
                          <div class="text-sm text-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="" required>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>                    
                  </div>
                  <input type="checkbox" id="showPasswordCheckbox"> Show Password
                      @error('password')
                          <div class="text-sm text-danger">{{ $message }}</div>
                      @enderror
                      <br>

             {{-- <button type="submit" class="btn btn-success">Sign In</button> --}}
                <div class="row">
                    <div class="col-8">            
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                      <button type="submit" class="btn btn-success btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                  </div>
            </form>

         

        </div>


    </div>
    <!-- /.login-card-body -->
    </div>
    {{-- javascript --}}
    <script>
        const passwordInput = document.getElementById('password');
        const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');

        showPasswordCheckbox.addEventListener('change', function() {
            passwordInput.type = this.checked ? 'text' : 'password';
        });
    </script>

@endsection
