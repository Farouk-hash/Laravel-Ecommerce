<x-app
    :title="'Products Form'" 
    :show_bread_crump="true"
    :breadcumptitle="'Update Form'"
    :breadcumpdescription="'Modify Product'"
>	

	<!-- products -->
	<div class="product-section mt-150 mb-150">
		<div class="container">
            <div class="contact-form">
                {{-- Showing-Error --}}
                <form method="POST" action="{{route('products.edit' , [$product->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <p>
                        <input type="text" style="width: 100%;" placeholder="Name" name="name" id="name" value="{{$product->name}}">
                    </p>
                    @error('name')
                        {{$message}}
                    @enderror
                    <p style="display: flex;">
                        <input type="number" min="0" step="0.01"
                        style="width: 50%;" class="mr-2" 
                        placeholder="Price" name="price" id="price" value="{{$product->price}}" 
                        >
                        @error('price')
                            {{$message}}
                        @enderror
                        <input type="number" min="0"style="width: 50%;" 
                        placeholder="Quantity" name="quantity" id="quantity"
                        value="{{$product->quantity}}"
                        >
                        @error('quantity')
                        {{$message}}
                        @enderror
                    </p>
                    <select name="category_id" id="category_id" style="width: 100%; padding: 12px; margin-bottom: 15px;">
                        <option value="">— Select Category —</option>
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ $product->category_id == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                        @error('category_id')
                        {{$message}}
                        @enderror
                    </select>
                    <p><textarea name="description" id="description" cols="30" rows="2" placeholder="description">{{$product->description}}</textarea></p>
                    <p>
                        <input type="file" name="image" accept="image/jpeg, image/png, image/webp"  >
                        <img src="{{Illuminate\Support\Facades\Storage::url($product->file_object_key)}}"alt="" style="height: 150px; width:150px;">
                        <small>Only JPEG, PNG, or WEBP formats. Max size: 5MB.</small>
                    </p>
                    
                    @error('description')
                        {{$message}}
                    @enderror
                    <p><input type="submit" value="Update"></p>
                </form>
            </div>
		</div>
	</div>
	<!-- end products -->

<!-- end contact form -->

</x-app>