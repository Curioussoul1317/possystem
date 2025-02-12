@extends('layouts.app')

@section('content')
 
 <main class="container-fluid">
         <div class="container breadcrumbs">
            <div class="row justify-content-between" style="font-size: x-large;
               color: #03226a;">
               <div class="col-10">
                  <div class="row justify-content-start">
                     <div class="col-1">
                        <a href=" {{ route('inventory.index') }}" class="text-decoration-none"><i class="fa-solid fa-backward breadcrumbsicon"></i></a>
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
  <div class="row justify-content-center">

    <div class="col-10">
<div class="card text-center">
  <div class="card-header listtablehead">
   BRANDS
  </div>
  <div class="card-body">
     <div class="row">
    <div class="col-3">
     <ul class="list-group"> 
    <li class="list-group-item active">Item Code
        :{{ $inventory->item_code ?? 'N/A' }}</li>
        <li class="list-group-item"> Name: {{ $inventory->name }}</li>
        <li class="list-group-item">Brand:
        {{ $inventory->brand->name ?? 'N/A' }}</li>
        <li class="list-group-item"> Category:
        {{ $inventory->category->name ?? 'N/A' }}</li>
        <li class="list-group-item">Gender: {{ $inventory->gender ?? 'N/A' }}</li>
        <li class="list-group-item">Age: {{ $inventory->age ?? 'N/A' }}</li>
        <li class="list-group-item">colour:
        {{ $inventory->colour ?? 'N/A' }}</li>
        <li class="list-group-item">volume:
        {{ $inventory->volume ?? 'N/A' }}</li>
        <li class="list-group-item">unit_cost:
        {{ $inventory->unit_cost ?? 'N/A' }}</li>
        <li class="list-group-item"> unit_price:
        {{ $inventory->unit_price ?? 'N/A' }}</li>
        <li class="list-group-item"> stock_quantity:
        {{ $inventory->stock_quantity ?? 'N/A' }}</li>
        <li class="list-group-item">barcode:
        {{ $inventory->barcode ?? 'N/A' }}</li>
            <li class="list-group-item">Discount : {{ $inventory->discount_percentage ?? 'N/A' }} %</li> 
</ul>
    </div>
    
    <div class="col-9">
          <div class="row ">
        <div class="col-12">
          <div class="card">
  <div class="card-body  justify-content-center">
     <h3 class="card-title">Stock Management</h3>
     <form action="{{ route('inventory.stock.adjust', $inventory) }}" method="POST">
         @csrf
          <div class="row">
    <div class="form-group col-md-3">  
            <input type="number" name="quantity" id="quantity" class="form-control posinput" required placeholder="Quantity">  
        </div>
        <div class="form-group col-md-3"> 
            <select class="form-select posinput" name="operation" id="operation">
                <option value="add">Add Stock</option>
                    <option value="subtract">Remove Stock</option>
            </select>  
        </div>
        <div class="form-group col-md-6"> 
        <button type="submit" class="btn btn-primary w-100">
            Update Stock
        </button> 
        
        </div>
    </form>
  </div>
</div>
        </div>
        <div class="col-12">
          <div class="card">
  <div class="card-body">
   <h3 class="card-title">Description</h3>
    <p class="text-secondary">{{ $inventory->description ?? 'N/A' }}</p>
  </div>
</div>
        </div>
        <div class="col-12">
          <div class="card">
  <div class="card-body">
    <h3 class="card-title">Images</h3>
    <div class="row row-cards">

        @forelse($inventory->images as $image)
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $inventory->name }}"
                    class="card-img-top">
            </div>
            @if($image->is_primary)
            <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded">
                Primary
            </span>
            @endif
        </div>
        @empty
        <div class="col-sm-6 col-lg-4">
            <div class="card card-sm">
                No images available
            </div>
        </div>
        @endforelse

    </div>
  </div>
</div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="card-footer text-muted">
   
  </div>
</div>
    </div>  
  </div>
  <!-- ///////////////// -->
</main>

@endsection