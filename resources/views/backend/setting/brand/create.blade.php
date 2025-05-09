@extends('backend.layout.master')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create brand</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Create brand</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create brand</h3>
                    </div>

                    <form action="{{url('admin/brand')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>brand Name <code class="text-danger">*</code></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter brand Name">
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Slug <code class="text-danger">*</code></label>
                                <input type="text" class="form-control" name="slug" value="{{ old('slug') }}" placeholder="Enter brand Slug">
                                @error('slug')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" name="image">
                                @error('image')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Is Active</label>
                                <select class="form-control" name="is_active">
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('is_active')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
