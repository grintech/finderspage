<?php 

use App\Models\Admin\Settings; 

$companyName = Settings::get('company_name');

?>

<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $companyName; ?></title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" />
    <style>

        body {

            font-family: sans-serif;

            margin: 0;

            background-color: #eee;

        }
        td h4 a {
                color: blue!important;
            }

    </style>



</head>



<body>



    <div>

        <center style="background-color: #eee; ">

            <table style="width: 660px; margin: 0 auto; background-color: #eee; font-family: sans-serif;">

                <tbody>

                    <tr>

                        <td>

                            <h2 style="font-weight: 800; font-size: 36px;text-align: center; margin: 30px 0 20px; "><?php echo $companyName ?></h2>

                        </td>

                    </tr>
                    <tr>

                        <td style="text-align: center;">

                           <img style="height:100px;" src="{{asset('uploads/logos/new-logo.png')}}" class="" alt="">

                        </td>

                    </tr>

                    <tr>

                        <td style="background-color: #fff; border-radius: 16px; text-align: center; padding: 60px 40px; ">

                            <?php echo $content ?>

                        </td>

                    </tr>

                    <tr>

                        <td style="text-align: center; padding: 25px 10px;">

                            <p style="color: #737373; font-size: 12px; font-weight: 400; margin: 0; line-height: 20px;">

                                <?php echo $companyName ?>
                                <p>Follow us on</p>
                           <div style="">
							        <a target="_blank" href="https://www.instagram.com/finderspage">Instagram</a>
                                    <a target="_blank" href="https://www.facebook.com/finderspage1/">Facebook</a>                        
                                    <a href="https://www.linkedin.com/company/finderspage" target="_blank">Linkedin</a>                         
                                    <a href="https://www.youtube.com/channel/UCZylvrrc6F5O6duEJBiAlXA" target="_blank">Youtube</a>
                                    <a target="_blank" href="https://www.tiktok.com/@finderspage">TikTok</a>
                            </div>

                            </p>

                        </td>

                    </tr>

                </tbody>

            </table>

        </center>

    </div>



</body>



</html>