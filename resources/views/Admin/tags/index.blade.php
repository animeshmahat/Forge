@extends('admin.layouts.app')

@section('title', 'Tags')

@section('css')
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Blog Tags</h1>

<a href="{{ route('admin.tags.create') }}" class="btn btn-sm btn-success mb-2"><i class="fa fa-plus"></i> Add {{$_panel}}</a>

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
        <h6 class="m-0 font-weight-bold text-primary">{{$_panel}} Table</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S.N.</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if(isset($data['row']) && count($data['row']) != 0)
                    @foreach($data['row'] as $key=>$row)
                    <tr>
                        <td>{{ $key+1 }}.</td>
                        <td>{{ $row->name }}</td>
                        <td>

                            <a href="{{ route('admin.tags.edit', ['id' => $row->id]) }}" class="btn btn-warning btn-sm m-1"><i class="fa fa-pen"></i>&nbsp;Edit</a>
                            <a href="{{ route('admin.tags.delete', ['id' => $row->id]) }}" class="btn btn-danger btn-sm m-1" onclick="return confirm('Permanently delete this record?')"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</a>

                        </td>
                    </tr>
                    @endforeach
                    @elseif(count($data['row']) == 0)
                    <h3>No records found.</h3>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection