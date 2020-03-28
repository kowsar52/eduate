@extends('stuff/layout')
@section('title','My Classes')
@section('content')
<div class="container_fluid">
{{-- breadcrumb start  --}}
<div class="col-xm-12">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a  href="{{url('stuff/dashboard')}}">Home</a>
      <li class="breadcrumb-item active"><a href="">My Classes</a></li>
    </ol>
  </nav>
</div>
{{-- breadcrumb end  --}}
  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>My Classes</h3>
    </div>

  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="dataTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">Day</th>
          <th scope="col">Class</th>
          <th scope="col">Section</th>
          <th scope="col">Subject</th>
          <th scope="col">Start Time</th>
          <th scope="col" style="">End Time</th>
          <th scope="col" style="">Duration</th>
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
        $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('stuff/getClass') }}",
        columns: [
                 { data: 'day', name: 'day' },
                 { data: 'class_name', name: 'class_name' },
                 { data: 'section_name', name: 'section_name' },
                 { data: 'subject_name', name: 'subject_name' },
                 { data: 'start_time', name: 'start_time' },
                 { data: 'end_time', name: 'end_time' },
                 { data: 'duration', name: 'duration' },
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

                  $('#dataTable').DataTable().ajax.reload();
      
                }
            });
          } else {
              swal("Your Request Cancel!");
          }
          });
  });






  </script>  
@endsection
