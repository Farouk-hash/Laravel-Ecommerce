@props(['items_table_title'=>$items_table_title , 'items'=>$items])
@php 
    $routing_for_create_form = $items_table_title == 'Products' ? route('admin.products.create-form') : route('admin.categories.create-form') ;
    $routing_for_get_details = $items_table_title == 'Products' ? 'admin.products.get-product-details' : 'admin.categories.get-category-details';
    $routing_for_delete = $items_table_title == 'Products' ? 'admin.products.delete-product' : 'admin.categories.delete-category';
    $rounting_for_tranlsation = $items_table_title == 'Products' ?'admin.products.translation-form' : 'admin.categories.translation-form' ;

@endphp
<x-adminpanel-app>

    <main class="app-content">
        
        
        
        <div class="clearfix"></div>
        <div class="col-md-12">
           @if (session('error'))
                <div class="p-2 my-2 rounded text-danger bg-warning-subtle border border-warning">
                    {{ session('error') }}
                </div>
            @endif

          <div class="tile">
            <h3 class="tile-title"><span style="color:#009688;">{{$items_table_title}}</span> Table</h3>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created_at</th>
                    <th>Updated_at</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{ \Illuminate\Support\Str::limit(strip_tags($item->description), 50) }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('Y-m-d') }}</td>

                        <td style="display: flex; justify-content: center; align-items: center; gap: 8px;">
    
                        {{-- Delete Button --}}
                        <form action="{{route($routing_for_delete , $item->id)}}" method="POST" style="margin: 0;" title="Delete this product">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                            class="btn btn-danger btn-sm d-flex align-items-center gap-1" style="width: 100px;">
                                <i class="fa fa-trash"></i>
                                <span class="small">Remove</span>
                            </button>
                        </form>

                        {{-- Edit Button --}}
                        <a href="{{ route($routing_for_get_details, ['item_id'=>$item->id , 'edit_form'=>true]) }}"
                        class="btn btn-primary btn-sm d-flex align-items-center gap-1"
                        role="button"
                        style="width: 100px; text-align: center;"
                        title="Edit this item">
                            <i class="fa fa-pencil"></i>
                            <span class="small">Edit</span>
                        </a>

                        {{-- Translate Button --}}
                        <a href="{{route($rounting_for_tranlsation , $item->id)}}"
                        class="btn btn-warning btn-sm d-flex align-items-center gap-1"
                        role="button"
                        style="width: 100px; text-align: center;"
                        title="translate this item">
                            <i class="fa fa-book"></i>
                            <span class="small">Translate</span>
                        </a>

                        {{-- Show Button --}}
                        <a href="{{route($routing_for_get_details , $item->id)}}"
                        class="btn btn-success btn-sm d-flex align-items-center gap-1"
                        role="button"
                        style="width: 100px; text-align: center;"
                        title="View product item">
                            <i class="fa fa-eye"></i>
                            <span class="small">Show</span>
                        </a>

                        </td>

                @endforeach
                
                
                </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $items->links('pagination::bootstrap-4') }}
                </div>

            </div>
            
                {{-- create button  --}}
                <div style="display: flex; justify-content: center; margin-top: 5px;">
                    <a href="{{$routing_for_create_form}}"
                        class="btn btn-primary fa fa-fw fa-lg fa-check-circle"
                        role="button"
                        style="width: 120px; text-align: center;"
                        title="Create new item">
                        <span class="small">Create</span>
                    </a>
                </div>

          </div>
        </div>

    </main>
</x-adminpanel-app>
