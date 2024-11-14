@extends('layouts.frontlayout')
@section('content')
@php use App\Models\UserAuth; @endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<!-- Breadcrumb -->
<div class="breadcrumb-main">
  <div class="container">
    <div class="row">
    </div>
  </div>
</div>
<!-- //Breadcrumb -->

 <?php  $user = UserAuth::getLoginUser(); ?>
<section class="form_section">
  <div class="container">
    <div class="row">
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="pills-home-tab" onClick="window.location.href='{{route("business_page",General::encrypt($user->id))}}'" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
            <i class="bi bi-calendar2-plus-fill"></i><br>
            Create <br> Business Page</button>
        </li>
        OR
        <li class="nav-item" role="presentation">
        <!--   <button class="nav-link" type="button" onClick="window.location.href='https://finder.harjassinfotech.org/public/edit-user-profile/eyJpdiI6IndDZU55eHc1L043a1JtbGhHSzhoWGc9PSIsInZhbHVlIjoiQmlMOU9RUFhxcjlWczZlTnNwVWdtdz09IiwibWFjIjoiMGVmZjYxMzUwYTVmOTE1MzNjMzFiMTEzMWJjYTIzYjFhMTEyMDdkZGJhNzJiZWFkN2RlYTJiNjFiMDcyOTgzYSIsInRhZyI6IiJ9';">
            <i class="bi bi-file-earmark-fill"></i><br>
            Create<br> Freelancer Page</button> -->

            <button class="nav-link" type="button" onClick="window.location.href='{{route('edit_user_profile_das',General::encrypt($user->id))}}'">
            <i class="bi bi-file-earmark-fill"></i><br>
            Create A Profile</button>
        </li>
      </ul>          
    </div>
  </div>
</section>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('#search-box').select2({
      placeholder: 'Select Business',
      ajax: {
        url: "{{url('/checking')}}",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            q: $.trim(params.term),
          };
        },
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                text: item.category,
                id: item.category
              }
            })
          };
        },
        cache: true
      }
    });

  });
</script>
<!-- ==== Section End ==== -->
@endsection