@extends('admin.layout.admin')
@section('content')  
@section('title', 'Product')

<style>
    .uppy-Dashboard-inner{
        width: 100% !important;
    }
</style>
<link href="https://releases.transloadit.com/uppy/v2.13.0/uppy.min.css" rel="stylesheet" >
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@8/dist/sweetalert2.min.css">
<div class="intro-y flex flex-col sm:flex-row items-center mt-8" >
    <h2 class="text-lg font-medium mr-auto">Edit Product - {{$product->name}}</h2>
</div>
<!-- Product Information -->
<div class="intro-y box p-5 mt-5" id="editProductPage">
   <form @submit.prevent="processForm">
        {{-- @method('put')
        @csrf --}}
        <!-- Product Name Input -->
        
        <div class="mt-3">
            <div class="input-form"> 
                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                    Product Name <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> 
                </label> 
                <input id="validation-form-1" type="text" name="name" class="form-control @error('name') border-danger @enderror" placeholder="Product Name" value="{{old('name') ?? $product->name}}" > 
                <div class="text-danger mt-2">@error('name'){{$message}}@enderror</div>
            </div>
        </div>  
        <!-- Category Input -->
        <div class="mt-3">
            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                Category <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> 
            </label> 
            <select data-placeholder="Select Category" class="tom-select w-full" name="category">
                @if($categories->count())
                    @foreach($categories as $category)
                        @if(old('category') == $category->id || $product->category_id )
                            <option value="{{$product->category_id }}" selected>{{$product->category->name }}</option>
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @else
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option disabled>No Results Found Add a Category first</option>
                @endif
            </select> 
            <div class="text-danger mt-2">@error('category'){{$message}}@enderror</div>
        </div>
        <!-- Brand Input -->
        <div class="mt-3">
            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                Brand <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> 
            </label>
            <select data-placeholder="Select Brand" class="tom-select w-full" name="brand" >
                @if($brand->count())
                    @foreach($brand as $brand)
                        @if(old('brand') == $brand->id || $product->brand_id)
                            <option value="{{$product->brand_id}}" selected> {{$product->brand->name }}</option>
                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                        @else
                            <option value="{{$brand->id}}"">{{$brand->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option disabled>No Results Found Add a Brand first</option>
                @endif
            </select> 
        </div>
        <!--Stock Input -->
        <div class="mt-3">
            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                Stock <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> 
            </label>
            <div class="input-group ">
                <input type="number" class="form-control @error('stock') border-danger @enderror" placeholder="Quantity" aria-describedby="input-group-1" name="stock" value="{{old('stock') ?? $product->stock}}">
                <div id="input-group-1" class="input-group-text ">pcs</div>
            </div>
            <div class="text-danger mt-2">@error('stock'){{$message}}@enderror</div>
        </div>
        <!-- Price Input -->
        <div class="mt-3">
            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                Price <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> 
            </label>
            <div class="input-group">
                <input id="crud-form-4" type="number" class="form-control @error('price') border-danger @enderror" placeholder="Price" aria-describedby="input-group-2" name="price" value="{{old('price') ?? $product->price}}">
                <div id="input-group-2" class="input-group-text">Unit</div>
            </div>
            <div class="text-danger mt-2">@error('price'){{$message}}@enderror</div>
        </div>
        <!-- Weight Input-->
        <div class="mt-3">
            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
             Weight <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> 
            </label>
            <div class="input-group">
                <input id="crud-form-4" type="number" class="form-control @error('weight') border-danger @enderror" placeholder="Weight" aria-describedby="input-group-2" name="weight" value="{{old('weight')  ?? $product->weight}}">
                <div id="input-group-2" class="input-group-text">grams</div>
            </div>
            <div class="text-danger mt-2">@error('weight'){{$message}}@enderror</div>
        </div>
        <!-- Status Input -->
        <div class="mt-3">
            <label>Active Status</label>
            <div class="form-switch mt-2">
                <input type="checkbox" class="form-check-input" name="status" id="status" value="1" {{old('status') || $product->status == 1 ? 'checked' : ''}} >
            </div>
            <div class="text-danger mt-2">@error('status'){{$message}}@enderror</div>
        </div>
        <!-- Description Input -->
        <div class="mt-3">
            <label>Product Description</label>
            <div class="mt-2">
                <textarea id="editor" class="editor" name="description" >{{old('description') ?? $product->description}}</textarea>
            </div>
            <div class="text-danger mt-2">@error('description'){{$message}}@enderror</div>
        </div>
        <div class="mt-3">
            <div id="drag-drop-area"></div>
            <div class="text-danger mt-2"></div>
        </div>
        <div class="text-right mt-5">
            <a href="{{Route('product.index')}}"><button type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</button></a>
            <button type="submit" class="btn btn-primary w-24 mt-3">Edit</button>
        </div>
    </form>
</div>
       
   

      

<script src="https://releases.transloadit.com/uppy/v2.13.0/uppy.min.js"></script>
<script src="https://unpkg.com/vue@3"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const {createApp} = Vue
    const editProductPage = createApp({
        data(){
            return{
                uppy:null,
                images:JSON.parse(`@json($images)`),
                form:{
                    UPDATE_PRODUCT_URL: "{{Route('product.update',$product->id)}}",
                    TOKEN: "{{csrf_token()}}",
                    errors:{
                        name:"",
                        description:"",
                        category:"",
                        brand:"",
                        stock:"",
                        price:"",
                        weight:"",
                        images:""
                    }
                }
            }
        },
        mounted(){
            this.uppy = new Uppy.Core()
             .use(Uppy.Dashboard, {
               inline: true,
               target: '#drag-drop-area',
               height:250,
               hideUploadButton: true,
               locale:{
                 strings:{
                     dropPasteFiles: 'Drop product images or %{browseFiles}',
                     browseFiles: 'browse from your files'
                 }
               }})
               this.uppy.on('file-removed', this.removeImageListener)
               this.loadImages()
               
        },
        methods:{
            showErrors(errors){
                for(const [key, error] of Object.entries(errors)){
                    this.form.errors[key] = error[0]
                }   
            },
            removeErrors(e){
                const name = e.target.name
                this.form.errors[name] = "";
            },
            loadImages(){
                this.images.forEach(image => {
                    fetch(`/product_images/${image.images}`).then(async(response)=>{
                        const blob = await response.blob()
                        this.uppy.addFile({
                            id: image.id,
                            image: image.images,
                            type: blob.type,
                            data: blob,
                            meta:{
                                isUploaded: true,
                                imageId: image.id
                            }
                        })
                    })  
                });
            },
            async removeImageListener(file, reason){
                
               const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                if(result.isConfirmed){
                       this.deleteImageFromServer(file.meta.imageId)
                }
                else{
                    this.uppy.addFile({
                            id: file.id,
                            image: file.name,
                            type: file.data.type,
                            data: file.data,
                            meta: file.meta
                    })
                }
                    
            },
            processForm(e){
                const formData = new FormData(e.target)
                console.log(this.form.UPDATE_PRODUCT_URL)
                const files = this.uppy.store.state.files;
                
                for(const [key,file] of Object.entries(files)){
                    if(!file.meta.isUploaded){
                        formData.append('images[]', file.data, file.data.name)
                    }
                }
                formData.delete('description')
                formData.append('description', document.querySelector(".ck-content").innerHTML);
                this.submitUpdates(formData)
            },
            async submitUpdates(formData){
                    formData.append("_method", 'PUT')
                    const request = await fetch(this.form.UPDATE_PRODUCT_URL,{  
                    method:"POST",
                    credentials: "same-origin",
                    headers: { "X-CSRF-Token": this.form.TOKEN},
                    body:formData
                    })
                    if(!request.ok){
                     
                    }  
          },
          async deleteImageFromServer(id){
                    const request = await fetch(`/productimage/${id}`,{  
                    method:"DELETE",
                    credentials: "same-origin",
                    headers: { "X-CSRF-Token": this.form.TOKEN},
                    })
          }
          
        }
    }).mount("#editProductPage")
</script>
<script src="{{asset('dist/js/ckeditor-classic.js')}}"></script>
@endsection