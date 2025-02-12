@extends('layouts.app')
@section('content')
 
<main class="container-fluid"> 
  
 @if (isset($brand))  
 <!-- EDIT  -->
<div class="row justify-content-center">
   <div class="col-6">
        <div class="card " style="margin-bottom:10px;   ">
                        <div class="card-header listtablehead">
                            EDIT BRAND {{ $brand->name }}
                        </div>
                    <div class="card-body">
 <form action="{{ route('brands.update', $brand) }}" 
                    method="POST" 
                    enctype="multipart/form-data"  >
                    @csrf
                    @method('PUT')
                      <div class="row">
    <div class="form-group col-md-12">
      <label for="inputEmail4" class="posinputlable">Brand Name</label> 
       <input type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name', $brand->name) }}" 
                            class="form-control posinput"
                            required>
    </div> 
    <div class="form-group col-md-10">
       <button type="submit" class="btn btn-primary formbutton"  >UPDATE</button>
    </div> 
     <div class="form-group col-md-2">
       <a href="{{ route('brands.index') }}"   class="btn btn-secondary formbuttonsecond"  >CANCEL</a>
    </div> 
 </div>
</form>
                    </div>
        </div>
    </div>
</div>
 
  <!-- EDIT  -->
   @endif




<div class="container breadcrumbs">

  <div class="row justify-content-between" style="font-size: x-large;
    color: #03226a;">
    <div class="col-10">
      <div class="row justify-content-start">
    <div class="col-1">
      <a href="{{ route('home') }}" class="text-decoration-none"><i class="fa-solid fa-backward breadcrumbsicon"></i></a>
    </div>
    <div class="col-4 backicon breadcrumbstext">
     BRANDS
    </div>
  </div>
    </div>
    <div class="col-2" >
        <a href="#" class="text-decoration-none"  style=" float: right;"
        data-bs-toggle="modal"  data-bs-target="#modal-brand"
                        ><i class="fa-solid fa-square-plus  breadcrumbsicon"></i></a>
    </div>
  </div>
 


 
</div>


 
<!-- ///////////////// -->
  <div class="row justify-content-center">

    <div class="col-6">
<div class="card text-center">
  <div class="card-header listtablehead">
   BRANDS
  </div>
  <div class="card-body">
        <table class="table table-striped">
       <thead>
        <tr>
            <th>Name</th>
            <th>No Items</th>
            <th class="w-1"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($brands as $brand)
        <tr>
            <td> <strong> {{ $brand->name }}</strong></td>
            <td class="text-secondary">
                {{ $brand->products_count ?? 0 }}
            </td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a class="btn btn-warning btn-sm" href="{{ route('brands.edit', $brand) }}">
                        Edit
                    </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
  </div>
  <div class="card-footer text-muted">
    {{ $brands->links() }}
  </div>
</div>
    </div>  
  </div>
</main>

@endsection