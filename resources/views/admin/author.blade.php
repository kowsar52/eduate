@extends('admin/layout')
@section('title','Authority')
@section('content')
<div class="container_fluid">
  <div class="row mb-2">
    <div class="col md-6 float-left">
        <h3>All Principals/Authority</h3>
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
          <th scope="col">Authority Name</th>
          <th scope="col">Email</th>
          <th scope="col" style="width: 55px">Created At</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  {{--  modal start  --}}
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
        <form class="mb-3">
          <div class="form-group">
            <label for="exampleInputEmail1">School Name</label>
            <input type="text" class="form-control" name="name"  placeholder="Enter Authority Name">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">School Image</label>
            <input type="file" class="form-control" name="image">
          </div>
          <button type="submit" class="btn btn-warning btn-full text-white" id="submitBtn">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
  {{--  modal end  --}}
 </div>

@endsection
@section('js')

<script>
  $(function() {
        $('#schoolTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('admin/getAuthority') }}",
        columns: [
                 { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                 { data: 'name', name: 'name' },
                 { data: 'email', name: 'email' },
                 { data: 'created_at', name: 'created_at' },
              ]
     });
  });
  </script>  
@endsection