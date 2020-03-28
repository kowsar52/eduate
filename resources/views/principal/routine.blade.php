@extends('principal/layout')
@section('title','Routine')
@section('content')
<div class="container_fluid" style="box-shadow: -3px 5px 5px 5px #e8e8e8;margin:10px">
  {{-- breadcrumb start  --}}
  <div class="col-xm-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Add New Routine</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="mb-3" id="submitForm">
          <div class="form-group">
            <label for="exampleInputEmail1">Choose Medium </label>
            <select  class="form-control" name="medium" id="">
                <option value="">Choose Medium</option>
                <option value="Bangla">Bangla</option>
                <option value="English">English</option>
            </select>
            <span class="form-text text-danger error_msg medium"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Choose Class </label>
            <select  class="form-control" name="class_id" id="">
                <option value="">Choose Class</option>
                @foreach ($classes as $class)
                <option value="{{$class->class_id}}">{{$class->class_name}}</option>              
                @endforeach
            </select>
            <span class="form-text text-danger error_msg class_id"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Choose Section </label>
            <select  class="form-control" name="section_id" id="SECTION">
                <option value="">Choose Section</option>
            </select>
            <span class="form-text text-danger error_msg section_id"></span>
          </div>
          <div class="form-group d-none " id="EX_TYPE">
            <label for="">Exam Type</label>
            <select  class="form-control" name="exam_type" id="">
              <option value="">Choose Exam Type</option>
              <option value="Class Test">Class Test</option>
              <option value="Monthly Test">Monthly Test</option>
              <option value="Half Yearly">Half Yearly</option>
              <option value="Final">Final</option>
            </select>
             <span class="form-text text-danger error_msg exam_type"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Upload File</label>
            <input type="file"  class="form-control" name="file" id=""/>
            <span class="form-text text-danger error_msg file"></span>
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
            { data: 'action' }
        ],        
        // ajax
        ajax: {
            url: "{{ url('principal/getRoutine/?routine_type=') }}"+routine_type,
            type: 'GET',
        }
    });
}

//get section by class 
$('select[name="class_id"]').on('change',function(){
  var class_id = $(this).val();
    $.ajax({
      url:"{{ url('principal/routine/getSection') }}",
      type : "POST",
      data:{class_id:class_id},
      success: function(data){
        $('#SECTION').html(data);
      }
    });
})

    //add new school by ajax
  $('#submitForm').on('submit',function(e){
      e.preventDefault();
      var routine_type = $('.active_medium').data('routine_type');
      var formdata= new FormData(this);
      formdata.append('routine_type', routine_type);
      $('#submitBtn').html('Saving..');
      
      $.ajax({
          url: "{{ url('principal/addRoutine')}}",
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
              $('#routineTable').DataTable().ajax.reload();
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
        var id = $(this).data('id');
        swal({
          title: "Are you sure Delete This Routine?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          })
          .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "{{ url('principal/routine/delete')}}",
                type: 'post',
                data:{id:id},
                success: function(data){

                  $('#routineTable').DataTable().ajax.reload();
      
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



  $('body').on('click','#AddModalBtn',function(){

    $("#submitForm")[0].reset();
    $('.error_msg').text('');
    $('#addModal').modal('show');
  });




  </script>  
@endsection
