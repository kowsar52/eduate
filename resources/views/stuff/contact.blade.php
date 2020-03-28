@extends('stuff/layout')
@section('title','Contact')
@section('content')
<div class="container_fluid" style="box-shadow: -3px 5px 5px 5px #e8e8e8;margin:10px">
  {{-- breadcrumb start  --}}
  <div class="col-xm-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a  href="{{url('stuff/dashboard')}}">Home</a>
        <li class="breadcrumb-item active"><a  href="#">Contact</a>
      </ol>
    </nav>
  </div>
  {{-- breadcrumb end  --}}
  <div class="kk_tab ">
    <div class="row text-center" style="padding: 15px;">
      <div class="col-xm-6" style="background: #eaeaea;font-weight:700;width:25%">
        <a class="nav-link active_medium" href="javascript:void(0)" data-type="teacher" id="TEACHER">Colleague</a>
      </div>
      <div class="col-xm-6" style="background: #eaeaea;font-weight:700;width:25%">
        <a class="nav-link" href="javascript:void(0)"  data-type="moderator" id="MODERATOR">Authority</a>
      </div>
      <div class="col-xm-6" style="background: #eaeaea;font-weight:700;width:25%">
        <a class="nav-link" href="javascript:void(0)"  data-type="student" id="STUDENT">Student</a>
      </div>
      <div class="col-xm-6" style="background: #eaeaea;font-weight:700;width:25%">
        <a class="nav-link" href="javascript:void(0)"  data-type="admin" id="ADMIN">Principal</a>
      </div>
    </div>




  <div class="table-responsive">
    <table class="table table-bordered" id="dataTable">
        <thead class="kk_thead">
          <tr>
            <th scope="col" style="width: 5px;font-weight:700">ID</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Class</th>
            <th scope="col">Subject</th>
            <th scope="col" style="">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
</div>

</div>
  <!-- {{--  modal start  --}} -->


 </div>

@endsection
@section('js')

<script>


  $("#TEACHER").on('click',function(){
    $(this).addClass('active_medium');
    $('#MODERATOR').removeClass('active_medium');
    $('#STUDENT').removeClass('active_medium');
    $('#ADMIN').removeClass('active_medium');
    var html =`<tr>
            <th scope="col" style="width: 5px;font-weight:700">ID</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Class</th>
            <th scope="col">Subject</th>
            <th scope="col" style="">Action</th>
          </tr>`;
    $('.kk_thead').html(html);
    getData(type = 'teacher');  
  });

  $("#MODERATOR").on('click',function(){
    $(this).addClass('active_medium');
    $('#TEACHER').removeClass('active_medium');
    $('#STUDENT').removeClass('active_medium');
    $('#ADMIN').removeClass('active_medium');
    var html =`<tr>
            <th scope="col" style="width: 5px;font-weight:700">ID</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Type</th>
            <th scope="col" style="">Action</th>
          </tr>`;
    $('.kk_thead').html(html);
    getData(type = 'moderator');  
  });

  $("#STUDENT").on('click',function(){
    $(this).addClass('active_medium');
    $('#TEACHER').removeClass('active_medium');
    $('#MODERATOR').removeClass('active_medium');
    $('#ADMIN').removeClass('active_medium');
    var html =`<tr>
            <th scope="col" style="width: 5px;font-weight:700">ID</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Roll</th>
            <th scope="col" style="">Action</th>
          </tr>`;
    $('.kk_thead').html(html);
    getData(type = 'student');  
  });

  $("#ADMIN").on('click',function(){
    $(this).addClass('active_medium');
    $('#TEACHER').removeClass('active_medium');
    $('#STUDENT').removeClass('active_medium');
    $('#MODERATOR').removeClass('active_medium');
    var html =`<tr>
            <th scope="col" style="width: 5px;font-weight:700">#</th>
            <th scope="col">Name</th>
            <th scope="col">Image</th>
            <th scope="col">Email</th>
            <th scope="col">User Type</th>
            <th scope="col" style="">Action</th>
          </tr>`;
    $('.kk_thead').html(html);
    getData(type = 'admin');  
  });

  $(document).ready(function () {
    getData(type = 'teacher');  
  });

function getData(type){
    var dt = $('#dataTable').DataTable({
        // basic
        destroy: true,
        processing: true,
        lengthChange: false,
        pageLength: 10,
        serverSide: true,
        searching: false,
        columns: [
            { data: 'id' },
            { data: 'image' },
            { data: 'name' },
            { data: 'assign_class' },
            { data: 'assign_subject' },
            { data: 'action' }
        ],
         
        // ajax
        ajax: {
            url: "{{ url('stuff/contactList') }}",
            type: 'POST',
            data: {
              type: type,
            }
        }
    });
}

  
  </script>  
@endsection
