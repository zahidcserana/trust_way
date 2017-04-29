<?php
    
    include_once('include/top.php');
    include_once('mailer/mail.php');
    require_once __DIR__."/class/database.class.php";
    require_once dirname(__FILE__).'/class/user_info.class.php';
    require_once dirname(__FILE__).'/class/token.class.php';
    //require_once("include/header.php");

    $userInfoObj = new UserInfo();
    $userEmailCheckObj = new UserInfo();
    $userRegObj = new UserInfo();
    $tokenObj = new Token();
    $userIdObj = new UserInfo();

    if($_POST)
    {       
        $email= $_POST['email'];
        $userEmailCheck= $userEmailCheckObj->GetRow($email);
        if ($userEmailCheck)
        {
            echo "This Email is already used.";
        }
           
        else
        {
            $userName = $_POST['username'];
            $firstName = $_POST['firstname'];
            $lastName = $_POST['lastname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $cpassword = $_POST['confirm_password'];
            $phone = $_POST['phone'];
            
            if ($password!=$cpassword) {
                echo "Password are not matched";
            }
            else
            {
                $password = md5($password);
                $token = md5(uniqid(rand()));
                $result=$userInfoObj->Insert($userName, $firstName, $lastName,$email,$password, $phone);
            
         
                if($result)
                {
                
                    $userId=$userIdObj->RegisterCheck($email,$password);

        
                    $id = $userId['user_id'];
                /////temp code
                    session_start();
                    $_SESSION['user_name']=$userName;
                    $_SESSION['user_id']=$id;
                    //session_regenerate_id();
                    $sessionId=session_id();
                    $_SESSION['session_id']=$sessionId;
                    //$cartSessionObj->UserSession($sessionId);
                    echo $sessionId;
                    header("Location: home.php");
                    exit;

                /////
                 /*
                    $addedOn = date("Y-m-d H:i:s", time());
                    $validity = date('Y-m-d H:i:s', strtotime('+1 day', time()));
                    $tokenType = 'email_valid';
                    $tokenId = $tokenObj->InsertToToken($id,$tokenType, $token,$addedOn,$validity);
                    //$id = $userRegObj->lasdID();

                    $message = "Hello $userName,
                                <br /><br />
                                Welcome to Coding Cage!<br/>
                                To complete your registration  please , just click following link<br/>
                                <br /><br />
                                <a href='http://localhost:8080/my_site/trust_way/ecommerce/confirm.php?Id=$id&token=$token'>Click HERE to Activate</a>
                                <br /><br />
                                Thanks,";
                   
                    $message = "Hello $userName,
                                <br /><br />
                                Welcome to Coding Cage!<br/>
                                To complete your registration  please , just click following link<br/>
                                <br /><br />
                                <a href='https://1004048.000webhostapp.com/ecommerce/confirm.php?Id=$id&token=$token'>Click HERE to Activate</a>
                                <br /><br />
                                Thanks,";

                            
                    $subject = "Confirm Registration";

                    ///
                    $mailgunObj = new MailGun();
                    $emailSend = $mailgunObj->SendEmailUsingMailGun(
                                    $email,
                                    $subject,
                                    $message
                                );
                            
                    */

                    //$emailSend = $userRegObj->send_mail($email,$message,$subject); 
                    //$emailSend = 1;
                   /* $file = 'link.txt';
                    // Open the file to get existing content
                    $current = file_get_contents($file);
                    // Append a new person to the file
                    $current .= "https://1004048.000webhostapp.com/ecommerce/confirm.php?Id=$id&token=$token\n";

                    //$current .= "http://localhost/my_site/trust_way/ecommerce/confirm.php?Id=$id&token=$token\n";
                    // Write the contents back to the file
                    file_put_contents($file, $current);*/
                
                    if($emailSend)
                    {
                        echo "$userName Your Confirmation link Has Been Sent To Your Email Address.";
                    }
                    else
                    {
                        echo "Cannot send Confirmation link to your e-mail address";
                    }
                
                }
                else
                {
                    echo "Sorry! somthing wrong.";
                }
            }
        }
    }
?>

<?php require_once("include/footer.php"); ?>