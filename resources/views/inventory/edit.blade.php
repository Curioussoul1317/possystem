@extends('layouts.app')

@section('content')
 <main class="container-fluid">
         <div class="container breadcrumbs">
            <div class="row justify-content-between" style="font-size: x-large;
               color: #03226a;">
               <div class="col-10">
                  <div class="row justify-content-start">
                     <div class="col-1">
                        <a href="{{ route('inventory.show', $inventory) }}" class="text-decoration-none"><i class="fa-solid fa-backward breadcrumbsicon"></i></a>
                     </div>
                     <div class="col-4 backicon breadcrumbstext">
                        INVENTORY
                     </div>
                  </div>
               </div>
               <div class="col-2"> 
                  
               </div>
            </div>
         </div>
         <!-- ///////////////// -->
   <div class="row justify-content-center" > 
 <div class="col-10">
 <div class="col-12">
<div class="card " style="margin-bottom:150px;   ">
 <div class="card-header listtablehead">
                    EDIT ITEM 
                  </div>
<div class="card-body">

 <form action="{{ route('inventory.update', $inventory) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
  <div class="row">
    <div class="form-group col-md-2">
      <label for="inputEmail4" class="posinputlable">Item Code</label>
      <input type="text" class="form-control posinput" name="item_code" id="item_code"
                                                    value="{{ old('item_code', $inventory->item_code) }}"required  >
    </div>
   <div class="form-group col-md-4">
      <label for="inputState" class="posinputlable">Brand</label>
      <select  name="brand_id" id="brand_id"  class="form-control posinput">
        <option value="">Select Brand</option>
                                                    @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ old('brand_id', $inventory->brand_id) == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                    @endforeach
      </select>
    </div>

   <div class="form-group col-md-4">
      <label for="inputState" class="posinputlable">Categories</label>
      <select name="category_id" id="category_id" class="form-control posinput">
          <option value="">Select Category</option>
             @foreach($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $inventory->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                    @endforeach
      </select>
    </div>
<div class="hr"></div>
<div class="form-group col-md-3">
      <label for="inputEmail4" class="posinputlable">Item Name</label>
      <input type="text" class="form-control posinput" name="name" id="name"
                                                    value="{{ old('name', $inventory->name) }}" required >
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Qty</label> 
               <input type="number"name="stock_quantity" id="stock_quantity"
                                                    value="{{ old('stock_quantity', $inventory->stock_quantity) }}" class="form-control posinput" required>
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Color</label>
      <input type="text" class="form-control posinput" name="colour" id="colour"
                                                    value="{{ old('colour', $inventory->colour) }}"  >
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Volume</label>
      <input type="text" class="form-control posinput"  name="volume" id="volume"
                                                    value="{{ old('volume', $inventory->volume) }}" >
    </div>
<div class="form-group col-md-2">
      <label for="inputState" class="posinputlable">Gender</label>
      <select name="gender" id="gender" class="form-control posinput">
           <option value=" {{ $inventory->gender }}"> {{ $inventory->gender }}
                                                    </option>
            <option value="">Boys</option>
            <option value="">Girls</option>
            <option value="">UniSex</option>
      </select>
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Age</label>
      <input type="text" class="form-control posinput" name="age" id="age"
                                                    value="{{ old('age', $inventory->age) }}"  required >
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Cost</label>
       <input type="number" name="unit_cost" id="unit_cost"
                                                    value="{{ old('unit_cost', $inventory->unit_cost) }}" step="0.01"class="form-control posinput" required> 
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Price</label>
       <input type="number" name="unit_price" id="unit_price"
                                                    value="{{ old('unit_price', $inventory->unit_price) }}" step="0.01" class="form-control posinput" required>
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Discount</label>
      <input type="number" name="discount_percentage" id="discount_percentage"
                                                    value="{{ old('discount_percentage', $inventory->discount_percentage) }}" class="form-control posinput" >
    </div>
<div class="hr"></div>
 <div class="form-group col-md-12">
      <label for="inputEmail4" class="posinputlable">Description</label>
      <textarea class="form-control posinput" rows="3" name="description"
                                id="description">{{ old('description', $inventory->description) }}</textarea> 
    </div>
<div class="form-group col-md-12">
      <label for="inputEmail4" class="posinputlable">Images</label>
     <input type="file" name="images[]" multiple accept="image/*" class="form-control posinput">
                        <p class="text-sm text-gray-500 mt-1">You can select multiple images. The first image will be
                            set as primary.</p>
       <div class="col-lg-12">
                <label class="block text-gray-700 text-sm font-bold mb-2">Current Images</label>
                <div class="row row-deck row-cards">
                    @foreach($inventory->images as $image)
                    <div class="col-sm-6 col-lg-2">
                        <div class="card card-sm">
                            <a href="#" class="d-block"><img
                                    src="{{ asset('storage/' . $image->image_path) }}"
                                    alt="Product image" class="card-img-top"></a>
                            <div class="card-body">
                                <div class="ms-auto">
                                    <button type="button"
                                        onclick="setPrimaryImage({{ $image->id }})"
                                        class="btn btn-primary btn-sm">
                                        {{ $image->is_primary ? 'Primary' : 'Set Primary' }}
                                    </button>
                                    <button type="button" onclick="deleteImage({{ $image->id }})"
                                        class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
    </div>
<div class="form-group col-md-12">
      <label for="inputEmail4" class="posinputlable">BarCode</label>
      <input type="text" class="form-control posinput"   name="barcode" id="barcode"
                                                    value="{{ old('barcode', $inventory->barcode) }}"  autocomplete="off" >
    </div>
    <div class="form-group col-md-10">
       <button type="submit" class="btn btn-primary formbutton"  >SAVE</button>
    </div>
     <div class="form-group col-md-2">
        <a href=" {{ route('inventory.show', $inventory) }}" class="btn btn-secondary formbuttonsecond" data-bs-dismiss="modal">
                            Cancel
                        </a>
    </div>

 
</form>
</div>

 </div>
</div>
 </div>
</div>

<!-- ///////////////// -->

 <script>
function setPrimaryImage(imageId) {
    // Show confirmation
    if (!confirm('Set this as the primary image?')) {
        return;
    }

    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]').content;

    console.log('Setting primary image:', imageId); // Debug log
const primaryImageUrl = "{{ route('inventory.images.primary', ['image' => ':imageId']) }}";


const setPrimaryUrl = primaryImageUrl.replace(':imageId', imageId);
fetch(setPrimaryUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async response => {
            console.log('Response status:', response.status); // Debug log
            const text = await response.text();
            console.log('Raw response:', text); // Debug log

            try {
                const data = JSON.parse(text);
                return data;
            } catch (error) {
                console.error('JSON parse error:', error);
                console.log('Non-JSON response:', text);
                throw new Error('Invalid JSON response');
            }
        })
        .then(data => {
            console.log('Processed data:', data); // Debug log
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error updating primary image');
            }
        })
        .catch(error => {
            console.error('Error details:', error);
            alert('Error updating primary image. Please try again.');
        });
}

function deleteImage(imageId) {
    if (confirm('Are you sure you want to delete this image?')) { 

// Then in your fetch call
const deleteImageUrl = "{{ route('inventory.images.delete', ['image' => ':imageId']) }}";
const deleteUrl = deleteImageUrl.replace(':imageId', imageId);

   fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
    }
}
</script>
 
      </main>
 
@endsection