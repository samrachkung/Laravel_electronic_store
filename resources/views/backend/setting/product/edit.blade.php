@extends('backend.layout.master')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Product Form</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Product</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
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
                        <h3 class="card-title">Edit Product</h3>
                    </div>

                    <form action="{{url('admin/product/'.$products->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Product Name <code class="text-danger">*</code></label>
                                <input type="text" class="form-control" value="{{$products->name}}" name="name" placeholder="Enter Product Name">
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Category <code class="text-danger">*</code></label>
                                <select class="form-control" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{ $products->category_id == $category->id ? 'selected' : '' }}>
                                            {{$category->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Brand <code class="text-danger">*</code></label>
                                <select class="form-control" name="brand_id">
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}" {{ $products->brand_id == $brand->id ? 'selected' : '' }}>
                                            {{$brand->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Slug <code class="text-danger">*</code></label>
                                <input type="text" class="form-control" value="{{$products->slug}}" name="slug" placeholder="Enter Product Slug">
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
                                <label>Description</label>
                                <textarea class="form-control" name="description" placeholder="Enter Product Description">{{$products->description}}</textarea>
                                @error('description')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Price <code class="text-danger">*</code></label>
                                <input type="number" step="0.01" class="form-control" value="{{$products->price}}" name="price" placeholder="Enter Product Price">
                                @error('price')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Quantity <code class="text-danger">*</code></label>
                                <input type="number" class="form-control" value="{{$products->quantity}}" name="quantity" placeholder="Enter Product Quantity">
                                @error('quantity')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Is Active</label>
                                <select class="form-control" name="is_active">
                                    <option value="1" {{ $products->is_active == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $products->is_active == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                @error('is_active')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Is Featured</label>
                                <select class="form-control" name="is_featured">
                                    <option value="1" {{ $products->is_featured == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $products->is_featured == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                @error('is_featured')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>In Stock</label>
                                <select class="form-control" name="in_stock">
                                    <option value="1" {{ $products->in_stock == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $products->in_stock == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                @error('in_stock')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>On Sale</label>
                                <select class="form-control" name="on_sale">
                                    <option value="1" {{ $products->on_sale == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $products->on_sale == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                @error('on_sale')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
