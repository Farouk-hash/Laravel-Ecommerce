<x-app
    :title="'Products Form'" 
    :show_bread_crump="true"
    :breadcumptitle="'Product Form'"
    :breadcumpdescription="'Create New Product'"
>	
	<!-- products -->
	<div class="product-section mt-150 mb-150">
		<div class="container">
            <div class="contact-form">
                {{-- Showing-Error --}}
                <form method="POST" action="{{route('store-product')}}" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->has('name'))
                        <div style="color: red;">{{ $errors->first('name') }}</div>
                    @endif
                    <p>
                        <input type="text" style="width: 100%;" placeholder="Name" name="name" id="name" value="{{old('name' , $product->name??'')}}">
                    </p>
                    <p style="display: flex;">
                        <input type="number" min="0" style="width: 50%;" class="mr-2" 
                        placeholder="Price" name="price" id="price" value="{{ old('price', $product->price ?? '') }}" 
                        >
                        <input type="number" min="0"style="width: 50%;" 
                        placeholder="Quantity" name="quantity" id="quantity"value="{{ old('qunatity', $product->qunatity ?? '') }}" 
                        >
                    </p>
                    <select name="category_id" id="category_id" style="width: 100%; padding: 12px; margin-bottom: 15px;">
                        <option value="">— Select Category —</option>
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <p><textarea name="description" id="description" cols="30" rows="2" placeholder="description">{{old('description',$product->description??'')}}</textarea></p>
                    
                    <p>
                        <!-- Single image upload -->
                        <label for="image">Upload Main Image:</label><br>
                        <input type="file" name="cover_image" accept="image/jpeg, image/png, image/webp" required>
                        <small>Only JPEG, PNG, or WEBP formats. Max size: 5MB. {{ old('cover_image', $product->image_path ?? '') }}</small>
                    </p>

                    <p>
                        <label for="images">Upload Gallery Images:</label><br>
                        <input type="file" name="images[]" accept="image/jpeg, image/png, image/webp" multiple>
                        <small>You can select multiple images. Formats: JPEG, PNG, WEBP. Max size per image: 5MB.</small><br>
                        @if ($errors->has('images'))
                            <div style="color: red;">{{ $errors->first('images') }}</div>
                        @endif
                        @if ($errors->has('images.*'))
                            @foreach ($errors->get('images.*') as $key => $messages)
                                @foreach ($messages as $message)
                                    <div style="color: red;">{{ $message }}</div>
                                @endforeach
                            @endforeach
                        @endif
                    </p>

                    
                    <p><input type="submit" value="Store"></p>
                </form>
            </div>
		</div>
	</div>
	<!-- end products -->


</x-app>