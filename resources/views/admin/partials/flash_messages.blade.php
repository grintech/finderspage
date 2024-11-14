<div class="flash-message">
	@if(Session::has('login_popup'))
		<div id="alertContainer" class="alert-login_popup alert--info">
		    <i class="fa fa-info-circle fa-2xl icon"></i> 
		    <div class="content">
		        <div class="title">{{ Session::get('login_popup') }}</div>
		        
		        <div id="progressBar" class="progress-bar" style="width:100%;height: 7px; 
                background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, #a54db7 100%);">
                </div>
		    </div>
		    
		</div>

<script>
    // Wait for the document to load
    document.addEventListener("DOMContentLoaded", function(event) {
        var progressBar = document.getElementById("progressBar");
        var alertContainer = document.getElementById("alertContainer");
        
        // Set initial width of progress bar
         // progressBar.style.width = "100%";
        
        // Set a timeout to remove the alert after 5 seconds
        var timeout = 15000; // 5000 milliseconds = 5 seconds
        var interval = 100; // Update interval for progress bar
        var increment = 100 / (timeout / interval);
        
        var progress = 100;
        var timer = setInterval(function() {
            progress -= increment;
            progressBar.style.width = progress + "%";
            if (progress <= 0) {
                clearInterval(timer);
                alertContainer.parentNode.removeChild(alertContainer);
            }
        }, interval);
    });
</script>

    @endif
    @if(Session::has('success'))
    	<p class="alert alert-success">
    		{{ Session::get('success') }}
    		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button>
    	</p>
    	{{ Session::forget('success') }}
    @endif
    @if(Session::has('error'))
    	<p class="alert alert-danger">
    		{{ Session::get('error') }}
    		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button>
    	</p>
    	{{ Session::forget('error') }}
    @endif

    @if(Session::has('error_subscription_check'))
        <p class="alert alert-danger">
            {{ Session::get('error_subscription_check') }}
             <a class="btn btn-warning ms-2" href="{{route('pricing')}}">Upgrade</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </p>
        {{ Session::forget('error_subscription_check') }}
    @endif


    @if(Session::has('error_subscription_new'))
        <p class="alert alert-danger">
            {{ Session::get('error_subscription_new') }}
             <a class="btn btn-warning ms-2" href="{{route('pricing')}}">Subscribe</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </p>
        {{ Session::forget('error_subscription_new') }}
    @endif


</div>