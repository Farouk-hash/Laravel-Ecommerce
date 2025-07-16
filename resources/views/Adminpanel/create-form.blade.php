@props(['items_table_title'=>$items_table_title, 'description'=>$description,'categories_for_products_create_form'=>null])
@php 
    $routing_for_get_details = $items_table_title == 'Products' ? route('admin.products.store') : route('admin.categories.store') ;
@endphp

<x-adminpanel-app>

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> {{$items_table_title}} Form</h1>
      <p>{{$description}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item">Forms</li>
      <li class="breadcrumb-item"><a href="#">{{$items_table_title}} Forms</a></li>
    </ul>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <form action="{{$routing_for_get_details}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <label class="control-label">Name</label>
              <input required class="form-control @error('name') is-invalid @enderror" name="name" type="text" placeholder="Enter name" value="{{ old('name') }}">
              @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label class="control-label">Description</label>
              <textarea required class="form-control @error('description') is-invalid @enderror" rows="4" name="description" placeholder="Enter description">{{ old('description') }}</textarea>
              @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            @if($items_table_title == 'Products')
              <div class="form-group">
                <label class="control-label">Quantity</label>
                <input required class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" type="number" placeholder="Enter quantity" min="1" step="1">
                
              </div>

              <div class="form-group">
                <label class="control-label">Price</label>
                <input required class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" type="number" placeholder="Enter price" min="0.01" step="0.01">
                
              </div>

              <div class="form-group">
                <label class="control-label">Category</label>
                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                  <option value="">Select category</option>
                  @foreach ($categories_for_products_create_form as $category )
                      <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                          {{ $category->name }}
                      </option>
                  @endforeach
                </select>
               
              </div>
            @endif

            <div class="form-group">
              <label class="control-label">Cover image</label>
              <input required class="form-control @error('cover_image') is-invalid @enderror" type="file" name="cover_image">
              <small class="text-muted">Select one cover image</small>
              @error('cover_image')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            @if($items_table_title == 'Products')
              <div class="form-group">
                <label class="control-label">Gallery Images</label>
                <input required class="form-control @error('gallery_images') is-invalid @enderror" type="file" name="gallery_images[]" multiple>
                <small class="text-muted">You can select multiple images</small>
               
              </div>
            @endif

            <div class="tile-footer">
              <button class="btn btn-primary" type="submit">
                <i class="fa fa-fw fa-lg fa-check-circle"></i>Create
              </button>&nbsp;&nbsp;&nbsp;
              <a class="btn btn-secondary" href="#">
                <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel
              </a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</main>

</x-adminpanel-app>
