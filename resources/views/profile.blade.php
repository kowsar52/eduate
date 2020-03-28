@extends($layout)
@section('title','Profile')
@section('content')
{{-- breadcrumb start  --}}
<div class="col-xm-12">
    <a  class="btn btn-info" href="{{URL::previous()}}">Back</a>
  </div>
  {{-- breadcrumb end  --}}
<div class="row justify-content-center">
    <div class="col-xm-6 kk_profile text-center">
        @if ($user->image_path != null)
        <img class="kk_profile_img"  src="{{$user->image_path}}" alt="">
        @else
        <img class="kk_profile_img" src="{{asset('uploads/teachers/demo.jpg')}}" alt="">
        @endif
    <p class="profile_name">{{$user->name}}</p>
    <p class="profile_type">{{$user->user_type}}</p>
    <div class="profile_details text-left">
        <i class="fa fa-user"></i><p>{{$user->username}}</p>
        <i class="fa fa-envelope"></i><p>{{$user->email}}</p>
        <i class="fa fa-phone"></i><p>{{$user->phone_number}}</p>
    </div>
    <div class="pro_footer">
        <img src="{{asset('uploads/logo/eduate_logo.png')}}" alt="">
        @if ($hidden != true)
        <button class="btn btn-warning btn-full text-white mt-2 mb-2 editProfile" data-id="{{$user->username}}">Edit Profile</button>
        <a href="{{ url('changePassword')}}">Change Password?</a>
            
        @endif
    </div>
    </div>

     <!-- edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="mb-3 submitForm" id="">

            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" name="name" placeholder="name">
                <input type="hidden" class="form-control" name="id" placeholder="name">
                <input type="hidden" class="form-control" name="table" placeholder="name">
                 <span class="form-text text-danger chk_msg name"></span>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" name="email" placeholder="email">
                 <span class="form-text text-danger chk_msg email"></span>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Phone Number</label>
                <input type="number" class="form-control" name="phone_number" placeholder="phone_number">
                 <span class="form-text text-danger chk_msg phone_number"></span>
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
     $('.editProfile').click(function(){
        var id = $(this).data('id');
    $.ajax({
      url:"{{ url('profile/getEditData') }}",
      type : "POST",
      data:{id:id,table:'users'},
      success: function(data){
          $('input[name="table"]').val('users');
          $('input[name="name"]').val(data.name);
          $('input[name="id"]').val(data.id);
          $('input[name="email"]').val(data.email);
          $('input[name="phone_number"]').val(data.phone_number);
        $('#editModal').modal('show');
      }
    });
     })

     //save data
     $('.submitForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitBtn').html('Saving..');
      
      $.ajax({
          url: "{{ url('profile/update')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){
            $('#submitBtn').html('Save');
            swal("Good job!", data.success, "success");
            $('#editModal').modal('hide');
            $(".submitForm")[0].reset();

          },
          error: function (data) {
              $.each(data.responseJSON.errors, function(key,val) {
                      $('.'+key).text(val).css('color','red !important');
                  });
              $('#submitBtn').html('Save');
          }
      });
  });
 </script>   
@endsection