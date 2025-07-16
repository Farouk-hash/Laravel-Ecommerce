@props(['items'=>$items, 'items_table_title'=>$items_table_title])

@php
    $routing_for_show_tranlsations = $items_table_title == 'Products' ? 
    'admin.products.show-translations' : 'admin.categories.show-translations';
@endphp

<x-adminpanel-app>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-info-circle"></i> {{$items_table_title}} Details</h1>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
            
          <div class="form-group">
            @if($items->isEmpty())
                <div class="alert alert-info mt-1">
                    No translation available for this item.
                </div>
            @else
                <div class="card mb-3 p-3">
                    {{-- Header Row --}}
                    <div class="row font-weight-bold text-primary mb-2">
                        <div class="col-md-4">
                            <h6 class="text-success">Name</h6>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-danger">Description</h6>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-danger">Language</h6>
                        </div>
                    </div>

            {{-- Data Rows --}}
            @foreach($items as $index => $item)
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="border rounded p-2 bg-light">
                            {{ $item->name }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-2 bg-light">
                            {{ $item->description }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-2 bg-light">
                            {{ $item->languages->name }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>




        

         

          <div class="tile-footer">
            <a class="btn btn-secondary" href="{{ url()->previous() }}">
              <i class="fa fa-fw fa-lg fa-arrow-left"></i>Back
            </a>
            
          </div>
          {{-- End of details display --}}
        </div>
      </div>
    </div>
  </div>
</main>
</x-adminpanel-app>
