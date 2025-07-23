@props(['products'])

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>


<x-app
	:title="__('index.products')" 
    :show_bread_crump="true"
	:breadcumptitle="__('index.products')"
    :breadcumpdescription="'Show Products'"
>	

<div class="container mt-5">
    <x-table-toggle/>

    <div class="table-responsive">
        <table id="myTable" class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>{{__('index.products')}}</th>
                    <th>{{__('index.description')}}</th>
                    <th>{{__('index.quantity')}}</th>
                    <th>{{__('index.price')}}</th>
                    <th>{{__('index.created_at')}}</th>
                    <th>{{__('index.actions')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ \Illuminate\Support\Str::words($product->description, 3, '...') }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ \Carbon\Carbon::parse($product->created_at)->toDateString() }}</td>

                        <td style="display: flex; justify-content: center; align-items: center; gap: 5px;">
                           
                            @if (optional(Auth::user())->role === 'admin')
                             <!-- Remove Button -->
                            <form
                                action="{{ route('products.delete', $product->id) }}"
                                method="POST"
                                style="margin: 0;"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1" style="width: 100px;">
                                    <i class="fas fa-trash"></i>
                                    <span class="small">{{trans('index.remove')}}</span>
                                </button>
                            </form>
                            
                            <!-- Edit Button -->
                            <a
                                href="{{ route('products.edit-form', $product->id) }}"
                                class="btn btn-primary btn-sm d-flex align-items-center gap-1"
                                role="button"
                                style="width: 100px; text-align: center;"
                            >
                                <i class="fas fa-edit"></i>
                                <span class="small">{{trans('index.edit')}}</span>
                            </a>
                            
                            <a
                                                        href="{{ route('products.show_images', $product->id) }}"
                                                        class="btn btn-success btn-sm d-flex align-items-center gap-1"
                                                        role="button"
                                                        style="width: 100px; text-align: center;"
                                                    >
                                                        <i class="fas fa-image"></i>
                                                        <span class="small">{{trans('index.images')}}</span>
                            </a>
                            @endif 

                            <!-- Show Button -->
                            <a
                                href="{{ route('product-details', $product->id) }}"
                                class="btn btn-success btn-sm d-flex align-items-center gap-1"
                                role="button"
                                style="width: 100px; text-align: center;"
                            >
                                <i class="fas fa-eye"></i>
                                <span class="small">{{trans('index.show')}}</span>
                            </a>

                        </td>

                    </tr>   
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-app>


<script>
    let table = new DataTable('#myTable', {
    responsive: true ,
    pageLength: 5,
    lengthMenu: [5, 10, 25, 50, 100] ,
    columnDefs: [{ orderable: false, targets: [5] }]
    });
    $(document).ready(function() {
        $('#myTable').DataTable({
            responsive: true
        });
    });
   
</script>
