@extends('stuff/layout')
@section('title','Notice')
@section('content')
<div class="container_fluid">
{{-- breadcrumb start  --}}
<div class="col-xm-12">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a  href="{{url('stuff/dashboard')}}">Home</a>
      <li class="breadcrumb-item active"><a href="">Notice</a></li>
    </ol>
  </nav>
</div>
{{-- breadcrumb end  --}}
  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>Notice</h3>
    </div>

  </div>
  <div class="table-responsive">
  <table class="table table-bordered" id="dataTable">
      <thead>
        <tr>
          <th scope="col" style="width: 5px;font-weight:700">#</th>
          <th scope="col">Image</th>
          <th scope="col">Title</th>
          <th scope="col">Details</th>
          <th scope="col">Download</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <!-- {{--  modal start  --}} -->



 </div>

@endsection
@section('js')

<script>
  $(function() {
        $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('stuff/notice') }}",
        columns: [
                 { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                 { data: 'image', name: 'image' },
                 { data: 'title', name: 'title' },
                 { data: 'details', name: 'details' },
                 { data: 'download', name: 'download' },
              ]
     });
  });





  </script>  
@endsection
