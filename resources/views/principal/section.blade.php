@extends('principal.layout')
@section('title','Section')
@section('content')
{{-- breadcrumb start  --}}
<div class="col-xm-12" style="padding: 0px 20px !important;">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
      <li class="breadcrumb-item"><a href="{{URL::previous()}}">Classes</a></li>
      <li class="breadcrumb-item active"><a href="">Section</a></li>
    </ol>
  </nav>
</div>
{{-- breadcrumb end  --}}
<div class="row "  style="padding: 0px 20px !important;">
    <div class="col md-6 float-left">
        <h3>All Section</h3>
    </div>
    <div class="col md-6 ">
      <!-- {{-- button trigar model  --}} -->
      <button class="btn btn-warning float-right"  data-toggle="modal" id="AddModalBtn">Add New</button>
    </div>
  </div>
<div class="kk_section" style="    padding: 5px 20px;">
    <table class="table table-bordered" id="">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Section Name</th>
            <th scope="col">Shift</th>
            <th scope="col">Class Teacher</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="sectiontable">
            
        </tbody>
    </table>

    <!-- View Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sections</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="newsection">
              <div id="newSectionForm">
                  <form class="mb-3" id="submitSectionForm">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Section Name</label>
                        <input type="text" class="form-control" id="NAMEID" name="section_name" placeholder="Enter Section Name" >
                      <input type="hidden" class="form-control" id="class_idID" name="class_id" placeholder="Enter Section Name" value="{{$class_id}}">
                      <input type="hidden" class="form-control" id="" name="action" >
                      <input type="hidden" class="form-control" id="" name="section_id" >
                        <span class="form-text text-danger err_msg section_name"></span>
                    </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Select Shift </label>
                        <select  class="form-control" name="shift_name" id="SHIFTID">
                            <option value="">Choose Shift</option>
                            <option value="Morning">Morning</option>
                            <option value="Noon">Noon</option>
                        </select>
                        <span class="form-text text-danger err_msg shift_name"></span>
                      </div>
                      <button type="submit" class="btn btn-warning btn-full text-white" id="submitSectionBtn">Add New Section</button>
                    </form>
              </div>
          </div>
        </div>
      </div>
  </div>
    <!-- {{--  modal end  --}} -->
    <!-- Assign teacher  Modal -->
<div class="modal fade" id="assignModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Assign teacher</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="">
              <div id="newSectionForm">
                  <form class="mb-3" id="submitAssignForm">
                      <div class="form-group">
                        <label for="">Select Class teacher </label>
                        <input type="hidden" class="form-control" name="class_id"  value="{{$class_id}}">
                        <input type="hidden" class="form-control" id="sectionID" name="section_id"  value="">
                        <select  class="form-control" name="class_teacher_id" id="">
                            <option value="">Chosse Class Teacher</option>
                            @foreach ($teachers as $teachers)
                            <option value="{{$teachers->id}}">{{$teachers->teacher_name}}</option>  
                            @endforeach
                        </select>
                        <span class="form-text text-danger err_msg shift_name"></span>
                      </div>
                      <button type="submit" class="btn btn-warning btn-full text-white" id="submitTeacherBtn">Save</button>
                    </form>
              </div>
          </div>
        </div>
      </div>
  </div>
    <!-- {{--  modal end  --}} -->
</div>
@section('js')
<script>
//GET SECTION   
function getSection(class_id){
    $.ajax({
        url: "{{ url('principal/getSection?page='.$_GET['page'])}}",
        method: 'post',
        data:{"_token": "{{ csrf_token() }}",class_id:class_id},
        success: function(data){

            $('#sectiontable').html(data);
            $('#sectionModal').modal('show');

            }
        });
  }
//edit section
$('body').on('click','.editBtn',function(){
    var id = $(this).data('id');
    $('.err_msg').text('');

    $.ajax({
          url: "{{ url('principal/section/editData')}}",
          type: 'post',
          data: {id:id},
          success: function(data){
              
            $('input[name="section_id"]').val(data.id);
            $('input[name="section_name"]').val(data.section_name);
            $('input[name=action]').val('edit');
            $('select[name=shift_name]').val(data.shift_name);
            $('#submitSectionBtn').html('Update Section');
             $('#addModal').modal('show');
          }
      });

});
$('body').on('click','#AddModalBtn',function(){

    $("#submitSectionForm")[0].reset();
    $('input[name=action]').val('create');
    $('.err_msg').text('');
    $('#addModal').modal('show');
});

  $('#submitSectionForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $("#submitSectionForm")[0].reset();
      $('#submitSectionBtn').html('Sending..');
      
      $.ajax({
          url: "{{ url('principal/section/add')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){
            if(data.error != null){
              $.each(data.error, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
              $('#submitSectionBtn').html('Add New Section');
            }else{
              $('#submitSectionBtn').html('Add New Section');
              swal("Good job!", data.success, "success");
              $("#submitSectionForm")[0].reset();
              $('#addModal').modal('hide');
              getSection(data.class_id);
            }
          },
          error: function (data) {
              $.each(data.responseJSON.errors, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
              $('#submitSectionBtn').html('Add New Section');
          }
      });
  });
  //delete
  $('body').on('click','.deleteBtn',function(){
        var id = $(this).data('id');
        var class_id = $(this).data('class_id');
        console.log(id);
        swal({
          title: "Are you sure Delete This Section?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          })
          .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "{{ url('principal/section/delete')}}",
                type: 'post',
                data:{id:id,class_id:class_id},
                success: function(data){

                    getSection(data.class_id);
      
                }
            });
          } else {
              swal("Your file is safe!");
          }
          });
  });

//   /a/ssign teacher 
$('body').on('click','.assignBtn',function(){
    var id = $(this).data('id');
    $('#sectionID').val(id);
    $('.err_msg').text('');
    $('#assignModel').modal('show');
});


//asign teacher save
$('#submitAssignForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitTeacherBtn').html('Saving..');
      
      $.ajax({
          url: "{{ url('principal/section/assignTeacher')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){
            $('#submitTeacherBtn').html('Save');
            swal("Good job!", data.success, "success");
            $("#submitAssignForm")[0].reset();
            $('#assignModel').modal('hide');
            getSection(data.class_id);
          },
          error: function (data) {
              $.each(data.responseJSON.errors, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
                  $('#submitTeacherBtn').html('Save');
          }
      });
  });

  getSection({{$class_id}});
</script>
@endsection
@endsection