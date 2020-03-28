@extends('principal/layout')
@section('title','Class')
@section('content')
<div class="container_fluid" style="box-shadow: -3px 5px 5px 5px #e8e8e8;margin:10px">
  {{-- breadcrumb start  --}}
  <div class="col-xm-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
        <li class="breadcrumb-item active"><a href="">Classes</a></li>
      </ol>
    </nav>
  </div>
  {{-- breadcrumb end  --}}
  <div class="kk_tab ">
    <div class="row text-center" style="padding: 15px;">
      <div class="col-xm-6" style="background: #eaeaea;font-weight:700;width:50%">
        <a class="nav-link active_medium" href="javascript:void(0)" data-medium="Bangla" id="BanglaLink">Bangla Medium</a>
      </div>
      <div class="col-xm-6" style="background: #eaeaea;font-weight:700;width:50%">
        <a class="nav-link" href="javascript:void(0)"  data-medium="English" id="EnglishLink">English Medium</a>
      </div>
    </div>



  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>All Classes</h3>
    </div>
    <div class="col md-6 ">
      <!-- {{-- button trigar model  --}} -->
      <button class="btn btn-warning float-right"  data-toggle="modal" id="AddModalBtn">Add New</button>
    </div>
  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="classTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">#</th>
          <th scope="col">Class Name</th>
          <th scope="col">Medium</th>
          <th scope="col">Total Sections</th>
          <th scope="col" id="TSR">Total Students</th>
          <th scope="col" style="">Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
  <!-- {{--  modal start  --}} -->
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Class</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="mb-3" id="submitForm">
          <div class="form-group">
            <label for="exampleInputEmail1">Class Name</label>
            <input type="text" class="form-control" name="class_name"  placeholder="Enter Class Name">
            <span class="form-text text-danger error_msg class_name"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Section Name</label>
            <input type="text" class="form-control" name="section_name" placeholder="Enter Section Name" >
            <span class="form-text text-danger error_msg section_name"></span>
        </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Select Shift </label>
            <select  class="form-control" name="shift_name" id="">
                <option value="">Choose Shift</option>
                <option value="Morning">Morning</option>
                <option value="Noon">Noon</option>
            </select>
            <span class="form-text text-danger error_msg shift_name"></span>
          </div>
          <button type="submit" class="btn btn-warning btn-full text-white" id="submitBtn">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
  <!-- {{--  modal end  --}} -->
<!-- Eduit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Class</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="mb-3" id="submitEditForm">
          <div class="form-group">
            <label for="exampleInputEmail1">Class Name</label>
            <input type="text" class="form-control" name="class_name"  placeholder="Enter Class Name">
            <input type="hidden" class="form-control" name="class_id"  placeholder="Enter Class Name">
            <span class="form-text text-danger error_msg class_name"></span>
          </div>
          <button type="submit" class="btn btn-warning btn-full text-white" id="submitBtn">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
  <!-- {{--  modal end  --}} -->


 </div>

@endsection
@section('js')

<script>
  $("#BanglaLink").on('click',function(){
    $(this).addClass('active_medium');
    $('#EnglishLink').removeClass('active_medium');
    $('body.kk_medium').val('Bangla');
    getData();
  });
  $("#EnglishLink").on('click',function(){
    $(this).addClass('active_medium');
    $('#BanglaLink').removeClass('active_medium');
    $('body.kk_medium').val('English');
    getData();
    
  });

  $(document).ready(function () {
    
    var url = "<?php echo @$_GET['page'] ?>";
    if(url === "subjects"){
      $('#TSR').html('Total Subjects');
    }
    getData();  
  });

function getData(){
  var medium = $('.active_medium').data('medium');
  
    var dt = $('#classTable').DataTable({
        // basic
        destroy: true,
        processing: true,
        lengthChange: false,
        pageLength: 10,
        serverSide: true,
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'class_name' },
            { data: 'medium' },
            { data: 'total_section' },
            { data: 'total_student' },
            { data: 'action' }
        ],
         
        // ajax
        ajax: {
            url: "{{ url('principal/allClasses/') }}",
            type: 'POST',
            data: {
              medium: medium,
              page: "{{$page}}",
            }
        }
    });
}

    //add new school by ajax
  $('#submitForm').on('submit',function(e){
      e.preventDefault();
      var medium = $('.active_medium').data('medium');
      var formdata= new FormData(this);
      formdata.append('medium', medium);
      $('#submitBtn').html('Sending..');
      
      $.ajax({
          url: "{{ url('principal/addClass')}}",
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
              $('#submitBtn').html('Saved');
            swal("Good job!", data.success, "success");
            $('#addModal').modal('hide');
            $("#submitForm")[0].reset();
            $('#classTable').DataTable().ajax.reload();
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


  //delete class 
    //delete
    $('body').on('click','.deleteBtn',function(){
        var class_id = $(this).data('class_id');
        swal({
          title: "Are you sure Delete This Class?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          })
          .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "{{ url('principal/class/delete')}}",
                type: 'post',
                data:{class_id:class_id},
                success: function(data){

                  $('#classTable').DataTable().ajax.reload();
      
                }
            });
          } else {
              swal("Your file is safe!");
          }
          });
  });

  // edit class 
  $('body').on('click','.editBtn',function(){
      var class_name = $(this).data('class_name');
      var class_id = $(this).data('class_id');
      $('input[name=class_name]').val(class_name);
      $('input[name=class_id]').val(class_id);
      $('.error_msg').text('');
      $('#editModal').modal('show');
  });

      //editschool by ajax
      $('#submitEditForm').on('submit',function(e){
      e.preventDefault();
      var medium = $('.active_medium').data('medium');
      var formdata= new FormData(this);
      formdata.append('medium', medium);
      $('#submitBtn').html('Sending..');
      
      $.ajax({
          url: "{{ url('principal/class/edit')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){
            $('#submitBtn').html('Saved');
            swal("Good job!", data.success, "success");
            $('#editModal').modal('hide');
            $("#submitEditForm")[0].reset();
            $('#classTable').DataTable().ajax.reload();

          },
          error: function (data) {
              $.each(data.responseJSON.errors, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
              $('#submitBtn').html('Save');
          }
      });
  });


  $('body').on('click','#AddModalBtn',function(){

    $("#submitForm")[0].reset();
    $('.error_msg').text('');
    $('#addModal').modal('show');
  });




  </script>  
@endsection
