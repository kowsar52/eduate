@extends('principal/layout')
@section('title','Transaction History')
@section('content')
<div class="container_fluid" style="box-shadow: -3px 5px 5px 5px #e8e8e8;margin:10px">
  {{-- breadcrumb start  --}}
  <div class="col-xm-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
        <li class="breadcrumb-item"><a  href="{{url('principal/transaction')}}">Transaction</a>
        <li class="breadcrumb-item active"><a href="">Transaction History</a></li>
      </ol>
    </nav>
  </div>
  {{-- breadcrumb end  --}}

  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>Transaction History</h3>
    </div>
    <div class="col md-6 ">
      <!-- {{-- button trigar model  --}} -->
      <a target="_blank" href="{{url('principal/transaction')}}" class="btn btn-warning float-right"  >Add New</a>
    </div>
  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="transTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">#</th>
          <th scope="col">Sender ID</th>
          <th scope="col">Receiver ID</th>
          <th scope="col">Sender Type</th>
          <th scope="col">Receiver Type</th>
          <th scope="col">Transaction Type </th>
          <th scope="col">Transaction Name</th>
          <th scope="col">Amount</th>
          <th scope="col">Debit/Credit</th>
          <th scope="col">Payment Method</th>
          <th scope="col">Creat Date</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="mb-3" id="submitForm">
          <div class="form-group">
            <label for="exampleInputEmail1">Transaction Type</label>
            <input type="text"  class="form-control" name="transaction_type" id=""/>
            <input type="hidden"  class="form-control" name="id" id=""/>
            <span class="form-text text-danger error_msg transaction_type"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Transaction Name</label>
            <input type="text"  class="form-control" name="transaction_name" id=""/>
            <span class="form-text text-danger error_msg transaction_name"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Receiver Type</label>
            <input type="text"  class="form-control" name="receiver_type" id=""/>
            <span class="form-text text-danger error_msg receiver_type"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Receiver ID</label>
            <input type="text"  class="form-control" name="receiver_id" id=""/>
            <span class="form-text text-danger error_msg receiver_id"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Amount</label>
            <input type="text"  class="form-control" name="amount" id=""/>
            <span class="form-text text-danger error_msg amount"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Debit/Credit</label>
            <select  class="form-control" name="debit_credit" id="">
                <option value="debit">Debit</option>
                <option value="credit">Credit</option>
            </select>
            <span class="form-text text-danger error_msg debit_credit"></span>
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
        $('#transTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('principal/trasnsaction/history') }}",
        columns: [
                 { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                 { data: 'sender_id', name: 'sender_id' },
                 { data: 'receiver_id', name: 'receiver_id' },
                 { data: 'sender_type', name: 'sender_type' },
                 { data: 'receiver_type', name: 'receiver_type' },
                 { data: 'transaction_type', name: 'transaction_type' },
                 { data: 'transaction_name', name: 'transaction_name' },
                 { data: 'amount', name: 'amount' },
                 { data: 'debit_credit', name: 'debit_credit' },
                 { data: 'payment_method', name: 'payment_method' },
                 { data: 'create_date', name: 'create_date' },
                 { data: 'action', name: 'action' },
              ]
     });
  });

  $('body').on('click','.editBtn',function(){
        $('.error_msg').text('');
        var id = $(this).data('id');
        $.ajax({
          url: "{{ url('principal/transaction/history/editData')}}",
          type: 'post',
          data: {id:id},
          success: function(data){
            $('input[name="id"]').val(data.id);
            $('input[name="transaction_type"]').val(data.transaction_type);
            $('input[name="transaction_name"]').val(data.transaction_name);
            $('input[name="receiver_type"]').val(data.receiver_type);
            $('input[name="receiver_id"]').val(data.receiver_id);
            $('input[name="amount"]').val(data.amount);
            $('select[name="debit_credit"]').val(data.debit_credit);
            $('#addModal').modal('show');

          }
      });
    });


  //save 
  $('#submitForm').on('submit',function(e){
      e.preventDefault();
      var formdata= new FormData(this);
      $('#submitBtn').html('Saving..');
      
      $.ajax({
          url: "{{ url('principal/transaction/history/edit')}}",
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
              $('#transTable').DataTable().ajax.reload();
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

  </script>  
@endsection
