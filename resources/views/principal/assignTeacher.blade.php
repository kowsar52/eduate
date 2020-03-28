@extends('principal/layout')
@section('title','Assign teacher')
@section('content')
<div class="container_fluid">
  {{-- breadcrumb start  --}}
<div class="col-xm-12">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
      <li class="breadcrumb-item"><a href="{{url('principal/assignTeacher')}}">Classes</a></li>
      <li class="breadcrumb-item"><a href="{{URL::previous()}}">Section</a></li>
      <li class="breadcrumb-item active"><a href="">Assign teacher</a></li>
    </ol>
  </nav>
</div>
<div class="getAssignDataDiv"></div>


<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Teacher</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="mb-3" id="submitForm">
          <div class="form-group">
            <label for="exampleInputEmail1">Choose Teacher</label>
            <input type="hidden" name="action">
            <input type="hidden" name="subject_id">
            <input type="hidden" name="ass_id">
          <input type="hidden" name="section_id" value="{{$section->id}}">
            <select  class="form-control" name="teacher_id" id="">
                <option value="">Choose Teacher</option>
                @foreach ($teachers as $teacher)
                    
                <option value="{{$teacher->id}}">{{$teacher->teacher_name}}</option>
                @endforeach
            </select>
            <span class="form-text text-danger error_msg teacher_id"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Time</label>
            <input type="time" class="form-control" name="start_time" >
            <span class="form-text text-danger error_msg start_time"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Duration</label>
            <select  class="form-control" name="duration" id="">
                <option value="">Choose Duration</option>
                <option value="30">30 Minutes</option>
                <option value="35">35 Minutes</option>
                <option value="40">40 Minutes</option>
                <option value="45">45 Minutes</option>
                <option value="50">50 Minutes</option>
                <option value="55">55 Minutes</option>
                <option value="60">1 Hour</option>
                <option value="70">1 Hour 10 Minutes</option>
                <option value="80">1 Hour 20 Minutes</option>
                <option value="90">1 Hour 30 Minutes</option>
                <option value="100">1 Hour 40 Minutes</option>
                <option value="110">1 Hour 50 Minutes</option>
                <option value="120">2 Hour</option>
            </select>
            <span class="form-text text-danger error_msg duration"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Day</label>
            <select  class="form-control" name="day" id="">
                <option value="">Choose day</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wenesday">Wenesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
            </select>
            <span class="form-text text-danger error_msg duration"></span>
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
 function getAssign(){
    $.ajax({
        url: "{{ url('principal/getAssignData?section_id='.$_GET['section_id'])}}",
        method: 'get',
        success: function(data){

          $('.getAssignDataDiv').html(data);
            }
        });
  }
  getAssign();
  // edit class 
  $('body').on('click','.editBtn',function(){
      var ass_id = $(this).data('ass_id');
      $.ajax({
          url: "{{ url('principal/assignTeacher/edit')}}",
          type: 'post',
          data:{ ass_id:ass_id},
          success: function(data){
   
            $('input[name=ass_id]').val(data.ass_id);
            $('input[name=subject_id]').val(data.subject_id);
            $('select[name=teacher_id]').val(data.teacher_id);
            $('input[name=start_time]').val(data.start_time);
            $('select[name=duration]').val(data.duration);
            $('select[name=day]').val(data.day);
            $('input[name=action]').val('edit');
            $('#addModal').modal('show');
          }
      });

  });

  $('body').on('click','.AddModalBtn',function(){
    var subject_id = $(this).data('subject_id');
    $('input[name=subject_id]').val(subject_id);
    $('input[name=action]').val('create');
    $("#submitForm")[0].reset();
    $('#addModal').modal('show');
  });

      //editschool by ajax
      $('#submitForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitBtn').html('Saving..');
      
      $.ajax({
          url: "{{ url('principal/assignTeacher/save')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){
            $('#submitBtn').html('Saved');
            swal("Good job!", data.success, "success");
            $('#addModal').modal('hide');
            $("#submitForm")[0].reset();
            $('#subjectTable').DataTable().ajax.reload();
            getAssign();
          },
          error: function (data) {
              $.each(data.responseJSON.errors, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
              $('#submitBtn').html('Save');
          }
      });
  });

//delete subject
$('body').on('click','.deleteBtn',function(){
  var ass_id = $(this).data('ass_id');
        swal({
          title: "Are you sure Delete This?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          })
          .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "{{ url('principal/assignTechDelete')}}",
                type: 'post',
                data:{ass_id:ass_id},
                success: function(data){

                  getAssign();
      
                }
            });
          } else {
              swal("Your file is safe!");
          }
          });
  });






  </script>  
@endsection
