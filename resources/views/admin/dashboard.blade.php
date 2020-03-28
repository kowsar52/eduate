@extends('admin/layout')
@section('title','Dashboard')
@section('content')
<div class="container_fluid">
  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>All Schools</h3>
    </div>
    <div class="col md-6 ">
      {{-- button trigar model  --}}
      <button class="btn btn-warning float-right"  data-toggle="modal" data-target="#addModal">Add New</button>
    </div>
  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="schoolTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">#</th>
          <th scope="col">School Image</th>
          <th scope="col">School Name</th>
          <th scope="col">Author Name</th>
         <th scope="col">Author ID</th>
        <th scope="col" style="width: 55px">Status</th>
          <th scope="col" style="width: 55px">Action</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Add New School</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="mb-3" id="submitForm">
          <div class="form-group">
            <label for="exampleInputEmail1">School Name</label>
            <input type="text" class="form-control" name="school_name"  placeholder="Enter School Name">
            <span class="form-text text-muted school_name"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Authority/ Principal Name</label>
            <input type="text" class="form-control" name="name"  placeholder="Enter Authority Name">
             <span class="form-text text-muted name"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Authority Email</label>
            <input type="email" class="form-control" name="email">
             <span class="form-text text-muted email"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Authority Phone</label>
            <input type="number" class="form-control" name="phone_number" required>
          </div>
          <button type="submit" class="btn btn-warning btn-full text-white" id="submitBtn">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
  <!-- {{--  modal end  --}} -->
<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">School Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="viewImg">
        <img src="" alt="">
      </div>
      <div id="schDetails">

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
        $('#schoolTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('admin/getSchools') }}",
        columns: [
                 { data: 'school_id', name: 'school_id' },
                 { data: 'image', name: 'image' },
                 { data: 'school_name', name: 'school_name' },
                 { data: 'author', name: 'author' },
                 { data: 'username', name: 'username' },
                 { data: 'status', name: 'status' },
                 { data: 'action', name: 'action' },
              ]
     });
  });


    //add new school by ajax
  $('#submitForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitBtn').html('Sending..');
      
      $.ajax({
          url: "{{ url('admin/addSchool')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){
            $('#submitBtn').html('Saved');
            swal("Good job!", data.success, "success");
            $("#submitForm")[0].reset();
            $('#addModal').modal('hide');
            
            $('#schoolTable').DataTable().ajax.reload();

          },
          error: function (data) {
              $.each(data.responseJSON.errors, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
              $('#submitBtn').html('Save');
          }
      });
  });

  //active/deactive by ajax
  $('body').on('click','.statusBtn',function(){
        var id = $(this).data('id');
        swal({
          title: "Are you sure?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          })
          .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "{{ url('admin/activeDeactive')}}",
                type: 'post',
                data:{id:id},
                success: function(data){

                  $('#schoolTable').DataTable().ajax.reload();
      
                }
            });
          } else {
              swal("Your file is safe!");
          }
          });
  });

  $('body').on('click','.viewBtn',function(){
    var school_id = $(this).data('school_id');
    $.ajax({
        url: "{{ url('admin/schoolDetails')}}",
        type: 'post',
        data:{school_id:school_id},
        success: function(data){
          
            if(data.account_status === 1){

              var account_status = '<a href="javascript:" class="btn badge badge-success statusBtn" data-id="'+data.id+'">Active</a>';
              }else{
              var account_status = '<a href="javascript:" class="btn badge badge-danger statusBtn" data-id="'+data.id+'">Deactive</a>';
              }
              
              if(data.image_path === null){
                  var image_path = "{{ asset('/uploads/schools/default_school.jpg')}}";
              }else{
                   var image_path = data.image_path;
              }

          var details =`<table class="table table-striped">
              <thead>
                <tr >
                  <td colspan="2" style="border:none !important"><img src="`+image_path+`" height="200px" width="100%"/></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td scope="row" class="font-weight-bold table_title">School Id</td>
                  <td scope="row" class="text-uppercase">`+data.school_id+`</td>
                </tr>
                <tr>
                  <td scope="row" class="font-weight-bold table_title">School Name</td>
                  <td scope="row">`+data.school_name+`</td>
                </tr>
                <tr>
                  <td scope="row" class="font-weight-bold table_title">Authority Id</td>
                  <td scope="row" class="text-uppercase">`+data.username+`</td>
                </tr>
                <tr>
                  <td scope="row" class="font-weight-bold table_title">Authority Name</td>
                  <td scope="row">`+data.name+`</td>
                </tr>
                <tr>
                  <td scope="row" class="font-weight-bold table_title">Email</td>
                  <td scope="row">`+data.email+`</td>
                </tr>
                <tr>
                  <td scope="row" class="font-weight-bold table_title">Phone</td>
                  <td scope="row">`+data.phone_number+`</td>
                </tr>
                <tr>
                  <td scope="row" class="font-weight-bold table_title">Joining From</td>
                  <td scope="row">`+new Date(data.created_at).toLocaleDateString("en-US", {   day: 'numeric' ,month: 'long', year: 'numeric'})+`</td>
                </tr>
                <tr>
                  <td scope="row" class="font-weight-bold table_title">Account Status</td>
                  <td scope="row">`+account_status+`</td>
                </tr>
                <tr>
                  <td colspan="2" class="text-center"><i class="fa fa-comment"></i></td>
                </tr>
              </tbody>
            </table>`;
          $('#schDetails').html(details);
          $('#viewModal').modal('show');

        }
    });

  });
  </script>  
@endsection
