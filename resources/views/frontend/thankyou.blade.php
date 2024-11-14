@extends('layouts.frontlayout')
@section('content')

    <div class="container">
    <div class = "row py-5">
        <div class="col-md-8 mx-auto text-center">
            <h1>Thank you for your order!</h1>
            <p>Your order has been successfully placed.</p>
        
          <div id="checkoutDataDiv">
          <!-- The data will be displayed here -->
          </div>
        </div>
    </div>

    </div>

<script type="text/javascript">
   $(document).ready(function () {
    // Retrieve the data from local storage
    var checkoutFormData = JSON.parse(localStorage.getItem('checkoutFormData'));

    // Check if the data exists in local storage
    if (checkoutFormData) {
        // Build the content to be displayed in the div
        var content = '<h2>Order details:</h2>';
        content += '<p><strong>Order ID: ' + checkoutFormData.order_id + '</strong></p>';
        content += '<p>First Name: ' + checkoutFormData.first_name + '</p>';
        content += '<p>Last Name: ' + checkoutFormData.last_name + '</p>';
        content += '<p>Email: ' + checkoutFormData.email + '</p>';
        content += '<p>Address: ' + checkoutFormData.address + '</p>';
        content += '<p>Address 2: ' + checkoutFormData.address2 + '</p>';
        content += '<p>Country: ' + checkoutFormData.country + '</p>';
        content += '<p>State: ' + checkoutFormData.state + '</p>';
        content += '<p>City: ' + checkoutFormData.city + '</p>';
        content += '<p>Cart Product IDs: ' + checkoutFormData.cart_product_ids + '</p>';

        // Update the content of the div with the data
        $('#checkoutDataDiv').html(content);
    } else {
        // Handle the case when the data does not exist in local storage
        var content = '<p>Place an order.</p>';
        content += '<a href="https://finder.harjassinfotech.org/public/shopping-post">Continue Shopping</a>';

        $('#checkoutDataDiv').html(content);
    }
    });

        function deleteCookie(name) {
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        }
        setTimeout(function () {
        deleteCookie('cart_product_ids');
        localStorage.clear();
        }, 2500);

    </script>
@endsection