@extends('admin.layout.admin')
@section('content')  
@section('title', 'Add Product')
<h2 class="intro-y text-lg font-medium mt-10">Add Product</h2>

@if($errors->any())
 <div class="alert alert-danger-soft show mb-2 mt-5 intro-y" role="alert">
     <div class="flex items-center">
         <div class="font-medium text-lg">Opps Something went wrong</div>
     </div>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
 </div>
@endif
@if($errors->any())
    <x-Notification.InvalidNotification title="Product Insert Failed" message="Something is wrong with your input"/>
@endif
<style>
    .uppy-Dashboard-inner{
        width: 100% !important;
    }
</style>
<link href="https://releases.transloadit.com/uppy/v2.13.0/uppy.min.css" rel="stylesheet" >
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<div class="grid grid-cols-12 gap-6 mt-5" id="CreateProductPage">
    <div class="intro-y col-span-12 lg:col-span-12" >
        <div class="intro-y box p-5">
        <form method="POST" enctype="multipart/form-data" @submit.prevent="processForm">
            @csrf
            <div>
                <div class="input-form"> 
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                        Product Name <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> 
                    </label> 
                    <input id="validation-form-1" type="text" name="name" :class="form.errors['name'].length > 0 ? 'form-control border-danger': 'form-control'" placeholder="Product Name" value="{{old('name')}}" @input="removeErrors" > 
                    <div class="text-danger mt-2">@{{form.errors["name"]}}</div>
                </div>
            </div>
            <div class="mt-3">
                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                    Category <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> 
                </label> 
              
                <select data-placeholder="Select Category" class="tom-select w-full" name="category" @input="removeErrors">
                    
                @if($categories->count())
                    <option selected> Select category</option>
                    @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                @else
                <option disabled>No Results Found Add a Category first</option>
                @endif
                </select> 
                <div class="text-danger mt-2">@{{form.errors["category"]}}</div>
            </div>

             <div class="mt-3">
                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                    Brand <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> 
                </label>
                
                <select data-placeholder="Select Brand" class="tom-select w-full" name="brand" @input="removeErrors" >
                @if($brand->count())
                    <option selected> Select brand</option>
                    @foreach($brand as $brand)
                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                    @endforeach
                @else
                    <option disabled>No Results Found Add a Brand first</option>
                @endif
                </select>      
                <div class="text-danger mt-2">@{{form.errors["brand"]}}</div>
            </div>
        
            <div class="mt-3">
                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                    Stock <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> 
                </label>
                <div class="input-group ">
                    <input id="crud-form-3" type="number" :class="form.errors['stock'].length > 0 ? 'form-control border-danger': 'form-control'" placeholder="Quantity" aria-describedby="input-group-1" name="stock" @input="removeErrors">
                    <div id="input-group-1" class="input-group-text ">pcs</div>
                    
                </div><div class="text-danger mt-2">@{{form.errors["stock"]}}</div>
            </div>
            
            <div class="mt-3">
                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                    Price <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> 
                </label>
                <div class="input-group">
                    <input id="crud-form-4" type="number" :class="form.errors['price'].length > 0 ? 'form-control border-danger': 'form-control'" placeholder="Price" aria-describedby="input-group-2" name="price" @input="removeErrors" >
                    <div id="input-group-2" class="input-group-text">
                        Unit
                    </div>
                </div>
                <div class="text-danger mt-2">@{{form.errors["price"]}}</div>
            </div>

            <div class="mt-3">
                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                    Weight <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> 
                </label>
                <div class="input-group">
                    <input id="crud-form-4" type="number" :class="form.errors['weight'].length > 0 ? 'form-control border-danger': 'form-control'" placeholder="Weight" aria-describedby="input-group-2" name="weight" @input="removeErrors">
                    <div id="input-group-2" class="input-group-text">
                        grams
                    </div>
                </div>
                <div class="text-danger mt-2">@{{form.errors["weight"]}}</div>
             </div>

            <div class="mt-3">
                <label>Active Status</label>
                <div class="form-switch mt-2">
                    <input type="checkbox" class="form-check-input" name="status" id="status" >
                </div>
                <div class="text-danger mt-2">@{{form.errors["status"]}}</div>
            </div>
            
            <div class="mt-3">
                <label>Description</label>
                <div class="mt-2">
                    <textarea id="editor" class="editor" name="description"></textarea>
                </div>
                <div class="text-danger mt-2">@{{form.errors["description"]}}</div>
            </div>
            <div class="mt-3">
                <div id="drag-drop-area"></div>
                <div class="text-danger mt-2">@{{form.errors["images"]}}</div>
            </div>
            <div class="text-right mt-5">
                <a href="{{Route('product.index')}}"><button type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</button></a>
                <button type="submit" class="btn btn-primary w-24 mt-3">Save</button>
            </div>
        </form>
        
        </div>
    </div>
</div>
<script src="https://releases.transloadit.com/uppy/v2.13.0/uppy.min.js"></script>
<script src="https://unpkg.com/vue@3"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>

    const {createApp} = Vue
    const createProductPage =  createApp({
         data(){
             return{
                uppy:null,
                form:{
                    CREATE_PRODUCT_URL: "{{Route('product.store')}}",
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
               }
               
             })
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
            processForm(e){
                const formData = new FormData(e.target)
                const files = this.uppy.store.state.files;
                for(const [key,file] of Object.entries(files)){
                    formData.append('images[]', file.data, file.data.name)
                }
                formData.append('description', document.querySelector(".ck-content").innerHTML);
                this.submitNewProduct(formData)
            },
            async submitNewProduct(formData){
                    const request = await fetch(this.form.CREATE_PRODUCT_URL,{  
                    method:"POST",
                    credentials: "same-origin",
                    headers: { "X-CSRF-Token": this.form.TOKEN},
                    body:formData
                    })
                    if(!request.ok){
                        const response = await request.json()
                        this.showErrors(response)
                        return
                    }  
                    this.showSuccessToast();
          },
          showSuccessToast(){
            //TODO: create a reusable toast.js file
                    Toastify({
                    text: "Product created successfully",
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                    }).showToast();
          }
        }
     }).mount("#CreateProductPage")
     </script>
@endsection
@section('scripts')
<script src="{{asset('dist/js/ckeditor-classic.js')}}"></script>
@endsection