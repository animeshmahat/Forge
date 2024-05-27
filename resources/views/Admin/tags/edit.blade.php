@extends('admin.layouts.app')

@section('css')
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <h2>Edit {{$_panel}}</h2>
        <div class="card mt-3 p-3">
            <form action="{{route('admin.tags.update', ['id' => $data['row']->id] )}}" method="POST" enctype="multipart/form-data">
                @csrf
                {{ method_field('POST') }}
                <div class="mb-4 mt-2">
                    <label for="title" class="form-label"><strong>Tag Name :</strong></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter New Tag Name" value="{{ $data['row']->name }}" autofocus>
                    @error('name')
                    <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                </div>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-sm btn-danger mb-4"><i class="fa fa-ban" aria-hidden="true"></i> CANCEL</a>
                <button type="submit" class="btn btn-sm btn-success mb-4"><i class="fa fa-paper-plane" aria-hidden="true"></i> UPDATE</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection