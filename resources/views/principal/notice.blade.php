@extends('principal/layout')
@section('title','Notice')
@section('content')
<div class="container_fluid" style="box-shadow: -3px 5px 5px 5px #e8e8e8;margin:10px">
  {{-- breadcrumb start  --}}
  <div class="col-xm-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
        <li class="breadcrumb-item active"><a href="">Notice</a></li>
      </ol>
    </nav>
  </div>
  {{-- breadcrumb end  --}}

  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>All Notices</h3>
    </div>
    <div class="col md-6 ">
      <!-- {{-- button trigar model  --}} -->
      <button class="btn btn-warning float-right"  data-toggle="modal" id="AddModalBtn">Add New</button>
    </div>
  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="noticeTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">#</th>
          <th scope="col">Image</th>
          <th scope="col">Title</th>
          <th scope="col">Details</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Add New </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="mb-3" id="submitForm">
          <div class="form-group">
            <label for="exampleInputEmail1">Title</label>
            <input type="text"  class="form-control" name="title" id=""/>
            <span class="form-text text-danger error_msg title"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Details</label>
            <textarea name="details" class="form-control" ></textarea>
            <span class="form-text text-danger error_msg details"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Choose Medium </label>
            <select  class="form-control" name="medium" id="">
                <option value="">Choose Medium</option>
                <option value="*">All</option>
                <option value="Bangla">Bangla</option>
                <option value="English">English</option>
            </select>
            <span class="form-text text-danger error_msg medium"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Choose Class </label>
            <select  class="form-control" name="class_id" id="SECTION">
                <option value="">Choose Class</option>
            </select>
            <span class="form-text text-danger error_msg class_id"></span>
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
  $(function() {
        $('#noticeTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('principal/notice') }}",
        columns: [
                 { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                 { data: 'image', name: 'image' },
                 { data: 'title', name: 'title' },
                 { data: 'details', name: 'details' },
                 { data: 'download', name: 'download' },
                 { data: 'action', name: 'action' },
              ]
     });
  });

//get section by class 
$('select[name="medium"]').on('change',function(){
  var medium = $(this).val();
    $.ajax({
      url:"{{ url('principal/notice/getClass') }}",
      type : "POST",
      data:{medium:medium},
      success: function(data){
        $('#SECTION').html(data);
      }
    });
})

    //add new school by ajax
  $('#submitForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitBtn').html('Saving..');
      
      $.ajax({
          url: "{{ url('principal/addNotice')}}",
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
              $('#noticeTable').DataTable().ajax.reload();
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
          title: "Are you sure Delete This Notice?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          })
          .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "{{ url('principal/notice/delete')}}",
                type: 'post',
                data:{id:id},
                success: function(data){

                  $('#noticeTable').DataTable().ajax.reload();
      
                }
            });
          } else {
              swal("Your file is safe!");
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
