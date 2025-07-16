@props(['item'=>$item, 'items_table_title'=>$items_table_title,'item_images'=>null ,'product_txt_review'=>null, 'description'=>$description])

@php
    $routing_for_show_tranlsations = $items_table_title == 'Products' ? 
    'admin.products.show-translations' : 'admin.categories.show-translations';
@endphp

<x-adminpanel-app>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-info-circle"></i> {{$items_table_title}} Details</h1>
      <p>{{$description}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item">Details</li>
      <li class="breadcrumb-item"><a href="#">{{$items_table_title}} Info</a></li>
    </ul>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          {{-- Start of details display --}}
          <div class="form-group">
            <label class="control-label">Name</label>
            <input class="form-control" type="text" value="{{ $item->name }}" disabled>
          </div>

          <div class="form-group">
            <label class="control-label">Description</label>
            <textarea class="form-control" rows="4" disabled>{{ $item->description }}</textarea>
          </div>

          @if($items_table_title == 'Products')
            <div class="form-group">
              <label class="control-label">Quantity</label>
              <input class="form-control" type="number" value="{{ $item->quantity }}" disabled>
            </div>

            <div class="form-group">
              <label class="control-label">Price</label>
              <input class="form-control" type="text" value="{{ number_format($item->price, 2) }}" disabled>
            </div>

            <div class="form-group">
              <label class="control-label">Category</label>
              <input class="form-control" type="text" value="{{ $item->category->name ?? 'N/A' }}" disabled>
            </div>

            <div class="form-group">
                
                <label class="control-label">Product Reviews</label>
                @forelse($product_txt_review as $index => $review)
                    <div class="card mb-3 p-3">
                        <strong>#{{ $index }}</strong>
                        <div class="row">
                            <!-- Pros Column -->
                            <div class="col-md-6">
                                <h6 class="text-success">Pros</h6>
                                <div class="border rounded p-2 bg-light">
                                    {{$review->bros}}
                                </div>
                            </div>

                            <!-- Cons Column -->
                            <div class="col-md-6">
                                <h6 class="text-danger">Cons</h6>
                                <div class="border rounded p-2 bg-light">
                                    {{$review->cons}}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty 
                     <div class="alert alert-info mt-1">
                        No reviews available for this product.
                    </div>
                @endforelse

            </div>


          @endif

          <div class="form-group">
            <label class="control-label">Cover Image</label><br>
            @if($item->file_object_key)
                <img src="{{Illuminate\Support\Facades\Storage::url($item->file_object_key)}}" alt="Cover Image" style="max-height: 200px;" class="img-thumbnail">

              @else
                <p class="text-muted">No cover image uploaded.</p>
            @endif
          </div>

          @if($items_table_title == 'Products' && !empty($item_images))
            <div class="form-group">
              <label class="control-label">Gallery Images</label><br>
              <div class="d-flex flex-wrap gap-3">
                @foreach($item_images as $image)
                  <img src="{{Illuminate\Support\Facades\Storage::url($image->file_object_key)}}" class="img-thumbnail" style="max-height: 150px;">
                @endforeach
              </div>
            </div>
          @endif

          <div class="tile-footer">
            <a class="btn btn-secondary" href="{{ url()->previous() }}">
              <i class="fa fa-fw fa-lg fa-arrow-left"></i>Back
            </a>
            
            <a class="btn btn-primary" href="{{route( $routing_for_show_tranlsations ,$item->id)}}">
                <i class="fa fa-fw fa-globe"></i> Translations
            </a>

          </div>
          {{-- End of details display --}}
        </div>
      </div>
    </div>
  </div>
</main>
</x-adminpanel-app>
