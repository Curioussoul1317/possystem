<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
      <meta http-equiv="X-UA-Compatible" content="ie=edge" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Baby Toto Pos</title>
 

 <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
 <link rel="stylesheet" href="{{ asset('css/style.css') }}">  
  <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">   
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">    
<script src="{{ asset('js/jquery.min.js')}}"></script>
  </head>
  <body>

       @if(session('success'))
       <div class="alert alert-success posalert" role="alert" >
         <a href="#" class="alert-link">{{ session('success') }}</a> 
         </div> 
            @endif
            @if(session('error')) 
            <div class="alert alert-danger posalert" role="alert" >
         <a href="#" class="alert-link">  {{ session('error') }}</a> 
         </div> 
            @endif
            @if($errors->any())
              <div class="alert alert-danger posalert" role="alert" >
         <a href="#" class="alert-link"> <ul class="list-disc list-inside">
                     @foreach($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul></a> 
         </div>  
            @endif

    <nav class="navbar navbar-expand-md  fixed-top">
         <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}" style="padding: 0; font-size: 30px; color: white;">Baby Toto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
               <ul class="navbar-nav me-auto mb-2 mb-md-0">
                  <div class="vr"></div>
                  <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="{{ route('home') }}" style="padding: 0; font-size: 30px; color: white;">
                        <i class="fa-solid fa-house fa-1x"></i>
                        </a>
                  </li>                  
               </ul>
               <div class="d-flex"  >   
                     <div class="btn-group">
                        @guest
                        @else 
                        <a href="#" class="btn btn-primary active" aria-current="page">{{ Auth::user()->name }}{{ Auth::user()->type }}</a>
                        @endguest 
                           @guest
                     @else
                     <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                     <i class="fa-solid fa-power-off"></i>
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                     </form>
                     @endguest 
                      <a href="{{ route('cart.index') }}" class="btn btn-danger active" id="new-order-alert" aria-current="page">?</a>
                     </div> 
 
               </div>
            </div>
         </div>
      </nav>

  @yield('content')


   <div class="modal modal-blur fade" id="modal-brand" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">New Brand</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="mb-4">
                        <label class="form-label" for="name">
                        Name
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control"
                           required>
                     </div>
                     <div class="flex items-center justify-between">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Create Brand</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="modal modal-blur fade" id="modal-category" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">New Cateogory</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="mb-4">
                        <label class="form-label" for="name">
                        Name
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control"
                           required>
                     </div>
                     <div class="flex items-center justify-between">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Create Cateogory</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>




<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
   <script>
setTimeout(function() {
    $(".posalert").slideUp();
}, 2000);
</script>
<script>
// $(document).ready(function() {  
//     function checkNewOrders() {
//         $.ajax({
//             url: '/babypluspos/check-new-orders',  
//             method: 'GET',
//             success: function(response) {
//                 if (response.hasNewOrders) {
//                     $('#new-order-alert').show();
//                     $('#bell').css('color', '#cf0000'); 
//                     console.log("ok");
//                 }
//             },
//             error: function(xhr) {
//                 console.log('Error checking orders:', xhr);
//             }
//         });
//     }
 
//     setInterval(checkNewOrders, 300000);
 
//     checkNewOrders();
// });
</script>
    </body>
</html>
