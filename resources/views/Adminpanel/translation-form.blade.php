@props(['language'=>$language,'item'=>$item ,'description'=>$description,'title'=>$title])
@php
    $routing_for_translation = $title == 'Products' ? 
    route('admin.products.translate') : route('admin.categories.translate') ;

@endphp
<x-adminpanel-app>

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> {{$title}} Translation Form (<span style="color:#17a2b8;">{{$item->name}}</span>)</h1>

      <p>{{$description}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item">Forms</li>
      <li class="breadcrumb-item"><a href="#">{{$title}} Forms</a></li>
    </ul>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <form action="{{$routing_for_translation}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="item_id" value="{{$item->id}}">
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

           
            <div class="form-group">
                <label class="control-label">Languages</label>
                <select class="form-control @error('category_id') is-invalid @enderror" name="language_id">
                  <option value="">Select Language</option>
                  @foreach ($language as $language_item )
                      <option value="{{ $language_item->id }}" {{ old('language_id') == $language_item->id ? 'selected' : '' }}>
                          {{ $language_item->name }}
                      </option>
                  @endforeach
                </select>
               
            </div>

           
          
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
