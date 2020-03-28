@extends('stuff/layout')
@section('title','Dashboard')
@section('content')

{{-- breadcrumb start  --}}
<div class="col-xm-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a  href="{{url('stuff/dashboard')}}">Home</a>
      </ol>
    </nav>
  </div>
  {{-- breadcrumb end  --}}
  <div class="row kk_dash_menu">
      <div class="col-md-3">
        <a href="{{ url('stuff/dashboard')}}">
          <div class="kk_item" style="background-image: linear-gradient(to right,#e2d103,#f54a2e)">
              <i class="fa fa-home text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>Home</span>
            </div>
        </a>
    </div>
    
      <div class="col-md-3">
        <a href="{{ url('stuff/profile')}}">
          <div class="kk_item" style="background-image: linear-gradient(to right,#28a745,#e8e231);">
              <i class="fa fa-user text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>Profile</span>
            </div>
        </a>
    </div>
      <div class="col-md-3">
        <a href="{{ url('stuff/homeTask')}}">
          <div class="kk_item" style="background-image: linear-gradient(to right,#f31470,#9931e8)">
              <i class="fa fa-pen-nib text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>Home Task</span>
            </div>
        </a>
    </div>
      <div class="col-md-3">
        <a href="{{ url('stuff/myClasses')}}">
          <div class="kk_item" style="background-image: linear-gradient(to right,#8c3dbd,#2e52ff)">
              <i class="fa fa-snowflake text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>My Classes</span>
            </div>
        </a>
    </div>
      <div class="col-md-3">
        <a href="{{ url('stuff/notice')}}">
          <div class="kk_item" style="background-image: linear-gradient(to right,#ff722f,#b10fa4)">
              <i class="fa fa-sticky-not text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>Notice</span>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ url('stuff/attendence')}}">
          <div class="kk_item" style="background-image: linear-gradient(to right,#035ce2,#00ffe7)">
              <i class="fa fa-book-reader text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>Attendence</span>
            </div>
        </a>
    </div>
      <div class="col-md-3">
        <a href="{{ url('stuff/attendenceHistory')}}">
          <div class="kk_item" style="background-image: linear-gradient(to right,#28a745,#10f745)">
              <i class="fa fa-book text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>Attendence Hisotry</span>
            </div>
        </a>
    </div>
      <div class="col-md-3">
        <a href="{{ url('stuff/resultPublish')}}">
          <div class="kk_item" style="background-image: linear-gradient(to right,#8c03e2,#f52e8a);">
              <i class="fa fa-snowflake text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>Publish Result</span>
            </div>
        </a>
    </div>
      <div class="col-md-3">
        <a href="{{ url('stuff/viewResult')}}">
            <div class="kk_item" style="background-image: linear-gradient(to right,#28a745,#10f745)">
                <i class="fa fa-snowflake text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>View Result</span>
            </div>
        </a>
    </div>
      <div class="col-md-3">
        <a href="{{ url('stuff/attendenceHistory')}}">
            <div class="kk_item" style="background-image: linear-gradient(to right,#ff722f,#b10fa4)">
                <i class="fa fa-snowflake text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>Attendence History</span>
            </div>
        </a>
    </div>
      <div class="col-md-3">
        <a href="{{ url('stuff/routine')}}">
            <div class="kk_item" style="background-image: linear-gradient(to right,#28a745,#10f745)">
                <i class="fa fa-snowflake text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>Routine</span>
            </div>
        </a>
    </div>
      <div class="col-md-3">
        <a href="{{ url('stuff/contact')}}">
            <div class="kk_item" style="background-image: linear-gradient(to right,#0af9c2,#2eb5f5)">
                <i class="fa fa-phone text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>Contact</span>
            </div>
        </a>
    </div>
      <div class="col-md-3">
        <a href="{{ url('stuff/transaction')}}">
            <div class="kk_item" style="background-image: linear-gradient(to right,#1444f3,#2eb5f5)">
                <i class="fa fa-dollar-sign text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>Transaction</span>
            </div>
        </a>
    </div>
      <div class="col-md-3">
        <a href="{{ url('stuff/fontPage')}}">
            <div class="kk_item" style="background-image: linear-gradient(to right,#1444f3,#2eb5f5)">
                <i class="fa fa-home text-white text-center" style="font-size:40px;margin-top:5px"></i><br>
              <span>Front Page</span>
            </div>
        </a>
    </div>

  </div>
@endsection
