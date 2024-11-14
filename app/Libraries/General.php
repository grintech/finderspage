<?php

namespace App\Libraries;



use Illuminate\Support\Str;

use Illuminate\Support\Facades\Http;

use App\Models\Admin\Settings;

use App\Models\Admin\EmailTemplates;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Crypt;

use App\Libraries\SendGrid;

use App\Mail\MyMail;

use App\Models\Admin\EmailLogs;

use Hashids\Hashids;

use Illuminate\Support\Facades\Queue;



class General

{

	/** 

	* To make random hash string

	*/	

	public static function hash($limit = 32)

	{

		return Str::random($limit);

	}



	/** 

	* To make random hash string

	*/	

	public static function randomNumber($limit = 8)

	{

		$characters = '0123456789';

	    $charactersLength = strlen($characters);

	    $randomString = '';

	    for ($i = 0; $i < $limit; $i++) {

	        $randomString .= $characters[rand(0, $charactersLength - 1)];

	    }

	    return $randomString;

	}



	/** 

	* To encrypt

	*/

	public static function encrypt($string)

	{

		return Crypt::encryptString($string);

	}



	/** 

	* To decrypt

	*/

	public static function decrypt($string)

	{

		return Crypt::decryptString($string);

	}



	/** 

	* To encode

	*/

	public static function encode($string)

	{

		$hashids = new Hashids(config('app.key'), 6);

		return $hashids->encode($string);

	}



	/** 

	* To decode

	*/

	public static function decode($string)

	{

		$hashids = new Hashids(config('app.key'), 6);

		return current($hashids->decode($string));

	}



	/** 

	* Url to Anchor Tag

	* @param 

	*/

	public static function urlToAnchor($url)

	{

		return '<a href="' . $url . '" target="_blank">'.$url.'</a>';

	}



	/**

	* To validate the captcha

	* @param $token 

	**/

	public static function validateReCaptcha($token)

	{

		$data = [

			'secret' => Settings::get('recaptcha_secret'),

			'response' => $token,

			'remoteip' => $_SERVER['REMOTE_ADDR']

		];



		$response = Http::asForm()

			->post(

				'https://www.google.com/recaptcha/api/siteverify',

				$data

			);

			

		return $response->successful() && $response->json() && isset($response->json()['success']) && $response->json()['success'];

	}



	/**

	* To send template email

	**/

	public static function sendTemplateEmail($to, $template, $shortCodes = [], $attachments = [], $cc = null, $bcc = null)

	{	
		$template = EmailTemplates::getRow([

				'slug LIKE ?', [$template]

			]);

    // dd($template);

		if($template)
		{
			$shortCodes = array_merge($shortCodes, [

				'{company_name}' => Settings::get('company_name'),

				'{admin_link}' => General::urlToAnchor(url('/admin')),

				'{website_link}' => General::urlToAnchor(url('/'))

			]);

			$subject = $template->subject;

			$message = $template->description;

			$subject = str_replace (

				array_keys($shortCodes), 

				array_values($shortCodes), 

				$subject

			);



			$message = str_replace (

				array_keys($shortCodes), 

				array_values($shortCodes), 

				$message

			);



			return General::sendEmail(

				$to,

				$subject,

				$message,

				$cc,

				$bcc,

				$attachments,

				$template->slug

			);

		}

		else

		{

			throw new \Exception("Tempalte could be found.", 500);

		}

	}
/**

* To send multiple  email with queue

**/

public static function sendmultipleEmail($to, $template, $shortCodes = [], $attachments = [], $cc = null, $bcc = null)
{	
    $template = EmailTemplates::getRow([
        'slug LIKE ?', [$template]
    ]);

    if ($template) {
        $shortCodes = array_merge($shortCodes, [
            '{company_name}' => Settings::get('company_name'),
            '{admin_link}' => General::urlToAnchor(url('/admin')),
            '{website_link}' => General::urlToAnchor(url('/'))
        ]);

        $subject = $template->subject;
        $message = $template->description;
        $subject = str_replace(array_keys($shortCodes), array_values($shortCodes), $subject);
        $message = str_replace(array_keys($shortCodes), array_values($shortCodes), $message);
		
        foreach ($to as $recipient) {
            try {
                General::sendEmail(
                    $recipient,
                    $subject,
                    $message,
                    $cc,
                    $bcc,
                    $attachments,
                    $template->slug
                );
            } catch (\Exception $e) {
                // Log or handle the exception as needed
                error_log("Failed to send email to $recipient: " . $e->getMessage());
            }
        }

        return true;
    } else {
        throw new \Exception("Template could not be found.", 500);
    }
}




public static function sendEmailcc($to, $template, $shortCodes = [], $attachments = [], $cc = null, $bcc = null)
{    
    $template = EmailTemplates::getRow([
        'slug LIKE ?', [$template]
    ]);

    if ($template) {
        $shortCodes = array_merge($shortCodes, [
            '{company_name}' => Settings::get('company_name'),
            '{admin_link}' => General::urlToAnchor(url('/admin')),
            '{website_link}' => General::urlToAnchor(url('/'))
        ]);

        $subject = $template->subject;
        $message = $template->description;
        $subject = str_replace(array_keys($shortCodes), array_values($shortCodes), $subject);
        $message = str_replace(array_keys($shortCodes), array_values($shortCodes), $message);

        // Convert all emails to a comma-separated string for CC
        // $cc = implode(',', $to);

		//  dd($cc);

        try {
            General::sendEmail_cc(
                $to[0], // The primary recipient
                $subject,
                $message,
                $to, // Pass CC as a comma-separated string
                $bcc,
                $attachments,
                $template->slug
            );
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            error_log("Failed to send email: " . $e->getMessage());
            return false;
        }

        return true;
    } else {
        throw new \Exception("Template could not be found.", 500);
    }
}



/**

* To send email with queue

**/

public static function sendEmail_queue($to, $subject, $message, $cc = null, $bcc = null, $attachments = [], $slug = null)
{
    $from = Settings::get('from_email');
    $emailMethod = Settings::get('email_method');
    $sent = false;

    $log = EmailLogs::create([
        'slug' => $slug,
        'subject' => $subject,
        'description' => $message,
        'from' => $from,
        'to' => $to,
        'cc' => $cc,
        'bcc' => $bcc,
        'open' => 0,
        'sent' => 0
    ]);

    if ($log) {
        if ($emailMethod == 'smtp') {
            $company = Settings::get('company_name');
            $password = Settings::get('smtp_password', '');

            // Configure SMTP settings
            config([
                'mail.mailers.smtp.host' => Settings::get('smtp_host'),
                'mail.mailers.smtp.port' => Settings::get('smtp_port'),
                'mail.mailers.smtp.encryption' => Settings::get('smtp_encryption'),
                'mail.mailers.smtp.username' => Settings::get('smtp_username'),
                'mail.mailers.smtp.password' => $password,
            ]);

            // Create mail instance
            $mail = Mail::mailer('smtp')->to($to);
            if ($cc) {
                $mail->cc($cc);
            }
            if ($bcc) {
                $mail->bcc($bcc);
            }

            try {
                // Queue the email sending job
                Queue::push(function ($job) use ($mail, $from, $company, $subject, $message, $attachments) {
                    $mail->send(new MyMail($from, $company, $subject, $message, $attachments));
                    $job->delete();  
                });

                $sent = true;
            } catch (\Exception $e) {
                $sent = false;
            }
        } elseif ($emailMethod == 'sendgrid') {
            // Create message view
            $message = view("mail", ['content' => $message])->render();

            // Queue the email sending job
            Queue::push(function ($job) use ($to, $subject, $message, $cc, $bcc, $attachments) {
                SendGrid::sendEmail($to, $subject, $message, $cc, $bcc, $attachments);
                $job->delete(); // Remove the job from the queue after execution
            });

            $sent = true;
        } else {
            throw new \Exception("Email method does not exist.", 500);
        }

        // Update email log
        if ($sent && $log && $log->id) {
            $log->sent = 1;
            $log->save();
        }

        return $sent;
    } else {
        throw new \Exception("Not able to make email log.", 500);
    }
}



	/**

	* To send email

	**/




	public static function sendEmail($to, $subject, $message, $cc = null, $bcc = null, $attachments = [], $slug = null)

	{

		$from = Settings::get('from_email');

		$emailMethod = Settings::get('email_method');

		$sent = false;



		$log = EmailLogs::create([

			'slug' => $slug,

			'subject' => $subject,

			'description' => $message,

			'from' => $from,

			'to' => $to,

			'cc' =>  $cc,

			'bcc' => $bcc,

			'open' => 0,

			'sent' => 0

		]);



		if($log)

		{

			

			if($emailMethod == 'smtp')

			{

				$company = Settings::get('company_name');



				/** OVERWRITE SMTP SETTIGS AS WE HAVE IN DB. CHECK config/mail.php **/

				$password = Settings::get('smtp_password');

				// dd($password);

				$password = $password ? $password : "";

				
            
			config([

					'mail.mailers.smtp.host' => Settings::get('smtp_host'),

					'mail.mailers.smtp.port' => Settings::get('smtp_port'),

					'mail.mailers.smtp.encryption' => Settings::get('smtp_encryption'),

					'mail.mailers.smtp.username' => Settings::get('smtp_username'),

					'mail.mailers.smtp.password' => $password,

				]);

				/** OVERWRITE SMTP SETTIGS AS WE HAVE IN DB. CHECK config/mail.php **/



				$mail = Mail::mailer('smtp')

					->to($to);





				if($cc)

					$mail->cc($cc);

				if($bcc)

					$mail->bcc($bcc);

				try

				{
				   
					$mail->send( 

						new MyMail($from, $company, $subject, $message, $attachments) 

					);

					$sent = true;

				}

				catch(\Exception $e)

				{
				    //   dd($e);
					$sent = false;

				}

			}

			else if($emailMethod == 'sendgrid')

			{

				$message = view(

		    		"mail", 

		    		[

		    			'content' => $message

		    		]

		    	)->render();



				$sent = SendGrid::sendEmail(

					$to,

					$subject,

					$message,

					$cc,

					$bcc,

					$attachments

				);



			}

			else

			{

				throw new \Exception("Email method does not exist.", 500);	

			}



			// Create email log

			if($sent && $log && $log->id)

			{

				$log->sent = 1;

				$log->save();

			}

			return $sent;

		}

		else

		{

			throw new \Exception("Not able to make email log.", 500);

		}

	}



	public static function sendEmail_cc($to, $subject, $message, $cc = null, $bcc = null, $attachments = [], $slug = null)

	{

		$from = Settings::get('from_email');

		$emailMethod = Settings::get('email_method');

		$sent = false;



		$log = EmailLogs::create([

			'slug' => $slug,

			'subject' => $subject,

			'description' => $message,

			'from' => $from,

			'to' => is_array($to) ? implode(',', $to) : $to,

			'cc' => is_array($cc) ? implode(',', $cc) : $cc,
			
			'bcc' => is_array($bcc) ? implode(',', $bcc) : $bcc,

			'open' => 0,

			'sent' => 0

		]);



		if($log)

		{

			

			if($emailMethod == 'smtp')

			{

				$company = Settings::get('company_name');



				/** OVERWRITE SMTP SETTIGS AS WE HAVE IN DB. CHECK config/mail.php **/

				$password = Settings::get('smtp_password');

				

				$password = $password ? $password : "";

				

				config([

					'mail.mailers.smtp.host' => Settings::get('smtp_host'),

					'mail.mailers.smtp.port' => Settings::get('smtp_port'),

					'mail.mailers.smtp.encryption' => Settings::get('smtp_encryption'),

					'mail.mailers.smtp.username' => Settings::get('smtp_username'),

					'mail.mailers.smtp.password' => $password,

				]);

				/** OVERWRITE SMTP SETTIGS AS WE HAVE IN DB. CHECK config/mail.php **/



				$mail = Mail::mailer('smtp')

					->to($to);





				if($cc)

					$mail->cc($cc);

				if($bcc)

					$mail->bcc($bcc);

				try

				{

					$mail->send( 

						new MyMail($from, $company, $subject, $message, $attachments) 

					);

					$sent = true;

				}

				catch(\Exception $e)

				{
					$sent = false;

				}

			}

			else if($emailMethod == 'sendgrid')

			{

				$message = view(

		    		"mail", 

		    		[

		    			'content' => $message

		    		]

		    	)->render();



				$sent = SendGrid::sendEmail(

					$to,

					$subject,

					$message,

					$cc,

					$bcc,

					$attachments

				);



			}

			else

			{

				throw new \Exception("Email method does not exist.", 500);	

			}



			// Create email log

			if($sent && $log && $log->id)

			{

				$log->sent = 1;

				$log->save();

			}



			return $sent;

		}

		else

		{

			throw new \Exception("Not able to make email log.", 500);

		}

	}


	

	/**

	* To get embeded id from YouTube url

	**/

	public static function embededIdFromYouTubeUrl($url)

	{

		if($url)

		{

			preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);



	    	return isset($match[1]) && $match[1] ? $match[1] : "" ;

		}

		else

		{

			return "";

		}

	    

	}



    public static function compactPriceFromat($n) {

	    // first strip any formatting;

	    $n = (0+str_replace(",","",$n));

	   

	    // is this a number?

	    if(!is_numeric($n)) return false;

	   

	    // now filter it;

	    if($n>1000000000000) return round(($n/1000000000000),1).' T';

	    else if($n>1000000000) return round(($n/1000000000),1).' B';

	    else if($n>1000000) return round(($n/1000000),1).' M';

	    else if($n>1000) return round(($n/1000),1).' K';

	   

	    return number_format($n);

    }



    public static function isJson($string) {

		json_decode($string);

		return (json_last_error() == JSON_ERROR_NONE);

	}



	public static function renderImage($array, $key) {

		return isset($array) && isset($array[$key]) && $array[$key] && file_exists(public_path($array[$key])) ? url($array[$key]) : url('assets/img/nocard.jpg') ;

	}


	


public static function sendQueueEmail($to, $template, $shortCodes = [], $attachments = [], $cc = null, $bcc = null)
{
    $templateRow = EmailTemplates::getRow([
        'slug LIKE ?', [$template]
    ]);

    if ($templateRow) {
    	$shortCodes = array_merge($shortCodes, [
            '{company_name}' => Settings::get('company_name'),
            '{admin_link}' => General::urlToAnchor(url('/admin')),
            '{website_link}' => General::urlToAnchor(url('/'))
        ]);
        $subject = $templateRow->subject;
        $message = $templateRow->description;

        // Replace short codes
        foreach ($shortCodes as $key => $value) {
            $subject = str_replace($key, $value, $subject);
            $message = str_replace($key, $value, $message);
        }

        // Call sendEmail function to send the email
        return self::sendEmail_queue($to, $subject, $message, $cc, $bcc, $attachments, $template);
    } else {
        throw new \Exception("Template could not be found.", 500);
    }
}

}