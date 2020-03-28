<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Eduate</title>

        {{-- css file include  --}}
    <link rel="stylesheet" href="{{ asset('BackendAssets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('BackendAssets/css/style.css')}}">

    {{-- include favicon  --}}
    <link rel="icon" href="{{ asset('/uploads/logo/favicon.png')}}" sizes="16x16" type="image/png">
    </head>
    <body>
        {{-- header section start  --}}
        <header>
            <div class="container_fluid bg-warning">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="logo">
                                <a href="{{ url('/')}}"><img src="{{ asset('uploads/logo/eduate_logo.png')}}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="menu">
                                <ul>
                                    <li><a href="{{ url('/about')}}">About Us</a></li>
                                    <li><a href="{{ url('/contact')}}">Support</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        {{-- header section end  --}}

        {{-- login form start --}}
        <div class="container main_content">
            <div class="row">
                <div class="col-md-4 ">
                    <div class="kk_login_form_right text-center">
                        <h1 class="font-weight-bold text-uppercase">Welcome To </h1>
                        <a href="{{ url('/')}}"><img src="{{ asset('uploads/logo/eduate_logo.png')}}" alt=""></a>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="kk_login_form">
                        <h1 class="text-center">Sign In </h1>
                        <p class="text-center">Sign In Your Account!</p>
                        <p class="text-center text-danger"><?php echo $errors->first(); ?></p>
                        <form action="{{ url('user/login/post')}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                {{-- <i class="fa fa-user icon"></i> --}}
                                <input type="text" class="form-control"  placeholder="User ID" name="username" value="{{ old('username') }}">
                              </div>
                            <div class="form-group">
                              {{-- <i class="fa fa-key icon"></i> --}}
                              <input class="form-control" type="password" placeholder="Password" name="password">
                            </div>
                            <div class="form-group">
                                {{-- <i class="fa fa-users icon"></i> --}}
                                <select name="user_type" id="" class="form-control" >
                                    <option value="">Chosse User Type..</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="principal">Principal</option>
                                    <option value="vice_principal">Vice-Principal</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="stuff">Stuff</option>
                                   
                                </select>
                            </div>
                            <div class="form-group">
                                <?php
                                    $schools = App\School::orderBy('school_id','desc')->get();  
                                
                                ?>
                                <select name="school_id" id="" class="form-control" >
                                    <option value="">Chosse Your School..</option>
                                    @foreach ($schools as $school)
                                <option value="{{$school->school_id}}">{{$school->school_name}}</option>  
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="defaultCheck1">
                                  Remember Me
                                </label>
                               
                            </div>
                              
                          
                            <button type="submit" class="btn btn-warning text-white font-weight-bold btn-full mt-2">Sign In</button>
                            <div class="form-group text-center mt-2">
                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                                {{-- <a href="#" style="text-align:center;color: var(--dark);">Forget Password?</a> --}}
                            </div>
                            
                          </form>
                    </div>
                </div>
            </div>
            
        </div>
        {{-- login form end --}}

        {{-- footer section start  --}}
        <footer>
            <div class="container_fluid ">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center text-dark">
                            <p style="padding: 10px;font-weight:700">Copyright © 2020 Eduate | Powered by HURU Technologies</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        {{-- footer section end  --}}

        {{-- include js file  --}}
        <script src="{{ asset('backendAssets/js/bootstrap.min.js')}}"></script>
    </body>
</html>
