@extends('principal/layout')
@section('title','transaction')
@section('content')
{{-- breadcrumb start  --}}
<div class="col-xm-12">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
      <li class="breadcrumb-item active"><a  href="#">Transaction</a>
    </ol>
  </nav>
</div>
{{-- breadcrumb end  --}}
<div class="row kk_teach_menu">
    <div class="col-md-4">
        <div class="kk_item studentModalBtn" style="cursor: pointer">
            <i class="fa fa-dollar-sign text-white text-center" style="font-size:40px;margin-top:5px"></i>
            <a href="javascript:void(0)">Student Fees</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="kk_item teacherModalBtn" style="cursor: pointer;background-image: linear-gradient(to right,#28a745,#e8e231);">
            <i class="fa fa-dollar-sign text-white text-center" style="font-size:40px;margin-top:5px"></i>
            <a href="javascript:void(0)">Teacher Salery</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="kk_item stuffModalBtn" style="cursor: pointer;background-image: linear-gradient(to right,#f31470,#9931e8);">
            <i class="fa fa-dollar-sign text-white text-center" style="font-size:40px;margin-top:5px"></i>
            <a href="javascript:void(0)">Stuff Salery</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="kk_item otherModalBtn" style="cursor: pointer;background-image: linear-gradient(to right,#1444f3,#2eb5f5);">
            <i class="fa fa-dollar-sign text-white text-center" style="font-size:40px;margin-top:5px"></i>
            <a href="javascript:void(0)">Other Transaction</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="kk_item" style="background-image: linear-gradient(to right,#8c03e2,#f52e8a);">
            <a href="{{ url('principal/trasnsaction/history')}}">
            <i class="fa fa-dollar-sign text-white text-center" style="font-size:40px;margin-top:5px"></i>
            <a href="{{ url('principal/trasnsaction/history')}}">Transaction History</a>
        </a>
        </div>
    </div>

    <!-- student Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Student Fees</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="mb-3 submitForm" id="">
            <div class="form-group">
              <label for="exampleInputEmail1">Choose Class</label>
              <input type="hidden" name="type" value="student">
              <select name="class_id"  class="form-control">
                  <option value="">Choose Class</option>
                  @foreach ($classes as $item)
                    <option value="{{ $item->class_id}}">{{ $item->class_name}}</option>
                      
                  @endforeach
              </select>
              <span class="form-text text-danger chk_msg class_id"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Choose Student</label>
              <select name="sender_id"  class="form-control" id="SECTION">
                  <option value="">Choose Student</option>
              </select>
              <span class="form-text text-danger chk_msg sender_id"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Fee Type</label>
              <select name="transaction_name"  class="form-control">
                  <option value="">Choose Fee type</option>
                  <option value="Exam Fee">Exam Fee</option>
                  <option value="Monthly Fee">Monthly Fee</option>
                  <option value="Tutorial Fee">Tutorial Fee</option>
                  <option value="Fine">Fine</option>
                  <option value="Others">Others</option>
              </select>
              <span class="form-text text-danger chk_msg transaction_name"></span>

            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Amount</label>
                <input type="number" class="form-control" name="amount" placeholder="Amount">
                 <span class="form-text text-danger chk_msg amount"></span>
              </div>
            <button type="submit" class="btn btn-warning btn-full text-white" id="submitBtn">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
    <!-- {{--  modal end  --}} -->

    <!-- teacherModal Modal -->
<div class="modal fade" id="teacherModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Teacher Salery</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="mb-3 submitForm" id="">
            <div class="form-group">
              <label for="exampleInputEmail1">Choose Teacher</label>
              <input type="hidden" name="type" value="teacher">
              <select name="receiver_id"  class="form-control">
                  <option value="">Choose Teacher</option>
                  @foreach ($teachers as $item)
                    <option value="{{ $item->id}}">{{ $item->id .' - '. $item->teacher_name}}</option>
                      
                  @endforeach
              </select>
              <span class="form-text text-danger chk_msg receiver_id"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Payment Method</label>
              <select name="payment_method"  class="form-control">
                  <option value="">Choose Payment Method</option>
                  <option value="Cash">Cash</option>
                  <option value="Bkash">Bkash</option>
                  <option value="Bank Check">Bank Check</option>
              </select>
              <span class="form-text text-danger chk_msg payment_method"></span>

            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Amount</label>
                <input type="number" class="form-control" name="amount" placeholder="Amount">
                 <span class="form-text text-danger chk_msg amount"></span>
              </div>
            <button type="submit" class="btn btn-warning btn-full text-white" id="submitBtn">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
    <!-- {{--  modal end  --}} -->
    <!-- stuff Modal -->
<div class="modal fade" id="stuffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Stuff Salery</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="mb-3 submitForm" id="">
            <div class="form-group">
              <label for="exampleInputEmail1">Choose Stuff</label>
              <input type="hidden" name="type" value="stuff">
              <select name="receiver_id"  class="form-control">
                  <option value="">Choose Stuff</option>
                  @foreach ($stuffs as $item)
                    <option value="{{ $item->id}}">{{ $item->id .' - '. $item->moderator_name}}</option>
                      
                  @endforeach
              </select>
              <span class="form-text text-danger chk_msg receiver_id"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Payment Method</label>
              <select name="payment_method"  class="form-control">
                  <option value="">Choose Payment Method</option>
                  <option value="Cash">Cash</option>
                  <option value="Bkash">Bkash</option>
                  <option value="Bank Check">Bank Check</option>
              </select>
              <span class="form-text text-danger chk_msg payment_method"></span>

            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Amount</label>
                <input type="number" class="form-control" name="amount" placeholder="Amount">
                 <span class="form-text text-danger chk_msg amount"></span>
              </div>
            <button type="submit" class="btn btn-warning btn-full text-white" id="submitBtn">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
    <!-- {{--  modal end  --}} -->
    <!-- other Modal -->
<div class="modal fade" id="otherModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Other Salery</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="mb-3 submitForm" id="">
            <div class="form-group">
              <label for="exampleInputEmail1">Receiver Id or Name</label>
              <input type="hidden" name="type" value="other">
              <input type="text" name="receiver_id"  class="form-control" placeholder="Receiver Id or Name"/>
              <span class="form-text text-danger chk_msg receiver_id"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Transaction Name</label>
              <input type="text" name="transaction_name"  class="form-control" placeholder="Transaction Name"/>
              <span class="form-text text-danger chk_msg transaction_name"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Payment Method</label>
              <select name="payment_method"  class="form-control">
                  <option value="">Choose Payment Method</option>
                  <option value="Cash">Cash</option>
                  <option value="Bkash">Bkash</option>
                  <option value="Bank Check">Bank Check</option>
              </select>
              <span class="form-text text-danger chk_msg payment_method"></span>

            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Transaction Type</label>
              <select name="transaction_type"  class="form-control">
                  <option value="">Choose Transaction Type</option>
                  <option value="Debit">Debit</option>
                  <option value="Credit">Credit</option>
              </select>
              <span class="form-text text-danger chk_msg transaction_type"></span>

            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Amount</label>
                <input type="number" class="form-control" name="amount" placeholder="Amount">
                 <span class="form-text text-danger chk_msg amount"></span>
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

 
  $('.studentModalBtn').click(function(){
        $(".submitForm")[0].reset();
      $('#studentModal').modal('show');
      $('.chk_msg').text('');
      
  });

  $('.teacherModalBtn').click(function(){
        $(".submitForm")[0].reset();
      $('#teacherModal').modal('show');
      $('.chk_msg').text('');
      
  });

  $('.stuffModalBtn').click(function(){
        $(".submitForm")[0].reset();
      $('#stuffModal').modal('show');
      $('.chk_msg').text('');
      
  });

  $('.otherModalBtn').click(function(){
        $(".submitForm")[0].reset();
      $('#otherModal').modal('show');
      $('.chk_msg').text('');
      
  });

//get section by class 
$('select[name="class_id"]').on('change',function(){
  var class_id = $(this).val();
    $.ajax({
      url:"{{ url('principal/transaction/getStd') }}",
      type : "POST",
      data:{class_id:class_id},
      success: function(data){
        $('#SECTION').html(data);
      }
    });
})

      //editschool by ajax
      $('.submitForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitBtn').html('Sending..');
      
      $.ajax({
          url: "{{ url('principal/transaction/add')}}",
          type: 'post',
          data: formdata,
          processData: false,
          contentType: false,
          success: function(data){
            $('#submitBtn').html('Save');
            swal("Good job!", data.success, "success");
            $('#studentModal').modal('hide');
            $('#teacherModal').modal('hide');
            $('#stuffModal').modal('hide');
            $('#otherModal').modal('hide');
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
