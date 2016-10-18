
<?php 
    ob_start();   
    session_start();
    $copyYear = 2016; 
    $curYear = date('Y'); 
    $copyright = $copyYear . (($copyYear != $curYear) ? '-' . $curYear : '');

    //For sending data to database after sending mail
    include('../config/database.php');

    // $url should be an absolute url
    function redirect($url){
        if (headers_sent()){
            die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
        }else{
            header('Location: ' . $url);
            exit();
        }    
    }

//If submited the value
if(isset($_POST['submit'])){
    if (isset($_POST["captcha"]) && $_POST["captcha"] != "" && $_SESSION["captcha"] == $_POST["captcha"]) {
        $errors = '';
        $myemail = 'info@authorizedinternational.com ';					// ========> Change email 
        $website = 'Get Authorized';                                    // ========> Change website name    
        $ccemail = 'progress@tech101.co.uk';                            // ========> Change CC email if needed
        
        $names = $_POST['name'];
        $emails = $_POST['email'];
        $subjects = $_POST['subject'];     
        $phones = $_POST['phone'];     
        $messages = nl2br($_POST['message']);

        $name = mysqli_real_escape_string($con, $names);
        $email = mysqli_real_escape_string($con, $emails);
        $subject = mysqli_real_escape_string($con, $subjects);
        $phone = mysqli_real_escape_string($con, $phones);
        $message = mysqli_real_escape_string($con, $messages);




        if(!empty($name) && !empty($email) && !empty($subject) && !empty($message) && !empty($phone)){
            if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email)) {            
                $to = $myemail; 
                $email_subject = $subject;		                        

                $email_body = '
                <html>
                <body style="margin: 0;padding: 0;font-size: 100%;font-family: Avenir Next, Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;line-height: 1.65; width: 100% !important;height: 100%;background: #efefef;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;">

                ';

                $email_body .= '

                <table style="width: 100% !important;height: 100%;background: #efefef;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;">
                <tr>
                    <td style="display: block !important;clear: both !important;margin: 20px auto !important;max-width: 580px !important;">
                        <table style="width: 100% !important;border-collapse: collapse;">
                            <tr>
                                <td align="center" style="padding: 60px 0;background: #71bc37;color: white; ">
                                    <h1 style="margin: 0 auto !important;max-width: 90%;text-transform: uppercase;">
                                        '.$subject.'
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="background: white;padding: 10px 25px;">
                                    <p style="color:#757575; font-size:14px; padding:0; margin:0;">'.$message.'</p>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr>
                    <td style="display: block !important;clear: both !important;margin: 0 auto !important;max-width: 580px !important;">
                        <!-- Message start -->
                        <table  style="width: 100% !important;height: 100%;background: #efefef;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;"> 
                            <tr>
                                <td style="background: none;padding-bottom:20px;" align="center">
                                    <p style="margin-bottom: 0;color: #888;text-align: center;font-size: 14px;">
                                       From <a href="mailto:'.$email.'" style="color: #888;text-decoration: none;font-weight: bold; ">'.$email.'</a>
                                       <br> 
                                       Contact no: '.$phone.'
                                       <br>
                                         Copyright &copy; '.$copyright .','. $website.'.All rights reserved.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            ';

                $email_body .= "</body></html>";    

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // headers to sent mail
                $headers .= 'From: <'.$email.'>' . "\r\n" . 'Reply-To: ' . $myemail. "\r\n";
                $headers .= 'Cc: '.$ccemail;   

                $mailnow = @mail($to,$email_subject,$email_body,$headers);

                if(isset($mailnow)) {
                    if ($mailnow) {
                        $query = "INSERT INTO `contact` SET 
                        `contact_name` = '".$name."', 
                        `contact_email` = '".$email."', 
                        `contact_subject` = '".$subject."', 
                        `contact_number` = '".$phone."', 
                        `contact_message` = '".$message."'  
                        ";
                        $sql = mysqli_query($con,$query);

                        if($sql){
                            $_SESSION['success']['message'] = "Thank you for sending us message. We will contact you soon.";
                            redirect('../contact.php');
                        } else {
                            $_SESSION['failure']['message'] = "Data error.";
                            redirect('../contact.php');
                        }
                    }else{
                        $_SESSION['failure']['message'] = "Can not submit the mail currently now. Try again later.";
                        redirect('../contact.php');   
                    }
                }           

            }else{
                $_SESSION['failure']['message'] = "Invalid Email";
                redirect('../contact.php');
            }        
        }else{
            $_SESSION['failure']['message'] = "Fields can not be empty";
            redirect('../contact.php');          
        }
    }else{
        $_SESSION['failure']['message'] = "Invalid Captcha";
        redirect('../contact.php'); 
    }
    
}else{
    $_SESSION['failure']['message'] = "An error occured";
    redirect('../contact.php');    
}

?>