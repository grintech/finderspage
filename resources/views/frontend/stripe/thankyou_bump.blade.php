@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
      <style type="text/css">
         .container{
         width: 1170px;
         margin: 0 auto;
         }
         .login-main-wrapper{background: #ab8b43; padding: 30px;box-shadow: 3px 3px 7px 2px rgba(0, 0, 0, 0.2); border-radius: 20px;}
         .thankyou-wrapper{
         width:100%;
         height:auto;
         margin:auto;
         padding:10px 0px 30px;
         }
         thead {
         background: #f7f9ff;
         }
         .thankyou-wrapper img{
         width: 25%;
         }
         .thankyou-wrapper h1{
         margin: 0;
         text-align:center;
         color:#fff;
         padding:0px 10px 10px;
         font-size: 34px;
         }
         .thankyou-wrapper p{
         font-size:26px;
         text-align:center;
         color:#fff;
         padding:5px 10px 10px;
         }
         .thankyou-wrapper a{
         text-align:center;
         color:#000;
         display:block;
         text-decoration:none;
         width:250px;
         background: linear-gradient(90deg, rgba(170,137,65,1) 0%, rgba(205,156,49,1) 13%, rgba(154,128,73,1) 35%, rgba(246,204,78,1) 51%, rgba(181,147,56,1) 75%, rgba(163,136,68,1) 100%);
         margin: 10px auto 0px;
         padding: 15px 20px 15px;
         border-radius: 50px;
         border:2px solid #000;
         }
         .thankyou-wrapper a:hover{
         border:2px solid #FCD152;
         }
         .login-main-wrapper .table th{color: #000;}
         .login-main-wrapper .table td{color: #fff;}

         @media only screen and (max-width:767px){
           .container{
            width: 100%;
            } 
            .thankyou-wrapper img {
              width: 60%;
            }
         }
      </style>
   </head>
   <body>
      <section class="login-main-wrapper container">
         <div class="login-process">
            <div class="login-main-container">
               <div class="thankyou-wrapper">
                  <h1><img src="http://montco.happeningmag.com/wp-content/uploads/2014/11/thankyou.png" alt="thanks" /></h1>
                  <p style="display: none;">YOUR ORDER HAS BEEN RECEIVED </p>
                  <p>Plan Name: <strong style="text-transform: capitalize;">{{$datas['plan_name']}}</strong></p>
                  <div class="clr"></div>
               </div>
               <div class="clr"></div>
            </div>
             @if (Session::has('success'))
                  <div class="alert alert-success text-center">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                     <p>{{ Session::get('success') }}</p>
                  </div>
                  @endif
         </div>
         <div class="clr"></div>
         <div class="table-responsive">
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th scope="col">#</th>
                     <th scope="col">Payment id</th>
                     <th scope="col">Amount</th>
                     <th scope="col">Date</th>
                     <!-- <th scope="col">Action</th> -->
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>1</td>
                     <td>{{$datas['payment_id']}}</td>
                     <td>${{$datas['amount']}}</td>
                     <td>{{date('d-M-y H:i',strtotime($datas['created_at']))}}</td>
                    <!--  <td>
                        <a href="{{$datas['receipt_url']}}" target="_blank">View Recipt</a>
                     </td> -->
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="thankyou-wrapper">
            <a href="{{route('index_user')}}">Continue</a>
         </div>
      </section>
      @push('js')
      <script> 
         // console.log('Welcome To Smile');    
      </script>
      @endpush

   @endsection