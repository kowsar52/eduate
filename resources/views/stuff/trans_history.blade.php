@extends('stuff/layout')
@section('title','Transaction History')
@section('content')
<div class="container_fluid" style="box-shadow: -3px 5px 5px 5px #e8e8e8;margin:10px">
  {{-- breadcrumb start  --}}
  <div class="col-xm-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a  href="{{url('principal/dashboard')}}">Home</a>
        <li class="breadcrumb-item active"><a href="">Transaction</a></li>
      </ol>
    </nav>
    
  </div>
  {{-- breadcrumb end  --}}

  <div class="row mb-2">


  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="transTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">#</th>
          <th scope="col">Transaction Name</th>
          <th scope="col">Amount (taka)</th>
          <th scope="col">Payment Method</th>
          <th scope="col">Create Date</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
 

 </div>

@endsection
@section('js')

<script>
  $(function() {
        $('#transTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('stuff/transaction') }}",
        columns: [
                 { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                 { data: 'transaction_name', name: 'transaction_name' },
                 { data: 'amount', name: 'amount' },
                 { data: 'payment_method', name: 'payment_method' },
                 { data: 'create_date', name: 'create_date' },
              ]
     });
  });


  </script>  
@endsection
