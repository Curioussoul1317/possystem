@extends('layouts.app')

@section('content')

 <main class="container-fluid">
         <div class="container breadcrumbs">
            <div class="row justify-content-between" style="font-size: x-large;
               color: #03226a;">
               <div class="col-10">
                  <div class="row justify-content-start">
                     <div class="col-1">
                        <a href="{{ route('home') }}" class="text-decoration-none"><i class="fa-solid fa-backward breadcrumbsicon"></i></a>
                     </div>
                     <div class="col-4 backicon breadcrumbstext">
                        INVENTORY
                     </div>
                  </div>
               </div>
               <div class="col-2"> 
                  <a class="text-decoration-none" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                  <i class="fa-solid fa-square-plus  breadcrumbsicon"></i>
                  </a>
               </div>
            </div>
         </div>
         <!-- ///////////////// -->
   <div class="row justify-content-center" > 
 <div class="col-10 collapse" id="collapseExample">
 <div class="col-12">
<div class="card " style="margin-bottom:150px;   ">
 <div class="card-header listtablehead">
                    NEW ITEM 
                  </div>
<div class="card-body">

<form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
  <div class="row">
    <div class="form-group col-md-2">
      <label for="inputEmail4" class="posinputlable">Item Code</label>
      <input type="text" class="form-control posinput" name="item_code" id="item_code" value="{{ old('item_code') }}" required  >
    </div>
   <div class="form-group col-md-4">
      <label for="inputState" class="posinputlable">Brand</label>
      <select name="brand_id" id="brand_id"  class="form-control posinput">
         <option value="">Select Brand</option>
            @foreach($brands as $brand)
            <option value="{{ $brand->id }}"
                {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
      </select>
    </div>
<div class="hr"></div>
<div class="form-group col-md-3">
      <label for="inputEmail4" class="posinputlable">Item Name</label>
      <input type="text" class="form-control posinput" name="name" id="name" value="{{ old('name') }}"  required >
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Qty</label> 
               <input type="number" name="stock_quantity" id="stock_quantity"
                                        value="{{ old('stock_quantity') }}" class="form-control posinput" required>
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Color</label>
      <input type="text" class="form-control posinput" name="colour" id="colour" value="{{ old('colour') }}"  >
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Volume</label>
      <input type="text" class="form-control posinput"name="volume" id="volume" value="{{ old('volume') }}" >
    </div>
<div class="form-group col-md-2">
      <label for="inputState" class="posinputlable">Gender</label>
      <select name="gender" id="gender" class="form-control posinput">
            <option value="">Select Gender</option>
            <option value="">Boys</option>
            <option value="">Girls</option>
            <option value="">UniSex</option>
      </select>
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Age</label>
      <input type="text" class="form-control posinput"  name="age" id="age" value="{{ old('age') }}" required >
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Cost</label>
       <input type="number" name="unit_cost" id="unit_cost" value="{{ old('unit_cost') }}"
                                        step="0.01" class="form-control posinput" required> 
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Price</label>
       <input type="number" name="unit_price" id="unit_price"
                                        value="{{ old('unit_price') }}" step="0.01" class="form-control posinput" required>
    </div>
<div class="form-group col-md-1">
      <label for="inputEmail4" class="posinputlable">Discount</label>
      <input type="number" name="discount_percentage" id="discount_percentage"
                                        value="{{ old('stock_quantity') }}" class="form-control posinput" >
    </div>
<div class="hr"></div>
 <div class="form-group col-md-12">
      <label for="inputEmail4" class="posinputlable">Description</label>
      <textarea class="form-control posinput" rows="3" name="description"
                                id="description">{{ old('description') }}</textarea> 
    </div>
<div class="form-group col-md-12">
      <label for="inputEmail4" class="posinputlable">Images</label>
     <input type="file" name="images[]" multiple accept="image/*" class="form-control posinput">
                        <p class="text-sm text-gray-500 mt-1">You can select multiple images. The first image will be
                            set as primary.</p>
    </div>
<div class="form-group col-md-12">
      <label for="inputEmail4" class="posinputlable">BarCode</label>
      <input type="text" class="form-control posinput"  name="barcode" id="barcode" value="{{ old('barcode') }}"  autocomplete="off" >
    </div>
    <div class="form-group col-md-12">
       <button type="submit" class="btn btn-primary formbutton"  >SAVE</button>
    </div>
 
 
</form>
</div>

 </div>
</div>
 </div>
</div>

<!-- ///////////////// -->

         <!-- ///////////////// -->
   <div class="row justify-content-center" > 
 <div class="col-10  "  >
 <div class="col-12">
<div class="card " style="margin-bottom:5px;   ">
 <div class="card-header listtablehead">
                  FILTTER 
                  </div>
<div class="card-body">

<form  action="{{ route('inventory.index') }}" method="GET">
  <div class="row">
      
<div class="form-group col-md-3"> 
      <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Search by name, or barcode" class="form-control posinput"  >
    </div>
<div class="form-group col-md-3">  
      <select name="brand" id="brand"  class="form-control posinput">
       <option value="">All Brands</option>
        @foreach($brands as $brand)
        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
            {{ $brand->name }}
        </option>
        @endforeach
      </select>
    </div>
<div class="form-group col-md-2">  
      <select name="category" id="category" class="form-control posinput">
       <option value="">All Categories</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}"
            {{ request('category') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
        @endforeach
    </select>
    </div>
<div class="form-group col-md-2">  
      <select name="stock_status" id="stock_status" class="form-control posinput">
         <option value="">All Stock Status</option>
            <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>
                In Stock
            </option>
            <option value="low_stock"
                {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low
                Stock
            </option>
            <option value="out_of_stock"
                {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                Out
                of Stock</option>
        </select>
    </div>
 

    <div class="form-group col-md-2"> 
       <div class="btn-group mr-2" role="group" aria-label="Second group">
    <button type="submit" class="btn btn-danger ">APPLY</button>
     <a href="{{ route('inventory.index') }}" class="btn btn-success">
                                    Clear Filters
     </a> 
  </div>
    </div>
<div class="hr"></div>
 
 
 
</form>
</div>

 </div>
</div>
 </div> 
</div>

<!-- ///////////////// -->
         <div class="row justify-content-center"> 

            <div class="col-10">
               <div class="card">
                  <div class="card-header listtablehead">
                     INVENTORY
                  </div>
                  <div class="card-body">
                     <table class="table table-striped">
                          <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Name</th>
                                    <th>Barcode</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>QTY</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Colour</th>
                                    <th>Volume</th>
                                    <th>Cost</th>
                                    <th>Price</th>
                                    <th>Discounted</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">                                           
                                            <div class="flex-fill">
                                                <div class="font-weight-medium">{{ $item->item_code}}</div> 
                                            </div>
                                        </div>
                                    </td>
                                       <td>
                                        <div> {{ $item->name}}</div>
                                    </td>
                                    <td>
                                        <div>{{ $item->barcode}}</div>
                                    </td>
                                    <td>
                                        <div>{{ $item->brand->name}}</div>
                                    </td>
                                    <td>
                                        <div>{{ $item->category->name}}</div>
                                    </td>
                                    <td>
                                        <div>{{ $item->stock_quantity}}</div>
                                    </td>
                                    <td>
                                        <div>{{ $item->gender}}</div>
                                    </td>
                                    <td>
                                        <div>{{ $item->age}}</div>
                                    </td>
                                    <td>
                                        <div>{{ $item->colour}}</div>
                                    </td>
                                    <td>
                                        <div>{{ $item->volume}}</div>
                                    </td>
                                    <td>
                                        <div>{{ number_format($item->unit_cost, 2) }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $item->unit_price}}</div>
                                    </td>
                                     <td>
                                        <div>{{ $item->discount_percentage}}</div>
                                    </td> 
                                    <td>
                                        <div class="flex space-x-2">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ route('inventory.show', $item) }}"
                                                    class="btn btn-success btn-sm" >View</a>
                                                <a href="{{ route('inventory.edit', $item) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                     </table>
                  </div>
                  <div class="card-footer text-muted">
                      {{ $items->links() }}
                  </div>
               </div>
            </div>
         </div>
      </main>
<script>
    document.getElementById('barcode-input').addEventListener('keypress', function(event) {
    // Prevent form submission on Enter key
    if (event.key === 'Enter') {
        event.preventDefault(); 
        let barcodeValue = this.value; 
    }
});
    </script>
@endsection