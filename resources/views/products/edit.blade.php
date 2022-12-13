@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-9"><h3>Edit Product Details</h3></div>

        <form method="POST" action="{{route('products.update', [$product])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="product_name" class="form-label">Product Name</label>
              <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ $product->name }}">
            </div>
            @error('product_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3">
              <label for="product_description" class="form-label">Product Description</label>
              <textarea class="form-control @error('product_description') is-invalid @enderror" id="product_description" name="product_description" rows="3" >{{ $product->description}}</textarea>
            </div>
            @error('product_description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3">
                <label for="product_quantity" class="form-label">Stock Quantity</label>
                <input type="number" class="form-control @error('product_quantity') is-invalid @enderror" min="0" id="product_quantity" name="product_quantity" value="{{ $product->quantity}}">
            </div>
            @error('product_quantity')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3">
                <label for="product_price" class="form-label">Price (RM)</label>
                <input type="number" class="form-control @error('product_price') is-invalid @enderror" id="product_price" name="product_price" value="{{ $product->price }}">
            </div>
            @error('product_price')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
           
            <h5>Product Images</h5>
            
            @if ($product->getMedia('product-images')->count() > 0)
            <div class="row mb-4">
                @foreach ($product->getMedia('product-images') as $image)
                
                    <div class="card" style="width: 18rem;">
                       {{$image}}
                    </div>
                @endforeach
            </div> 
            
            @else
                <div class="card" style="width: 18rem;">
                    <img src="{{asset('/images/default-image.png')}}" alt="Image"/>
                </div>
            @endif

            <div class="form-group">
                <label for="document">Upload Product Image  <small>(maximum 5 images)</small></label>
                <div class="needsclick dropzone" id="document-dropzone">
        
                </div>
            </div>
            
         
            <button type="submit" class="btn btn-primary mt-2">Update Product</button>
        </form>
        
    </div>
   
</div>


<script>
  var uploadedDocumentMap = {}
  Dropzone.options.documentDropzone = {
    url: '{{ route('products.storeMedia') }}',
    maxFilesize: 2, // MB
   
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
      uploadedDocumentMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedDocumentMap[file.name]
      }
      $('form').find('input[name="document[]"][value="' + name + '"]').remove()
    },
    init: function () {
      @if(isset($project) && $project->document)
        var files =
          {!! json_encode($project->document) !!}
        for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
        }
      @endif
    }
  }
</script>


@endsection
