<?php
    session_start();
    include_once('include/top.php');
?>
    <script src="lib/jquery.js"></script>
    <script src="dist/jquery.validate.js"></script>
    <script>

    $().ready(function() {
        // validate the comment form when it is submitted
        $("#commentForm").validate();

        // validate signup form on keyup and submit
        $("#signupForm").validate({
            rules: {
                firstname: "required",
                lastname: "required",
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
                email: {
                    required: true,
                    email: true
                },
                topic: {
                    required: "#newsletter:checked",
                    minlength: 2
                },
                agree: "required"
            },
            messages: {
                firstname: "Please enter your firstname",
                lastname: "Please enter your lastname",
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
                email: "Please enter a valid email address",
                agree: "Please accept our policy",
                topic: "Please select at least 2 topics"
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

<div class="f_section">
    <form  id="signupForm" method="post" action="register.php" role="form" class="form-horizontal" id="pd_forms" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-md-3 col-sm-4 col-xs-4 f_label">User Name</label>
            <div class="col-md-5 col-sm-6 col-xs-8">
                <input type="text" name="username" class="form-control" required/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 col-sm-4 col-xs-4 f_label">First Name</label>
            <div class="col-md-5 col-sm-6 col-xs-8">
                <input type="text" name="firstname" class="form-control" required/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 col-sm-4 col-xs-4 f_label">Last Name</label>
            <div class="col-md-5 col-sm-6 col-xs-8">
                <input type="text" name="lastname" class="form-control" required/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 col-sm-4 col-xs-4 f_label">Email Address</label>
            <div class="col-md-5 col-sm-8 col-xs-8">
                <input type="email" name="email" class="form-control"  required/>
            </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 col-sm-4 col-xs-4 f_label" for="password">Password</label>
          <div class="col-md-5 col-sm-8 col-xs-8">
            <input type="password" id="password" name="password" placeholder="" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 col-sm-4 col-xs-4 f_label"  for="confirm_password">Password (Confirm)</label>
          <div class="col-md-5 col-sm-8 col-xs-8">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 col-sm-4 col-xs-4 f_label" for="phone">Phone</label>
          <div class="col-md-5 col-sm-8 col-xs-8">
            <input type="phone" id="phone" name="phone" placeholder="" class="form-control">
          </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-4">
                <button type="submit" name="submit" class="btn btn-save-continue" id="save_pd_btn"><i class="fa fa-pencil"></i> Register</button>
            </div>
        </div>
    </form>
</div>





<?php require_once("include/footer.php"); ?>