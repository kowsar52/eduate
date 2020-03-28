@extends('principal/layout')
@section('title','Subject')
@section('content')
<div class="container_fluid">
  {{-- breadcrumb start  --}}
<div class="col-xm-12">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
      <li class="breadcrumb-item"><a href="{{url('principal/allSubjects?page=subjects')}}">Classes</a></li>
      <li class="breadcrumb-item active"><a href="">Subjects</a></li>
    </ol>
  </nav>
</div>
{{-- breadcrumb end  --}}
  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>Subjects</h3>
    </div>
    <div class="col md-6 ">
      <!-- {{-- button trigar model  --}} -->
      <button class="btn btn-warning float-right"  data-toggle="modal" id="AddModalBtn">Add New</button>
    </div>
  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="subjectTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">#</th>
          <th scope="col">Subject Name</th>
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
            <label for="exampleInputEmail1">Subject Name</label>
            <input type="text" class="form-control" name="subject_name"  placeholder="Enter Class Name">
          <input type="hidden" class="form-control" name="class_id" value="{{$class_id}}">
            <input type="hidden" class="form-control" name="action" >
            <input type="hidden" class="form-control" name="subject_id" >
            <span class="form-text text-muted subject_name"></span>
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
        $('#subjectTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('principal/getSubject?class_id='.$class_id) }}",
        columns: [
                 { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                 { data: 'subject_name', name: 'subject_name' },
                 { data: 'action', name: 'action' },
              ]
     });
  });


  // edit class 
  $('body').on('click','.editBtn',function(){
      var subject_name = $(this).data('subject_name');
      var subject_id = $(this).data('subject_id');
      $('input[name=subject_name]').val(subject_name);
      $('input[name=subject_id]').val(subject_id);
      $('input[name=action]').val('edit');
      $('#addModal').modal('show');
  });

  $('body').on('click','#AddModalBtn',function(){
    $('input[name=action]').val('create');
    $("#submitForm")[0].reset();
    $('#addModal').modal('show');
  });

      //editschool by ajax
      $('#submitForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitBtn').html('Sending..');
      
      $.ajax({
          url: "{{ url('principal/addSubject')}}",
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
  var subject_id = $(this).data('subject_id');
        swal({
          title: "Are you sure Delete This Subject?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          })
          .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "{{ url('principal/subjectDelete')}}",
                type: 'post',
                data:{subject_id:subject_id},
                success: function(data){

                  $('#subjectTable').DataTable().ajax.reload();
      
                }
            });
          } else {
              swal("Your file is safe!");
          }
          });
  });






  </script>  
@endsection
