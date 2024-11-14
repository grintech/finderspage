<?php
use App\Models\Admin\HomeSettings;
use App\Models\Admin\Testimonials;
use App\Models\UserAuth;

?>
@extends('layouts.frontlayout')
@section('content')
    
    <section class="faq mt-5 mb-5 ">
        <div class="container">
                <h2 class="mb-4">Shopping Cart</h2>
                <div class="table-responsive">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1;
                        $subtotal = 0 ?>
                        @if($count != 0)
                            @foreach ($shoppingItems as $Shopping)
                                <tr>
                                    <td>#<?= $counter; ?></td>
                                    <td><?= $Shopping->title; ?></td>
                                    <td>1</td>
                                    <td>$<?= $Shopping->product_sale_price; ?></td>
                                    <td>$<?= $subtotalitem = $Shopping->product_sale_price * 1; ?></td>
                                </tr>    
                                <?php
                                    $counter++;
                                    $subtotal += $subtotalitem;
                                ?>
                            @endforeach


                        @else 
                            <?php $subtotalitem = 0;?>
                            <tr>
                                <td colspan="4">No items in the cart</td>
                            </tr>
                        @endif
                        
                        
                        
                    <!-- Add more rows for other products -->
                    </tbody>
                    @if($count != 0)
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total</strong></td>
                            <td><strong>$<?= $subtotal; ?></strong></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
</div>
                @if($count != 0)
                <div class="text-end mt-3">
                <!-- <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Checkout</button>
                </form> -->
                    <a href= "{{ route('checkout') }}"><button class="btn btn-primary">Checkout</button></a>
                </div> 
                @endif
            </div> 
    </section>
    <style>
    th {
        padding: 24px !important;
        font-size: 16px;
        line-height: 4rem;
    }
    .btn.btn-primary {
        background: linear-gradient(90deg, rgba(170,137,65,1) 0%, rgba(205,156,49,1) 13%, rgba(154,128,73,1) 35%, rgba(246,204,78,1) 51%, rgba(181,147,56,1) 75%, rgba(163,136,68,1) 100%);
        width: 130px;
        height: 40px;
        margin-top: 3px;
        border-radius: 35px;
        border: 0px;
        box-shadow: none;
        color: #000 !important;
    }
    </style>
@endsection