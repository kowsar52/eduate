@extends('principal/layout')
@section('title','All Students')
@section('content')
<div class="container_fluid">
{{-- breadcrumb start  --}}
<div class="col-xm-12">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
      <li class="breadcrumb-item active"><a href="">All Student</a></li>
    </ol>
  </nav>
</div>
{{-- breadcrumb end  --}}
  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>All Students</h3>
    </div>

  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="studentTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">#</th>
          <th scope="col">Image</th>
          <th scope="col">Student Name</th>
          <th scope="col">Email</th>
          <th scope="col">Phone Number</th>
          <th scope="col" style="">Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <!-- {{--  modal start  --}} -->



 </div>

@endsection
@section('js')

<script>
  $(function() {
        $('#studentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('principal/allStudents') }}",
        columns: [
                 { data: 'id', name: 'id' },
                 { data: 'image', name: 'image' },
                 { data: 'student_name', name: 'student_name' },
                 { data: 'email', name: 'email' },
                 { data: 'phone_number', name: 'phone_number' },
                 { data: 'action', name: 'action' },
              ]
     });
  });

//export csv data
$('body').on('click','#exportCSVBtn',function(){
  var section_id = $(this).data('section_id');
        swal({
          title: "Are you sure Export?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          })
          .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "",
                type: 'get',
                success: function(data){

                  $('#studentTable').DataTable().ajax.reload();
      
                }
            });
          } else {
              swal("Your Request Cancel!");
          }
          });
  });






  </script>  
@endsection
