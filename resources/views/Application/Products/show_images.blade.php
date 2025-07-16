@props(['product_images' , 'product_id'])

<x-app
    :title="'Products images'" 
    :show_bread_crump="true"
    :breadcumptitle="'Products images'"
    :breadcumpdescription="'Show Products Images'"
>	
        <div class="product-section mt-150 mb-150">
                <div class="container">
                    
                    <div class="row product-lists">

                        {{-- Upload Image Card --}}
                        <div class="col-lg-4 col-md-6 text-center">
                            <form action="{{route('products.upload-gallery-images' , [
                            'product_id'=> $product_images[0]->product_id ?? $product_id
                            ])}}" 
                                method="POST" enctype="multipart/form-data" class="single-product-item" style="border: 2px dashed #ccc; padding: 20px; height: 300px;">
                                @csrf
                                <label for="image-upload" style="cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                                    <i class="fas fa-plus-circle" style="font-size: 40px; color: #28a745;"></i>
                                    <p style="margin-top: 10px;">Upload Images</p>
                                    <input id="image-upload" type="file" name="gallery_image[]" multiple  style="display: none;" 
                                    required onchange="this.form.submit()">
                                </label>
                            </form>
                        </div>


                        @foreach($product_images as $product_image_info) 
                        <div class="col-lg-4 col-md-6 text-center">

                            <div class="single-product-item">
                                <div class="product-image">
                                    <a href="{{route('products.remove-product-image-gallery' , 
                                    $product_image_info->id)}}" 
                                    style="
                                            position: absolute;
                                            top: 10px;
                                            left: 30px;
                                            color: red;
                                            font-size: 20px;
                                            padding: 5px;
                                            z-index: 2;
                                        "
                                    title="Delete image">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <a href="{{route('product-details' , $product_image_info->product_id)}}">\
                                        <img style="height: 200px;width:200px;" 
                                        src="{{Illuminate\Support\Facades\Storage::url($product_image_info->file_object_key)}}" 
                                        alt=""></a>
                                </div>
                            </div>
                        </div>
                        
                        @endforeach 
                    </div>

                </div>
        </div>

</x-app>


