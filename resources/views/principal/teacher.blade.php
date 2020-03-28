@extends('principal/layout')
@section('title','All Teacher')
@section('content')
<div class="container_fluid">
  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>All Teachers</h3>
    </div>
    <div class="col md-6 ">
      {{-- button trigar model  --}}
      <button class="btn btn-warning float-right"  data-toggle="modal" id="AddModalBtn">Add New</button>
    </div>
  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="teacherTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">#</th>
          <th scope="col">Teacher Image</th>
          <th scope="col">Teacher Name</th>
          <th scope="col">Assign Class</th>
          <th scope="col">Assign Subject</th>
          <th scope="col" style="">Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <!-- {{--  modal start  --}} -->
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Modaltitle">Add New Teacher</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="mb-3" id="submitForm">
          <div class="form-group">
            <label for="exampleInputEmail1">Teacher Name</label>
            <input type="text" class="form-control" name="teacher_name"  placeholder="Enter Teacher Name">
            <input type="hidden" class="form-control" name="id"  placeholder="Enter Teacher Name">
            <input type="hidden" class="form-control" name="action"  placeholder="Enter Teacher Name">
            <span class="form-text text-muted teacher_name"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Enter Email address">
             <span class="form-text text-muted email"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Phone</label>
            <input type="number" class="form-control" name="phone_number" placeholder="Enter Phone Number" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Select Class <span class="text-success">(Optional)</span></label>
            <select  class="form-control" name="class_id" id="">
                <option value="">Choose Class</option>
                @foreach ($classes as $item)
                  <option value="{{$item->class_id}}">{{$item->class_name}}</option>    
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Select Subject <span class="text-success">(Optional)</span></label>
            <select  class="form-control" name="subject_id" id="">
                <option value="">Choose Subject</option>
                @foreach ($subjects as $item)
                <option value="{{$item->subject_id}}">{{$item->subject_name}}</option>    
              @endforeach
            </select>
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
        $('#teacherTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('principal/allTeachers') }}",
        columns: [
                 { data: 'teacher_id', name: 'teacher_id' },
                 { data: 'image', name: 'image' },
                 { data: 'teacher_name', name: 'teacher_name' },
                 { data: 'assign_class', name: 'assign_class' },
                 { data: 'assign_subject', name: 'assign_subject' },
                 { data: 'action', name: 'action' },
              ]
     });
  });

  // edit class 
  $('body').on('click','.editBtn',function(){
    var id = $(this).data('id');
    $.ajax({
          url: "{{ url('principal/teacher/editData')}}",
          type: 'post',
          data: {id:id},
          success: function(data){
              
            $('input[name=action]').val('edit');
            $('input[name=id]').val(data.id);
            $('input[name=teacher_name]').val(data.teacher_name);
            $('input[name=email]').val(data.email);
            $('input[name=phone_number]').val(data.phone_number);
            $('select[name=class_id]').val(data.class_id);
            $('select[name=subject_id]').val(data.subject_id);
            $('#Modaltitle').text('Edit Teacher');
             $('#addModal').modal('show');
          }
      });

});

  $('body').on('click','#AddModalBtn',function(){
    $('input[name=action]').val('create');
    $('#Modaltitle').text('Add New Teacher');
    $("#submitForm")[0].reset();
    $('#addModal').modal('show');
  });
    //add new school by ajax
  $('#submitForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitBtn').html('Sending..');
      
      $.ajax({
          url: "{{ url('principal/addTeacher')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){
            $('#submitBtn').html('Saved');
            swal("Good job!", data.success, "success");
            $('#addModal').modal('hide');
            $("#submitForm")[0].reset();
            $('#teacherTable').DataTable().ajax.reload();

          },
          error: function (data) {
              $.each(data.responseJSON.errors, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
              $('#submitBtn').html('Save');
          }
      });
  });

  //delete by ajax
  $('body').on('click','.deleteBtn',function(){
        var id = $(this).data('id');

          swal("If you want, please enter your Password .",{
            content: {
              element: "input",
              attributes: {
                placeholder: "Enter your password",
                type: "password",
                name: "password",
                id: "checkPassword",
                text: "Delete",
              }, 
            },
            title: "Are you sure want to delete this?",
            button: {
              text: "Confirm Delete",
              className: "btn-danger",
            },
          })
          .then((willDelete) => {
          if (willDelete) {
          var password = $('#checkPassword').val();
            $.ajax({
                url: "{{ url('principal/teacher/delete')}}",
                type: 'post',
                data:{id:id,password:password},
                success: function(data){
                  if(data.error !=null){
                    swal("Opps!", data.error, "error");
                  }else{
                    swal("Good job!", data.success, "success");

                    $('#teacherTable').DataTable().ajax.reload();

                  }
      
                }
            });
          } else {
              swal("Your data is safe!");
          }
          });
  });


  </script>  
@endsection
