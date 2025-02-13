@extends('layouts.app') @section('content')
 
<main class="container-fluid" >  
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="card" style="background-color: rgb(240, 240, 240); height: 91vh; min-height: 91vh">
        <div class="card-header listtablehead">
          <form id="checkout-form">
            <div class="row">
              <div class="form-group col-md-4">
                <input type="text" class="form-control posinput" id="product-search" placeholder="Search " />
              </div>
              <div class="form-group col-md-4">
                <select name="customer_id" id="customer_id" class="form-control posinput">
                  <option value="">Walk-in Customer</option>
                  @foreach($customers as $customer)
                  <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-4">
                <input
                  type="number"
                  id="discount_amount"
                  step="0.01"
                  min="0"
                  placeholder="Discount "
                  class="form-control posinput"
                  onchange="updateTotals()" 
                />
              </div>
              <div class="row justify-content-md-center">
                                <div id="search-results" class="col-md-10 overflow-auto" style="position: absolute; top: 75px;  z-index: 3; height:500px; background-color:rgb(255 255 255);border-radius: 15px;
                                    -webkit-box-shadow: 2px 10px 21px 1px rgba(0,0,0,0.33);
-moz-box-shadow: 2px 10px 21px 1px rgba(0,0,0,0.33);
box-shadow: 2px 10px 21px 1px rgba(0,0,0,0.33); padding: 20px;">
                                </div>
                            </div>
            </div>
   
        </div>
        
    <style>
       

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead, tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed; /* Ensures column alignment */
        }

        thead {
            background-color: #f8f9fa; /* Light background */
            position: sticky;
            top: 0;
            z-index: 2;
        }

        tbody {
            display: block;
            height: calc(60vh - 00px); /* Adjusted height to fit inside 50vh */
            overflow-y: auto;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
    </style>
        <div class="card-body" >         
          <table class="table table-striped"  > 
           <thead>
              <tr>
                <th class="px-4 py-2 border" style="width:60%">Product</th>
                <th class="px-4 py-2 border" style="width:10%">Quantity</th>
                <th class="px-4 py-2 border" style="width:10%">Price</th>
                <th class="px-4 py-2 border" style="width:10%">Subtotal</th>
                <th class="px-4 py-2 border" style="width:10%">Action</th>
              </tr>
            </thead> 
             <tbody id="cart-items" style="overflow: scroll"></tbody> 
          </table> 
        </div>
        <div
          class="row justify-content-end"
          style="padding: var(--bs-card-cap-padding-y) var(--bs-card-cap-padding-x); color: var(--bs-card-cap-color)"
        >
          <div class="col-3" style="display: flex; height: 100%">
            <span
              style="
                font-size: 15px;
                font-weight: 500;
                text-align: center;
                display: inline-block;
                align-self: flex-end;
              "
            >
              Subtotal: <span id="subtotal-amount" >Mvr 0.00 </span>|   Tax:
              <span id="tax-amount"  >Mvr 0.00</span> | Discount:
              <span id="discount-amount"  >Mvr 0.00</span>
            </span>
          </div>
          <div
            class="col-3"
            style="
              background-color: #dbd8d8;
              border: #c0c0c0 1px solid;
              font-size: xx-large;
              font-weight: 600;
              text-align: center;
            "
          >
            <span id="total-amount" class="font-bold"> Mvr 0.00 /-</span>
          </div>
        </div>
        <div class="card-footer">
          
            <div class="row justify-content-end">
              <div class="form-group col-md-2">
                <select
                  name="payment_method"
                  id="payment_method"
                  class="form-control"
                  style="
                    padding-bottom: 0px;
                    height: 50px;
                    background-color: #186a03;
                    color: white;
                    font-size: 25px;
                    font-weight: 600;
                  "
                  required
                >
                  <option value="">&nbsp&nbsp&nbsp PAYMENT TYPE </option>
                  <option value="cash">Cash</option>
                  <option value="card">Card</option>
                  <option value="bank_transfer">Bank Transfer</option>
                </select>
              </div>
              <div class="form-group col-md-3" style="padding: 0px">
                <button
                  type="submit"
                  class="btn btn-primary active"
                  style="
                    background-color: #870000;
                    border: #c0c0c0 1px solid;
                    font-size: x-large;
                    font-weight: 600;
                    text-align: center;
                    width: 100%;
                  "
                >
                  ENTER
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
 

<script>
  // public/js/sales.js
  let cart = [];
  let searchTimeout;

  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('product-search');
    const searchResults = document.getElementById('search-results');
    const cartTable = document.getElementById('cart-items');
    const checkoutForm = document.getElementById('checkout-form');
    document.getElementById('search-results').style.visibility = 'hidden';
    let totalcost = 0;

    // Product search with debounce
    searchInput.addEventListener('input', function () {
      clearTimeout(searchTimeout);
      const query = this.value.trim();

      // if (query.length < 2) {
      //     searchResults.innerHTML = '';
      //     return;
      // }

      if (!query) {
        searchResults.innerHTML = '';
        document.getElementById('search-results').style.visibility = 'hidden';
        return;
      }
      searchTimeout = setTimeout(() => {
const searchUrl = "{{ route('search.products') }}"; 
fetch(`${searchUrl}?search=${encodeURIComponent(query)}`, {
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
    }
})
.then(response => response.json())
.then(data => {
    console.log("API Response:", data); // Debugging line

    if (!Array.isArray(data)) {
        throw new Error("Unexpected response format");
    }

    if (data.length > 0) {
        document.getElementById("search-results").style.visibility = "visible";
    } 

    searchResults.innerHTML = '';
    data.forEach(product => {
        const div = document.createElement('div');
        div.innerHTML = `
            <div class="row mb-1" style="    border-bottom: 1px solid #bfbebe;
    background-color: #f7f7f7;
    font-size: larger;
    color: #5d3636;
    padding: 5px;">
                <div class="col" style="margin: auto;"> 
                    ${product.image ? `<img src="${product.image}" class="avatar me-2" style="height: 50px;">` : '<span class="avatar me-2" style="background-image: url(./static/avatars/008f.jpg)"></span>'} 
                </div>
                <div class="col" style="margin: auto;">${product.name}</div>
                <div class="col" style="margin: auto;">Mvr${product.price}</div>
                <div class="col" style="margin: auto;">${product.stock}</div>
            </div>
        `;
        div.addEventListener('click', () => addToCart(product));
        searchResults.appendChild(div);
    });
})
.catch(error => {
    console.error("Error:", error);
    searchResults.innerHTML = '<div class="p-2 text-red-600">Error loading products</div>';
});
      }, 300);
    });

    // Add to cart function
    window.addToCart = function (product) {
      const existingItem = cart.find(item => item.id === product.id);

      if (existingItem) {
        if (existingItem.quantity >= product.stock) {
          alert('Cannot exceed available stock');
          return;
        }
        existingItem.quantity++;
      } else {
        cart.push({
          id: product.id,
          name: product.name,
          price: parseFloat(product.price),
          cost: parseFloat(product.cost),
          discount: parseInt(product.discount_percentage),
          quantity: 1,
          stock: product.stock,
        });
      }

      updateCartDisplay();
      searchInput.value = '';
      searchResults.innerHTML = '';
      document.getElementById('search-results').style.visibility = 'hidden';
    };

    // Update quantity in cart
    window.updateQuantity = function (index, newQuantity) {
      newQuantity = parseInt(newQuantity);
      if (newQuantity < 1) newQuantity = 1;
      if (newQuantity > cart[index].stock) {
        alert('Cannot exceed available stock');
        newQuantity = cart[index].stock;
      }
      cart[index].quantity = newQuantity;
      updateCartDisplay();
    };

    // Remove from cart
    window.removeFromCart = function (index) {
      cart.splice(index, 1);
      updateCartDisplay();
    };

    // Update totals calculation
    window.updateTotals = function () {
      let subtotal = 0;
      let subcost = 0;
      cart.forEach(item => {
        if (item.discount) {
          var tempdisprice = item.price * (1 - item.discount / 100);
          var tempprice = tempdisprice;
          subtotal += tempprice * item.quantity;
        } else {
          subtotal += item.price * item.quantity;
        }
        subcost += item.cost * item.quantity;
      });

      const discountAmount = parseFloat(document.getElementById('discount_amount').value || 0);
      const taxRate = 0.08; // 8% tax rate

      // Prevent negative totals after discount
      const discountedSubtotal = Math.max(subtotal - discountAmount, 0);
      const tax = Math.round(discountedSubtotal * taxRate);
      const total = Math.round(discountedSubtotal + tax);

      // Update display
      document.getElementById('subtotal-amount').textContent = `Mvr ${subtotal.toFixed(2)} `;
      document.getElementById('discount-amount').textContent = `-Mvr ${discountAmount.toFixed(2)}`;
      document.getElementById('tax-amount').textContent = `Mvr ${tax.toFixed(2)}`;
      document.getElementById('total-amount').textContent = `Mvr ${total} /-`;
      totalcost = subcost.toFixed(2);
      console.log(totalcost);
    };

    // Update cart display
    window.updateCartDisplay = function () {
      cartTable.innerHTML = '';
      let total = 0;
      var itemprice = 0;
      cart.forEach((item, index) => {
        if (item.discount) {
          var discountprice = item.price * (1 - item.discount / 100);
          itemprice = discountprice;
        } else {
          itemprice = item.price.toFixed(2);
        }
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50';
        row.innerHTML = `
                <td   style="width:60%">${item.name} </td>
                <td  style="margin: auto; width:10%">
                    <input type="number" 
                           value="${item.quantity}" 
                           min="1" 
                           max="${item.stock}"
                           class="form-control"
                           onchange="updateQuantity(${index}, this.value)">
                </td>
                <td  style="width:10%">Mvr 
                ${
                  item.discount
                    ? `<strong>  ${item.price.toFixed(2)} - ${item.discount}%  </strong>`
                    : `<strong>  ${item.price.toFixed(2)} </strong>`
                }   
                </td>
                <td   style="width:10%">Mvr ${(itemprice * item.quantity).toFixed(2)}</td>
                <td   style="width:10%">
                    <button onclick="removeFromCart(${index})" 
                            class="btn btn-danger btn-sm" style="float: right;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </td>
            `;
        cartTable.appendChild(row);
        total += itemprice * item.quantity;
      });

 
      updateTotals();
    };

    // Handle checkout
    checkoutForm.addEventListener('submit', function (e) {
      e.preventDefault();
 
      if (cart.length === 0) {
        alert('Cart is empty');
        return;
      }

      const discountAmount = parseFloat(document.getElementById('discount_amount').value || 0);
      var newitemdiscount = 0;
      const formData = {
        customer_id: document.getElementById('customer_id').value || null,
        payment_method: document.getElementById('payment_method').value,
        total_cost: totalcost,
        discount: discountAmount,
        items: cart.map(item => ({
          inventory_id: item.id,
          quantity: item.quantity,
          itemdiscount: item.discount,
          unit_price: item.price,
        })),
      };
const storeUrl = "{{ route('sales.store') }}";
fetch(storeUrl, { 
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          Accept: 'application/json',
        },
        body: JSON.stringify(formData),
      })
        .then(response => {
          if (!response.ok) {
            return response.json().then(data => Promise.reject(data));
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            window.location.href = `/sales/${data.sale.id}/invoice`;
          } else {
            alert(data.message || 'Error processing sale');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert(error.message || 'Error processing sale');
        });
    });
  });
</script>

<script>
    document.getElementById('product-search').addEventListener('keypress', function(event) {
    // Prevent form submission on Enter key
    if (event.key === 'Enter') {
        event.preventDefault(); 
        let barcodeValue = this.value; 
    }
});
    </script>

@endsection
