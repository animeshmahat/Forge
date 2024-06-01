@extends('layouts.app')

@section('title', 'Register')

@section('css')

@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card o-hidden border-0 shadow-lg my-3">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-4">
                            <div class="text-center">
                                <img src="{{$all_view['setting']->logo}}" alt="Logo" width="150" class="p-2">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" id="name" placeholder="Full Name" value="{{ old('name') }}" autofocus>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user  @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email Address" value="{{ old('email') }}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" id="examplePhone" placeholder="Phone Number">
                                            @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" id="username" placeholder="Username">
                                            @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user  @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password_confirmation" id="password" placeholder="Repeat Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="image">Profile Image:</label>
                                    <input type="file" class="form-control-file  @error('image') is-invalid @enderror" id="image" name="image" onchange="loadFile(event)" accept="image/png, image/gif, image/jpeg">
                                    <img id="output" class="mt-2" style="max-width: 250px; max-height: 200px;" />
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };
</script>
@endsection