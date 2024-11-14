@extends('layouts.frontlayout')
@section('content')
<section id="terms" class="mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="terms-content ">
                <h1 style="font-size: 32px;">TERMS OF USE</h1>
                    <h3>Welcome to FindersPage!</h3>
                    <p style="text-align: justify; white-space: pre-line;">{{ $termOfUse->term_of_use ?? '' }}</p>

                    <h3>PRIVACY AND REFUND POLICY</h3>
                    <p style="text-align: justify; white-space: pre-line;">{{ $termOfUse->privacy_policy ?? '' }}</p>

                    <p class="mb-1">Kind Greetings,</p>
                    <p>from the Founder, <span><strong>Brenda Pond</strong></span></p>
            </div>
        </div>
    </div>
</section>



@endsection