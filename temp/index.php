<?php 
    require_once('../class/connecti.class.php');
    require_once('../class/users.class.php');

    session_start();
    if (!empty($_SESSION['user_id'])) 
    {
        header("LOCATION:user_details.php");
    }

    $msg = '';
    
    if (isset($_POST['submit'])) 
    {
        if (!$_POST['email'] ||!$_POST['password'] ) 
        {
            $msg = '<div class="alert alert-warning">
                      <strong>Warning!</strong> Missing parameter .
                    </div>';
        }
        else
        {
            $email = $_POST['email'];
            $password = md5($_POST['password']);

            $userObj = new User();
            $register = $userObj->GetUserInfo($email,$password);
            if ($register) 
            {
                session_start();
                $_SESSION['username']=$register['username'];
                $_SESSION['user_id']=$register['id'];

                header("LOCATION:user_details.php");
                //include('products.php');


            }
            else
            {
                $msg = '<div class="alert alert-warning">
                      <strong>Warning!</strong> Wrong email password.
                    </div>';
            }
            
        }
    }
?>

<?php
    include_once('include/top.php');
    echo $msg;
?>

    
    <!-- /.row -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <div id="login-overlay" class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" id="myModalLabel">Login here</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xs-6">
                      <div class="well">
                          <form id="loginForm" method="POST" action="" novalidate="novalidate">
                              <div class="form-group">
                                  <label for="email" class="control-label">email</label>
                                  <input type="text" class="form-control" id="email" name="email" value="" required="" title="Please enter you email" placeholder="Enter your email">
                                  <span class="help-block"></span>
                              </div>
                              <div class="form-group">
                                  <label for="password" class="control-label">Password</label>
                                  <input type="password" class="form-control" id="password" name="password" value="" required="" title="Please enter your password">
                                  <span class="help-block"></span>
                              </div>
                              <div id="loginErrorMsg" class="alert alert-error hide">Wrong username og password</div>
                              <div class="checkbox">
                                  <label>
                                      <input type="checkbox" name="remember" id="remember"> Remember login
                                  </label>
                                  <p class="help-block">(if this is a private computer)</p>
                              </div>
                              <button name="submit" type="submit" class="btn btn-success btn-block">Login</button>
                              <a href="/forgot/" class="btn btn-default btn-block">Help to login</a>
                          </form>
                      </div>
                  </div>
                  <div class="col-xs-6">
                      <p class="lead">Register now for <span class="text-success">FREE</span></p>
                      <ul class="list-unstyled" style="line-height: 2">
                          <li><span class="fa fa-check text-success"></span> See all your orders</li>
                          <li><span class="fa fa-check text-success"></span> Fast re-order</li>
                          <li><span class="fa fa-check text-success"></span> Save your favorites</li>
                          <li><span class="fa fa-check text-success"></span> Fast checkout</li>
                          <li><span class="fa fa-check text-success"></span> Get a gift <small>(only new customers)</small></li>
                          <li><a href="/read-more/"><u>Read more</u></a></li>
                      </ul>
                      <p><a href="register.php" class="btn btn-info btn-block">Yes please, register now!</a></p>
                  </div>
              </div>
          </div>
      </div>
  </div>

           

<?php
  include('include/footer.php');
?>
