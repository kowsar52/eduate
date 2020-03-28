@extends('principal/layout')
@section('title','Modarator')
@section('content')
<div class="container_fluid">
    {{-- breadcrumb start  --}}
<div class="col-xm-12">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
      <li class="breadcrumb-item active"><a href="">Moderators</a></li>
    </ol>
  </nav>
</div>
{{-- breadcrumb end  --}}
  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>Moderators</h3>
    </div>
    <div class="col md-6 ">
      <!-- {{-- button trigar model  --}} -->
      <button class="btn btn-warning float-right"  data-toggle="modal" id="AddModalBtn">Add New</button>
    </div>
  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="modaratorTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">#</th>
          <th scope="col">Moderator Name</th>
          <th scope="col">Moderator Type</th>
          <th scope="col">Email</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Moderators</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="mb-3" id="submitForm">
          <div class="form-group">
            <label for="exampleInputEmail1">Moderator Name</label>
            <input type="text" class="form-control" name="modarator_name"  placeholder="Enter Moderator Name">
            <span class="form-text text-muted modarator_name"></span>
          </div>
          <div class="form-group">
            <label for="">Moderator Type</label>
            <select  class="form-control" name="modarator_type" id="">
              <option value="">Choose Moderator Type</option>  
              <option value="Vice_Principal">Vice_Principal</option>
              <option value="Accountant">Accountant</option>
              <option value="Stuff">Stuff</option>
            </select>
             <span class="form-text text-muted subject_id"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email Address">
            <span class="form-text text-muted email"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Phone</label>
            <input type="number" class="form-control" name="phone_number" placeholder="Phone Number">
            <span class="form-text text-muted phone_number"></span>
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
        $('#modaratorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('principal/getModerators') }}",
        columns: [
                 { data: 'id', name: 'id' },
                 { data: 'moderator_name', name: 'moderator_name' },
                 { data: 'moderator_type', name: 'moderator_type' },
                 { data: 'email', name: 'email' },
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



//save data by ajax
  $('#submitForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitBtn').html('Saving..');
      
      $.ajax({
          url: "{{ url('principal/addModarator')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){
            $('#submitBtn').html('Save');
            swal("Good job!", data.success, "success");
            $('#addModal').modal('hide');
            $("#submitForm")[0].reset();
            $('#modaratorTable').DataTable().ajax.reload();

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
                url: "{{ url('principal/deleteModarator')}}",
                type: 'post',
                data:{id:id,password:password},
                success: function(data){
                  if(data.error !=null){
                    swal("Opps!", data.error, "error");
                  }else{
                    swal("Good Job!", data.success, "success");

                    $('#modaratorTable').DataTable().ajax.reload();

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
