@extends('layouts.app')

@section('content')

 
<main class="container"> 
  <div class="row " style="margin-top: 100px;">
<!-- card  -->
<div class="col col-md-3">
   <a href="{{ route('brands.index') }}"  class="text-decoration-none">
      <div class="card bg-light  mb-3 homecard" >
         <div class="homeicons" style="color: rgb(3, 34, 106);">
          <i class="fa-solid fa-copyright fa-5x"></i>
         </div>
         <div class="card-body text-primary homecardtext">
            <h3 class="card-title">BRANDS </h3>
         </div>
      </div>
   </a>
</div>
<!-- end card  -->
<!-- card  -->
<div class="col col-md-3">
   <a href="{{ route('categories.index') }}"  class="text-decoration-none">
      <div class="card bg-light  mb-3 homecard" >
         <div class="homeicons" style="color: rgb(3, 34, 106);">  
<i class="fas fa-sort-amount-up fa-5x"></i>
         </div>
         <div class="card-body text-primary homecardtext">
            <h3 class="card-title">CATEGORIES </h3>
         </div>
      </div>
   </a>
</div>
<!-- end card  -->
<!-- card  -->
<div class="col col-md-3">
   <a href="{{ route('inventory.index') }}"  class="text-decoration-none">
      <div class="card bg-light  mb-3 homecard"  >
         <div class="homeicons" style="color: rgb(3, 34, 106);">
          <i class="fas fa-list fa-5x"></i>
         </div>
         <div class="card-body text-primary homecardtext">
            <h3 class="card-title">INVENTORY</h3>
         </div>
      </div>
   </a>
</div>
<!-- end card  -->
<!-- card  -->
<div class="col col-md-3">
   <a href="{{ route('sales.create') }}"  class="text-decoration-none">
      <div class="card bg-light  mb-3 homecard"  >
         <div class="homeicons" style="color: rgb(3, 34, 106);">
          <i class="fa-solid fa-cash-register fa-5x"></i>
         </div>
         <div class="card-body text-primary homecardtext">
            <h3 class="card-title">SALE</h3>
         </div>
      </div>
   </a>
</div>
<!-- end card  -->
<!-- card  -->
<div class="col col-md-3">
   <a href="{{ route('sales.index') }}"  class="text-decoration-none">
      <div class="card bg-light  mb-3 homecard" >
         <div class="homeicons" style="color: rgb(3, 34, 106);">
           <i class="fa-solid fa-file-waveform fa-5x "  ></i>
         </div>
         <div class="card-body text-primary homecardtext">
            <h3 class="card-title">SALES HISTORY</h3>
         </div>
      </div>
   </a>
</div>
<!-- end card  -->
<!-- card  -->
<div class="col col-md-3">
   <a href="{{ route('loans.index') }}"  class="text-decoration-none">
      <div class="card bg-light mb-3 homecard"  >
         <div class="homeicons" style="color: rgb(3, 34, 106);">
           <i class="fa-solid fa-money-bill-1-wave fa-5x "  ></i>
         </div>
         <div class="card-body text-primary homecardtext">
            <h3 class="card-title">LOANS</h3>
         </div>
      </div>
   </a>
</div>
<!-- end card  -->
<!-- card  -->
<div class="col col-md-3">
   <a href="{{ route('expenses.index') }}"  class="text-decoration-none">
      <div class="card bg-light  mb-3 homecard"  >
         <div class="homeicons" style="color: rgb(3, 34, 106);">
            <i class="fa-solid fa-sack-dollar  fa-5x "  ></i>
         </div>
         <div class="card-body text-primary homecardtext">
            <h3 class="card-title">EXPENSES </h3>
         </div>
      </div>
   </a>
</div>
<!-- end card  -->
<!-- card  -->
<div class="col col-md-3">
   <a href="{{ route('customers.index') }}"  class="text-decoration-none">
      <div class="card bg-light  mb-3 homecard" >
         <div class="homeicons" style="color: rgb(3, 34, 106);">
            <i class="fa-solid fa-users fa-5x "  ></i>
         </div>
         <div class="card-body text-primary homecardtext">
            <h3 class="card-title">CUSTOMERS </h3>
         </div>
      </div>
   </a>
</div>
<!-- end card  -->
<!-- card  -->
<div class="col col-md-3">
   <a href="{{ route('users.index') }}"  class="text-decoration-none">
      <div class="card bg-light  mb-3 homecard" >
         <div class="homeicons" style="color: rgb(3, 34, 106);">
           <i class="fa-solid fa-users-gear fa-5x "  ></i>
         </div>
         <div class="card-body text-primary homecardtext">
            <h3 class="card-title">USERS </h3>
         </div>
      </div>
   </a>
</div>
<!-- end card  -->
<!-- card  -->
<div class="col col-md-3">
   <a href="{{ route('cart.index') }}"  class="text-decoration-none">
      <div class="card bg-light  mb-3 homecard" >
         <div class="homeicons" style="color: rgb(3, 34, 106);">
            <i class="fas fa-shopping-cart fa-5x "  ></i>
         </div>
         <div class="card-body text-primary homecardtext">
            <h3 class="card-title">ORDERS </h3>
         </div>
      </div>
   </a>
</div>
<!-- end card  -->

<!-- card  -->
<div class="col col-md-3">
   <a href="{{ route('banners.index') }}"  class="text-decoration-none">
      <div class="card bg-light  mb-3 homecard" >
         <div class="homeicons" style="color: rgb(3, 34, 106);">
            <i class="fas fa-shopping-cart fa-5x "  ></i>
         </div>
         <div class="card-body text-primary homecardtext">
            <h3 class="card-title">BANNERS </h3>
         </div>
      </div>
   </a>
</div>
<!-- end card  -->
 
  </div> 
</main>
@endsection