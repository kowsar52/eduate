@extends('principal/layout')
@section('title','Students')
@section('content')
<div class="container_fluid">
{{-- breadcrumb start  --}}
<div class="col-xm-12">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
      <li class="breadcrumb-item"><a href="{{url('principal/sectionWiseStudent')}}">Classes</a></li>
      <li class="breadcrumb-item "><a href="{{URL::previous()}}">Section</a></li>
      <li class="breadcrumb-item active"><a href="">Student</a></li>
    </ol>
  </nav>
</div>
{{-- breadcrumb end  --}}
  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>Students</h3>
    </div>
    <div class="col md-6 ">
      <!-- {{-- button trigar model  --}} -->
    <a href="{{ url('principal/exportStudent/'.$_GET['section_id'])}}" class="btn btn-primary float-right ml-2" data-section_id="{{$section_id}}"  id="">Export CSV</a>
      <button class="btn btn-success float-right ml-2"  data-toggle="modal" id="uploadCSVBtn">Import CSV</button>
      <button class="btn btn-warning float-right"  data-toggle="modal" id="AddModalBtn">Add New</button>
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

<!-- add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="mb-3" id="submitForm">
          <div class="form-group">
            <label for="exampleInputEmail1">Student ID</label>
            <input type="text" class="form-control" name="id"  placeholder="Enter Student ID">
            <span class="form-text text-danger error_msg id"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Student Name</label>
            <input type="text" class="form-control" name="student_name"  placeholder="Enter Student Name">
            <input type="hidden" class="form-control" name="section_id" value="{{$section_id}}">
            <input type="hidden" class="form-control" name="old_id" value="">
            <input type="hidden" class="form-control" name="action" >
            <span class="form-text text-danger error_msg student_name"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control" name="email" placeholder="enter email">
            <span class="form-text text-danger error_msg email"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Phone Number</label>
            <input type="number" class="form-control" name="phone_number" placeholder="enter phone number">
            <span class="form-text text-danger error_msg phone_number"></span>
          </div>
          <button type="submit" class="btn btn-warning btn-full text-white" id="submitBtn">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
  <!-- {{--  modal end  --}} -->
<!-- csv Modal -->
<div class="modal fade" id="csvModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Students</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="csv_declaimer text-success">
          <p>Students Csv File's Header Name and Order must be as bellow.</p>
          <ol>
            <li>ID</li>
            <li>Name</li>
            <li>Email</li>
            <li>Phone Number</li>
          </ol>
        </div>
        <div class="csv_file_form">
          <form id="csvForm">
            <div class="form-group">
              <label for="exampleInputEmail1">Upload File <span class="text-danger">(CSV)</span></label>
              <input type="file" class="form-control" name="files" >
              <input type="hidden" class="form-control" name="type" value="csv">
              <input type="hidden" class="form-control" name="section_id" value="{{$section_id}}">
              <span class="form-text text-danger files"></span>
            </div>
            <button type="submit" class="btn btn-warning btn-full text-white" id="submitCsvBtn">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <!-- {{--  modal end  --}} -->


 </div>

@endsection
@section('js')

<script>
  $(function() {
        $('#studentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('principal/getStudents?section_id='.$section_id) }}",
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
  //csv pop up
  $('body').on('click','#uploadCSVBtn',function(){
    $('#csvModal').modal('show');
  });
  //upload csv file
  $('#csvForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitCsvBtn').html('Saving..');

      $.ajax({
          url: "{{ url('principal/addStudent')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){
            if(data.error){
              $.each(data.error, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
              $('#submitCsvBtn').html('Save');
            }else{
              $('#submitCsvBtn').html('Save');
              swal("Good job!", data.success, "success");
              $('#csvModal').modal('hide');
              $("#csvForm")[0].reset();
              $('#studentTable').DataTable().ajax.reload();
            }

          },
          error: function (data) {

              $.each(data.responseJSON.errors, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
              $('#submitCsvBtn').html('Save');
          }
      });
  });

  //add button
  $('body').on('click','#AddModalBtn',function(){
    $('input[name=action]').val('create');
    $("#submitForm")[0].reset();
    $(".error_msg").text('');
    $('#addModal').modal('show');
  });

  // edit data
  $('body').on('click','.editBtn',function(){
      var id = $(this).data('id');
      $('input[name=old_id]').val(id);
      $('input[name=action]').val('edit');
      $.ajax({
          url: "{{ url('principal/student/getEditData')}}",
          type: 'post',
          data: {id:id},
          success: function(data){
            $(".error_msg").text('');
            $('input[name=student_name]').val(data.student_name);
            $('input[name=id]').val(data.id);
            $('input[name=id]').attr( "disabled", "disabled" );
            $('input[name=email]').val(data.email);
            $('input[name=phone_number]').val(data.phone_number);
            $('#addModal').modal('show');

          }
      });

  });

//save data by ajax
  $('#submitForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitBtn').html('Saving..');
      
      $.ajax({
          url: "{{ url('principal/addStudent')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){

            if(data.error){
              $.each(data.error, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
              $('#submitBtn').html('Save');
            }else{
              $('#submitBtn').html('Save');
              swal("Good job!", data.success, "success");
              $('#addModal').modal('hide');
              $("#submitForm")[0].reset();
              $('#studentTable').DataTable().ajax.reload();
            }
          },
          error: function (data) {

              $.each(data.responseJSON.errors, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
              $('#submitBtn').html('Save');
              }

      });
  });

//delete data
$('body').on('click','.deleteBtn',function(){
  var id = $(this).data('id');
        swal({
          title: "Are you sure Delete This Student?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          })
          .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "{{ url('principal/deletStudent')}}",
                type: 'post',
                data:{id:id},
                success: function(data){

                  $('#studentTable').DataTable().ajax.reload();
      
                }
            });
          } else {
              swal("Your file is safe!");
          }
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
