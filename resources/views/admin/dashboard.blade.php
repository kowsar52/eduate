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
          <th scope="col" style="width: 55px">Status</th>
          <th scope="col" style="width: 55px">Action</th>
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
            <label for="exampleInputEmail1">Authority / Principal</label>
            <select name="author_id"  class="form-control" >
              <option >Select Author/Principal</option>
              @foreach ($authors as $author)   
                <option value="{{$author->id}}">{{$author->name .' ( '.$author->email .' ) '}}</option>
              @endforeach
            </select>
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
        ajax: "{{ url('admin/getSchools') }}",
        columns: [
                 { data: 'school_id', name: 'school_id' },
                 { data: 'image', name: 'image' },
                 { data: 'school_name', name: 'school_name' },
                 { data: 'author', name: 'author' },
                 { data: 'status', name: 'status' },
                 { data: 'action', name: 'action' },
              ]
     });
  });
  </script>  
@endsection