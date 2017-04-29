<?php
    require_once("include/header.php");
    require_once("/../class/database.class.php");
    require_once dirname(__FILE__).'/../class/admin.class.php';
?>
<?php
    $adminUserObj = new AdminInfo();
    if($_POST)
    {
        $userName= $_POST['username'];
        $adminUserCheck= $adminUserObj->AdminCheck($userName);
        if ($adminUserCheck)
        {
            echo "This User Name is already used.";
        }
        else
        {

            $userName = $_POST['username'];
            $password = $_POST['password'];
            $cpassword = $_POST['confirm_password'];
        
            if ($password!=$cpassword) {
                echo "Password are not matched";
            }
            else
            {
                $password = md5($password);
                $adminUser =$adminUserObj->Insert($userName,$password);
               
                if (!$adminUser) {
                    header("Location:index.php");
                }
            }
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script src="lib/jquery.js"></script>
    <script src="dist/jquery.validate.js"></script>
    <script>

    $().ready(function() {
        // validate the comment form when it is submitted
        $("#commentForm").validate();

        // validate signup form on keyup and submit
        $("#signupForm").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 2
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
            },
            messages: {
                username: {
                    required: "Please enter a username",
                    minlength: "Your username must consist of at least 2 characters"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                confirm_password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },
            }
        });

    });
    </script>
    <style>
    
    #signupForm {
        width: 670px;
    }
    #signupForm label.error {
        margin-left: 10px;
        width: auto;
        display: inline;
    }
    
    </style>
</head>
<body>

<div id="main" align="center">
   
    <form class="cmxform" id="signupForm" method="post" action="">
        <table>
            <tr>
                <td><label for="username">Username</label></td>
                <td><input id="username" name="username" type="text"></td>                
            </tr>
            <tr>
                <td><label for="password">Password</label></td>
                <td><input id="password" name="password" type="password"></td>
            </tr>
            <tr>
                <td><label for="confirm_password">Confirm password</label></td>
                <td><input id="confirm_password" name="confirm_password" type="password"></td>
            </tr>
            
                       
        </table>
        <p>
            <input class="submit" type="submit" value="Submit">
        </p>
    </form>
   
</div>
</body>
</html>


<?php //require_once("include/footer.php"); ?>