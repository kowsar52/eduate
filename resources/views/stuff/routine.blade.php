@extends('stuff/layout')
@section('title','Routine')
@section('content')
<div class="container_fluid" style="box-shadow: -3px 5px 5px 5px #e8e8e8;margin:10px">
  {{-- breadcrumb start  --}}
  <div class="col-xm-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a  href="{{url('stuff/dashboard')}}">Home</a>
        <li class="breadcrumb-item active"><a href="">Routine</a></li>
      </ol>
    </nav>
  </div>
  {{-- breadcrumb end  --}}
  <div class="kk_tab ">
    <div class="row text-center" style="padding: 15px;">
      <div class="col-xm-6" style="background: #eaeaea;font-weight:700;width:50%">
        <a class="nav-link active_medium" href="javascript:void(0)" data-routine_type="Class Routine" id="BanglaLink">Class Routine</a>
      </div>
      <div class="col-xm-6" style="background: #eaeaea;font-weight:700;width:50%">
        <a class="nav-link" href="javascript:void(0)"  data-routine_type="Exam Routine" id="EnglishLink">Exam Routine</a>
      </div>
    </div>



  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>All Routines</h3>
    </div>
    <div class="col md-6 ">
      <!-- {{-- button trigar model  --}} -->
      <button class="btn btn-warning float-right"  data-toggle="modal" id="AddModalBtn">Add New</button>
    </div>
  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="routineTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">#</th>
          <th scope="col">Image</th>
          <th scope="col">Download</th>
          <th scope="col">Section</th>
          <th scope="col">Class</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
  <!-- {{--  modal start  --}} -->



 </div>

@endsection
@section('js')

<script>
  $("#BanglaLink").on('click',function(){
    $(this).addClass('active_medium');
    $('#EnglishLink').removeClass('active_medium');
    $('#EX_TYPE').addClass('d-none');

    getData();
  });
  $("#EnglishLink").on('click',function(){
    $(this).addClass('active_medium');
    $('#BanglaLink').removeClass('active_medium');
    $('#EX_TYPE').removeClass('d-none');
    getData();
    
  });

  $(document).ready(function () {
    getData();  
  });

function getData(){
  var routine_type = $('.active_medium').data('routine_type');
  
    var dt = $('#routineTable').DataTable({
        // basic
        destroy: true,
        processing: true,
        lengthChange: false,
        pageLength: 10,
        serverSide: true,
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'image' },
            { data: 'download' },
            { data: 'section' },
            { data: 'class' },
        ],        
        // ajax
        ajax: {
            url: "{{ url('stuff/routine/?routine_type=') }}"+routine_type,
            type: 'GET',
        }
    });
}






  </script>  
@endsection
