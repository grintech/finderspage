@extends('layouts.frontlayout')
@section('content')
<style> 
.code-500 {
  background-color: #000;
  width: 100vw;
  height: 100vh;
  color: white;
  text-align: center;
  justify-content: center;
  align-items: center;
}

.error-num {
  font-size: 8em;
}

.eye {
  background: #fff;
  border-radius: 50%;
  display: inline-block;
  height: 100px;
  position: relative;
  width: 100px;
}
.eye::after {
  background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);
  border-radius: 50%;
  bottom: 56.1px;
  content: "";
  height: 33px;
  position: absolute;
  right: 33px;
  width: 33px;
}

p {
  margin-bottom: 4em;
}

a {
  color: white;
  text-decoration: none;
  text-transform: uppercase;
}
a:hover {
  color: lightgray;
}

</style>
<div class="code-500">
  <span class='error-num'>5</span>
  <div class='eye'></div>
  <div class='eye'></div>
  <br>
  <p class='sub-text'>Oh eyeballs! Something went wrong. We're <i>looking</i> to see what happened.</p><br>
  <a class="btn create-post-button" href='https://finderspage.com/'>Home</a>
</div>
<script>
$('.code-500').mousemove(function(event) {
  var e = $('.eye');
  var x = (e.offset().left) + (e.width() / 2);
  var y = (e.offset().top) + (e.height() / 2);
  var rad = Math.atan2(event.pageX - x, event.pageY - y);
  var rot = (rad * (180 / Math.PI) * -1) + 180;
  e.css({
    '-webkit-transform': 'rotate(' + rot + 'deg)',
    'transform': 'rotate(' + rot + 'deg)'
  });
});
</script>
@endsection
