@extends($layout)
@section('title','Profile')
@section('content')
{{-- breadcrumb start  --}}
<div class="col-xm-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
        <li class="breadcrumb-item"><a href="{{url('principal/sectionWiseStudent')}}">Classes</a></li>
        <li class="breadcrumb-item "><a href="{{URL::previous()}}">Section</a></li>
        <li class="breadcrumb-item "><a href="{{URL::previous()}}">Student</a></li>
        <li class="breadcrumb-item active"><a href="">{{$user->student_name}}</a></li>
      </ol>
    </nav>
  </div>
  {{-- breadcrumb end  --}}
<div class="row justify-content-center">
    <div class="col-xm-6 kk_profile text-center">
        @if ($user->image_path != null)
        <img class="kk_profile_img"  src="{{$user->image_path}}" alt="">
        @else
        <img class="kk_profile_img" src="{{asset('uploads/teachers/demo.jpg')}}" alt="">
        @endif
    <p class="profile_name">{{$user->student_name}}</p>
    <p class="profile_type">Student</p>
    <div class="profile_details text-left">
        <i class="fa fa-user"></i><p>{{$user->id}}</p>
        <i class="fa fa-envelope"></i><p>{{$user->email}}</p>
        <i class="fa fa-phone"></i><p>{{$user->phone_number}}</p>
    </div>
    <div class="pro_footer">
        <img src="{{asset('uploads/logo/eduate_logo.png')}}" alt="">
        <button class="btn btn-warning btn-full text-white mt-2 mb-2">Edit Profile</button>
    <a href="{{ url('changePassword')}}">Change Password?</a>
    </div>
    </div>
</div>
@endsection
