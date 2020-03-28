@extends('principal/layout')
@section('title','Exam')
@section('content')
<div class="container_fluid">
  {{-- breadcrumb start  --}}
<div class="col-xm-12" style="padding: 0px 20px !important;">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
      <li class="breadcrumb-item"><a href="{{url('principal/createExam')}}">Classes</a></li>
      <li class="breadcrumb-item"><a href="{{URL::previous()}}">Section</a></li>
      <li class="breadcrumb-item active"><a href="">Exam</a></li>
    </ol>
  </nav>
</div>
{{-- breadcrumb end  --}}
  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>Exams</h3>
    </div>
    <div class="col md-6 ">
      <!-- {{-- button trigar model  --}} -->
      <button class="btn btn-warning float-right"  data-toggle="modal" id="AddModalBtn">Add New</button>
    </div>
  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="examTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">#</th>
          <th scope="col">Exam Name</th>
          <th scope="col">Exam Type</th>
          <th scope="col">Subject Name</th>
          <th scope="col">Date</th>
          <th scope="col">Marks</th>
          <th scope="col" style="">Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <!-- {{--  modal start  --}} -->

<!-- Eduit Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Subject</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="mb-3" id="submitForm">
          <div class="form-group">
            <label for="">Exam Type</label>
            <select  class="form-control" name="exam_type" id="">
              <option value="">Choose Exam Type</option>
              <option value="Class Test">Class Test</option>
              <option value="Monthly Test">Monthly Test</option>
              <option value="Half Yearly">Half Yearly</option>
              <option value="Final">Final</option>
            </select>
             <span class="form-text text-muted exam_type"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Exam Name</label>
            <input type="text" class="form-control" name="exam_name"  placeholder="Enter Exam Name">
            <input type="hidden" class="form-control" name="section_id" value="{{$section_id}}">
            <input type="hidden" class="form-control" name="exam_id" value="">
            <input type="hidden" class="form-control" name="action" >
            <span class="form-text text-muted exam_name"></span>
          </div>
          <div class="form-group">
            <label for="">Subject</label>
            <select  class="form-control" name="subject_id" id="">
              <option value="">Choose Subject</option>
              @foreach ($subjects as $subject)
                  
              <option value="{{$subject->subject_id}}">{{$subject->subject_name}}</option>
              @endforeach
            </select>
             <span class="form-text text-muted subject_id"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Date</label>
            <input type="date" class="form-control" name="create_date" >
            <span class="form-text text-muted create_date"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Time</label>
            <input type="time" class="form-control" name="create_time" >
            <span class="form-text text-muted create_time"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Marks</label>
            <input type="number" class="form-control" name="marks" >
            <span class="form-text text-muted marks"></span>
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
  $(function() {
        $('#examTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('principal/getExams?section_id='.$section_id) }}",
        columns: [
                 { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                 { data: 'exam_name', name: 'exam_name' },
                 { data: 'exam_type', name: 'exam_type' },
                 { data: 'subject_name', name: 'subject_name' },
                 { data: 'create_date', name: 'create_date' },
                 { data: 'marks', name: 'marks' },
                 { data: 'action', name: 'action' },
              ]
     });
  });
  //add button
  $('body').on('click','#AddModalBtn',function(){
    $('input[name=action]').val('create');
    $("#submitForm")[0].reset();
    $('#addModal').modal('show');
  });

  // edit data
  $('body').on('click','.editBtn',function(){
      var id = $(this).data('id');
      $('input[name=exam_id]').val(id);
      $('input[name=action]').val('edit');
      $.ajax({
          url: "{{ url('principal/getEditData')}}",
          type: 'post',
          data: {id:id},
          success: function(data){
            $('select[name=exam_type]').val(data.exam_type);
            $('input[name=exam_name]').val(data.exam_name);
            $('select[name=subject_id]').val(data.subject_id);
            $('input[name=create_date]').val(data.create_date);
            $('input[name=create_time]').val(data.create_time);
            $('input[name=marks]').val(data.marks);
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
          url: "{{ url('principal/addexam')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){
            $('#submitBtn').html('Saved');
            swal("Good job!", data.success, "success");
            $('#addModal').modal('hide');
            $("#submitForm")[0].reset();
            $('#examTable').DataTable().ajax.reload();

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
          title: "Are you sure Delete This Exam?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          })
          .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "{{ url('principal/examDelete')}}",
                type: 'post',
                data:{id:id},
                success: function(data){

                  $('#examTable').DataTable().ajax.reload();
      
                }
            });
          } else {
              swal("Your file is safe!");
          }
          });
  });






  </script>  
@endsection
