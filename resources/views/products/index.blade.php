@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
    <div class="alert alert-danger" role="alert">
       <p>{{ session('success') }}</p>
    </div>
    @endif
    <div class="row mb-4">
        <div class="col-md-9"><h2>Products Listing</h2></div>
        <div class="col-md-3"><a href="{{route('products.create')}}" class="btn btn-primary mb-2 float-end">Add New Product</a></div>
    </div>
    <table id="products" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price(per unit)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
             <tr> 
                <td>{{$product->name}}</td>
                <td>{{$product->description}}</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->price}}</td>
                <td>
                    <a href="{{route('products.show', [$product])}}" class="btn btn-primary">View</a>
                    <form method="POST" action="{{route('products.destroy', [$product])}}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
             </tr>
            @endforeach
        </tbody>
   
    </table>
</div>

<script>
$(document).ready(function () {
    $('#products').DataTable();
});

</script>
@endsection
