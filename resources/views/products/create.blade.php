@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-9"><h3>Create New Product</h3></div>

        <form method="POST" action="{{route('products.store')}}">
            @csrf

            <div class="mb-3">
              <label for="product_name" class="form-label">Product Name</label>
              <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name') }}">
            </div>
            @error('product_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3">
              <label for="product_description" class="form-label">Product Description</label>
              <textarea class="form-control @error('product_description') is-invalid @enderror" id="product_description" name="product_description" rows="3" >{{ old('product_description')}}</textarea>
            </div>
            @error('product_description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3">
                <label for="product_quantity" class="form-label">Stock Quantity</label>
                <input type="number" class="form-control @error('product_quantity') is-invalid @enderror" min="0" id="product_quantity" name="product_quantity" value="{{ old('product_quantity')}}">
            </div>
            @error('product_quantity')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3">
                <label for="product_price" class="form-label">Price (RM)</label>
                <input type="number" class="form-control @error('product_price') is-invalid @enderror" id="product_price" name="product_price" value="{{ old('product_price') }}">
            </div>
            @error('product_price')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
         
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        
    </div>
   
</div>

@endsection
