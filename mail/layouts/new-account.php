<!-- THIS EMAIL WAS BUILT AND TESTED WITH LITMUS http://litmus.com -->
<!-- IT WAS RELEASED UNDER THE MIT LICENSE https://opensource.org/licenses/MIT -->
<!-- QUESTIONS? TWEET US @LITMUSAPP -->
<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<style type="text/css">
    /* FONTS */
    @media screen {
        
    }
    
    /* CLIENT-SPECIFIC STYLES */
    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
    img { -ms-interpolation-mode: bicubic; }

    /* RESET STYLES */
    img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
    table { border-collapse: collapse !important; }
    body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }
    
    /* MOBILE STYLES */
    @media screen and (max-width:600px){
        h1 {
            font-size: 32px !important;
            line-height: 32px !important;
        }
    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }
</style>
</head>
<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">

<!-- HIDDEN PREHEADER TEXT -->
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Lato', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
    <!--We're thrilled to have you here! Get ready to dive into your new account.-->
</div>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- LOGO -->
    <tr>
        <td bgcolor="#84b796" align="center"> <!-- #FFA73B -->
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
            <tr>
            <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
                <tr>
                    <td align="center" valign="top" style="padding: 50px 10px 40px 10px;text-align: center;">
                        <img alt="Logo" 
                             src="http://mas.nafdac.gov.ng/web/images/logo.png" 
                              width="70" height="70" 
                              style="" border="0"
                        />
                        <br/>
                        <p 
                            style="color: #fff;
                                font-size: 13px;
                                font-weight: 600;
                                line-height: 17px;
                                margin: 10px 10px 0;"
                        >
                            NATIONAL AGENCY FOR FOODS AND DRUGS<br/> ADMINISTRATION AND CONTROL (NAFDAC)<br/>
                            <span 
                                style="color: #FCBF3D;
                                        font-size: 14px;
                                        font-weight: bold;">
                                MAS Reporting System
                            </span>
                        </p>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <!-- HERO -->
    <tr>
        <td bgcolor="#84b796" align="center" style="padding: 0px 10px 0px 10px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
            <tr>
            <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
                <tr>
                    <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                      <!--<h1 style="font-size: 48px; font-weight: 400; margin: 0;">Welcome!</h1>-->
                      <h6 style="margin:40px 20px 10px; font-size: 25px;">New Account Notification </h6>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <!-- COPY BLOCK -->
    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
            <tr>
            <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
              <!-- COPY -->
              <tr>
                <td bgcolor="#ffffff" align="left" 
                    style="padding: 0px 30px 40px 30px; color: #666666; 
                            font-family: 'Lato', Helvetica, Arial, sans-serif; 
                            font-size: 15px; font-weight: 400; 
                            line-height: 20px !important;" 
                >
                    <p style="margin: 0; font-size: 15px important; color: #666666;">
                        <?php $this->beginBody() ?>
                            <?= $content ?>
                        <?php $this->endBody() ?>
                    </p>
                </td>
              </tr>
              <tr>
                <td bgcolor="#ffffff" align="left" 
                    style="padding: 0px 30px 40px 30px; 
                            border-radius: 0px 0px 4px 4px; color: #666666; 
                            font-family: 'Lato', Helvetica, Arial, sans-serif; 
                            font-size: 15px; font-weight: 400; line-height: 25px;" 
                >
                    <p style="margin: 0;">Regards,<br>The NAFDAC MAS Team</p> 
                    <hr/>
                    <p>
                        <small style="font-size: 14px; font-style: italic; line-height: 0;">
                            You have received this email because you recently registered for NAFDAC’s MAS reporting system. 
                            If you have received this email in error, please disregard.
                        </small>
                    </p>
                </td>
              </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>
    
</body>
</html>
