<?php
use App\Models\Admin\HomeSettings;
use App\Models\Admin\Testimonials;
use App\Models\UserAuth;

$testimonials = Testimonials::where('status', 1)->get();
?>
@extends('layouts.frontlayout')
@section('content')

<section class="block mt-5 mb-5">
	<div class="container">
		<div class="row">
			<div class="">
				<h1 style="font-size: 32px; text-align: center;">Avoiding Scams</h1>
			</div>
			
			<div class="scam_paragraph">
				<ul>
					<li>Do not provide payment to anyone you have not met in person ever.</li>
					<li>Check reviews and ask for references. It always helps to ask.</li>
					<li>Do not provide payment to anyone you have not met in person ever.</li>
					<li>Never wire funds - anyone who asks you to is a scammer.</li>
					<li>Don't accept cashier/certified checks or money orders - banks cash fakes, then hold you responsible.</li>
					<li>Transactions are between users only, no third party provides a "guarantee."</li>
					<li>Never give out financial info (bank account, social security, etc...)</li>
					<li>Do not rent or purchase sight-unseen—that amazing "deal" may not exist.</li>
					<li>Refuse background/credit checks until you have met the landlord/employer in person.</li>
					<li>Avoid unknown callers. If you don't want to add your phone number in your post, you can add your link to your email or website for direct contact. It's optional of course, remember only members can contact you in the chat box, which you can enable/disable anytime.</li>
					<li>Watch out for email scams too. The ones that avoid meeting you in person or stay in another country or city... They will ask you to send money, don't do it!</li>
				</ul>
				
				<div class="scams_text">
					<h3>Recognizing Scams</h3>
				</div>

				<div class="heading_text">
					<p>Most scams attempts involve one or more of the following:</p>
					<p>Someone that is not local to your area. Western Union, Money Gram, cashier check, money order, inability or refusal to meet face-to-face to complete the transaction.</p>
					<h4>WHO SHOULD I REPORT TO ABOUT SCAM ATTEMPTS?</h4>
				</div>

				<ul class="reco_scams_links">
					<li><a href="#">Internet Fraud Complaint Center</a></li>

					<li><a href="#">FTC complaint form</a> and hotline:877-FTC-HELP (877-382-4357)</a></li>

					<li><a href="#">Consumer Sentinel/Military for armed service members and families</a></li>

					<li><a href="#">SIIA Software and Content Piracy reporting</a></li>

					<li><a href="#">Ohio Attorney General Consumer Complaints</a></li>

					<li><a href="#">New York Attorney General, Avoid Online Investment Fraud</a></li>

				</ul>

				<p>If you suspect that a FindersPage posting may be connected to a scam, or harm doing please <a href="#" class="send-fp"> send FP the details.</a></p>
					
			</div>
		</div>
		
	</div>
	
</section>

@endsection