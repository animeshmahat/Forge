@extends('admin.layouts.app')

@section('title', 'Blogs')

@section('css')
<style>
    #thumbnail {
        width: 90px;
        height: 60px;
        object-fit: contain;
        border: 1px solid #c1c1c1;
        border-radius: 5px;
    }
</style>
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Blog Posts</h1>

<a href="{{ route('admin.post.create') }}" class="btn btn-sm btn-success mb-2"><i class="fa fa-plus"></i> Add {{$_panel}}</a>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('update_success'))
<div class="alert alert-primary alert-dismissible fade show" role="alert">
    {{ session('update_success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('delete_success'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('delete_success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Category Table</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Thumbnail</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Thumbnail</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if(isset($data['row']) && count($data['row']) != 0)
                    @foreach($data['row'] as $key=>$row)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $row->title }}</td>
                        <td>{{ $row->category->name }}</td>
                        <td>
                            <img src="{{ asset('/uploads/post/' . $row->thumbnail) }}" alt="thumbnail" id="thumbnail">
                        </td>
                        <td>{{ $row->views }}</td>
                        <td>
                            @if($row->status == '1')
                            <span class="badge rounded-pill badge-success">Active</span>
                            @elseif($row->status == '0')
                            <span class="badge rounded-pill badge-danger">InActive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.post.view', ['id' => $row->id]) }}" class="btn btn-primary btn-sm m-1"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</a>
                            <a href="{{ route('admin.post.edit', ['id' => $row->id]) }}" class="btn btn-warning btn-sm m-1"><i class="fa fa-pen"></i>&nbsp;Edit</a>
                            <a href="{{ route('admin.post.delete', ['id' => $row->id]) }}" class="btn btn-danger btn-sm m-1" onclick="return confirm('Permanently delete this record?')"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assets/admin/js/datatables-simple-demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
@endsection