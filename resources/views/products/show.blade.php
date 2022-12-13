@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9"><h3>Product Details</h3></div>
        <div class="col-md-3" style="display: inline-flex">
            <a href="{{route('products.edit', [$product])}}" class="btn btn-primary">Edit Product</a>
            <form method="POST" action="{{route('products.destroy', [$product])}}">
                @csrf
                @method("DELETE")
                <button type="submit" class="btn btn-danger" >Delete</button>
            </form>
        </div>
    </div>
    <div class="row mb-4">

            <div class="mb-3">
              <label for="product_name" class="form-label">Product Name</label>
              <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->name }}" disabled>
            </div>

            <div class="mb-3">
              <label for="product_description" class="form-label">Product Description</label>
              <textarea class="form-control" id="product_description" name="product_description" rows="3" disabled >{{ $product->description}}</textarea>
            </div>

            <div class="mb-3">
                <label for="product_quantity" class="form-label">Stock Quantity</label>
                <input type="number" class="form-control" min="0" id="product_quantity" name="product_quantity" value="{{ $product->quantity}}" disabled>
            </div>

            <div class="mb-3">
                <label for="product_price" class="form-label">Price (RM)</label>
                <input type="number" class="form-control" id="product_price" name="product_price" value="{{ $product->price }}" disabled>
            </div>
    </div>
    <div class="row mb-4">
        <h3>Product Images</h3>
        
        @if ($product->getMedia('product-images')->count() > 0)
            @foreach ($product->getMedia('product-images') as $image)
                <div class="card" style="width: 18rem;">
                    {{$image}}
                </div>
            @endforeach
        @else
            <div class="card" style="width: 18rem;">
                <img src="{{asset('/images/default-image.png')}}" alt="Image"/>
            </div>
        @endif
    </div>
   
</div>

@endsection
