@if (Auth::user()->user_type == 'super_admin')
   <?php $role = 'admin/layout'; ?> 
@else
<?php $role = 'principal/layout'; ?> 

@endif
@extends($role)   

@section('title','Change Password')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 chagen_pass">
        <h4 class="text-uppercase text-center">Change Password</h4>
        <span class="form-text text-danger password_error"></span>
        <form id="submitForm">
            <div class="form-group">
                <label for="exampleInputEmail1">Enter Old Password</label>
                <input type="password" class="form-control" name="old_password"  placeholder="Enter Old Passwrod">
                <span class="form-text text-muted old_password"></span>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Enter New Password</label>
                <input type="password" class="form-control" name="new_password"  placeholder="Enter New Passwrod">
                <span class="form-text text-muted new_password"></span>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password"  placeholder="Confirm Passwrod">
                <span class="form-text text-muted confirm_password"></span>
            </div>
            <button type="submit" class="btn btn-warning btn-full text-white" id="submitBtn">Change Password</button>

        </form>
    </div>
</div>
@section('js')
<script>
    $('#submitForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitBtn').html('Changing..');
   
      $.ajax({
          url: "{{ url('changePassword')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){
            if(data.error){
                
                $('.password_error').text(data.error).css('color','red !important');
                $('#submitBtn').html('Change Password');
            }else if(data.success){
                $('#submitBtn').html('Change Password');
                swal("Good job!", data.success, "success");
                $("#submitForm")[0].reset();
            }

          },
          error: function (data) {
              $.each(data.responseJSON.errors, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
              $('#submitBtn').html('Change Password');
          }
      });
  });
</script>
@endsection
@endsection
