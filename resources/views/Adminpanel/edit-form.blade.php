@props(['item' => $item, 'items_table_title' => $items_table_title, 'item_images' => null, 'product_txt_review' => null, 'description' => $description])
@php
    $routing_for_update = $items_table_title == 'Products' ? 'admin.products.update-product' : 'admin.categories.update-categories';
    $routing_for_deleting_images = $items_table_title  == 'Products' ? 'admin.products.delete-image-from-gallery' : 'admin.categories.delete-image-from-gallery';
@endphp
<x-adminpanel-app>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Edit {{ $items_table_title }}</h1>
      <p>{{ $description }}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item">Edit</li>
      <li class="breadcrumb-item"><a href="#">Edit {{ $items_table_title }}</a></li>
    </ul>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-12">
      <form method="POST" action="{{route($routing_for_update,  $item->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="tile">
          <div class="tile-body">

            <div class="form-group">
              <label class="control-label">Name</label>
              <input class="form-control" name="name" type="text" value="{{ old('name', $item->name) }}">
              @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label class="control-label">Description</label>
              <textarea class="form-control" name="description" rows="4">{{ old('description', $item->description) }}</textarea>
            
            </div>

            @if($items_table_title == 'Products')
              <div class="form-group">
                <label class="control-label">Quantity</label>
                <input class="form-control" name="quantity" type="number" value="{{ old('quantity', $item->quantity) }}">
              </div>

              <div class="form-group">
                <label class="control-label">Price</label>
                <input class="form-control" name="price" type="text" value="{{ old('price', $item->price) }}">
              </div>


              <div class="form-group">
                <label class="control-label">Category</label>
                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                  <option value="">Select category</option>
                  @foreach ($categories_for_products as $category )
                      <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                          {{ $category->name }}
                      </option>
                  @endforeach
                </select>
               
              </div>
            @endif

            {{-- Cover Image --}}
            <div class="form-group">
              <label class="control-label">Cover Image</label><br>
              @if($item->file_object_key)
                <div class="position-relative d-inline-block mb-2">
                  <img src="{{ Illuminate\Support\Facades\Storage::url($item->file_object_key) }}" style="max-height: 200px;" class="img-thumbnail">
                </div>
                <br>
              @endif
              <input type="file" class="form-control-file" name="image">
            </div>

            @if($items_table_title == 'Products')
              <div class="form-group">
                <label class="control-label">Gallery Images</label>
                <div class="d-flex flex-wrap gap-3 mb-2" id="gallery-images-container">
                  @foreach($item_images as $image)
                    <div class="position-relative gallery-image-item" data-image-id="{{ $image->id }}">
                      <img src="{{ Illuminate\Support\Facades\Storage::url($image->file_object_key) }}" class="img-thumbnail" style="max-height: 150px;">
                      <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px;" 
                      onclick="deleteGalleryImage({{ $image->id }})">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  @endforeach
                </div>
                
                <div id="gallery-upload-container">
                  <div class="gallery-upload-item mb-2">
                    <input type="file" class="form-control-file" name="gallery_image[]" multiple>
                  </div>
                </div>
                
                <button type="button" class="btn btn-success btn-sm" onclick="addMoreGalleryInput()">
                  <i class="fa fa-plus"></i> Add More Gallery Images
                </button>
              </div>
            @endif

          </div>
          <div class="tile-footer">
            <button class="btn btn-primary" type="submit">
              <i class="fa fa-fw fa-lg fa-check-circle"></i>Save Changes
            </button>
            <a class="btn btn-secondary" href="{{ url()->previous() }}">
              <i class="fa fa-fw fa-lg fa-arrow-left"></i>Back
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
</main>

    <!-- Hidden forms for delete operations -->
    @if($items_table_title == 'Products')
    @foreach($item_images as $image)
        <form id="delete-gallery-form-{{ $image->id }}" method="POST" 
            action="{{route($routing_for_deleting_images , $image->id)}}" style="display: none;">
        @csrf
        @method('DELETE')
        </form>
    @endforeach
    @endif

<script>
    // Delete gallery image function
    function deleteGalleryImage(imageId) {
    if (confirm('Are you sure you want to delete this gallery image?')) {
        document.getElementById('delete-gallery-form-' + imageId).submit();
    }
    }

    // Add more gallery input function
    function addMoreGalleryInput() {
    const container = document.getElementById('gallery-upload-container');
    const newInput = document.createElement('div');
    newInput.className = 'gallery-upload-item mb-2';
    newInput.innerHTML = `
        <div class="d-flex align-items-center">
        <input type="file" class="form-control-file" name="gallery_images[]" multiple>
        <button type="button" class="btn btn-danger btn-sm ml-2" onclick="removeGalleryInput(this)">
            <i class="fa fa-times"></i>
        </button>
        </div>
    `;
    container.appendChild(newInput);
    }

    // Remove gallery input function
    function removeGalleryInput(button) {
    button.closest('.gallery-upload-item').remove();
    }
</script>
</x-adminpanel-app>