<?php
	require_once('../class/connecti.class.php');
    require_once('../class/users.class.php');

    session_start();
    if (empty($_SESSION['user_id'])) 
    {
        header("LOCATION:index.php");
    }

    //$userId = $_GET['id'];
    $userId = $_SESSION['user_id'];

	$cropedImage = $_POST['cropedImageContent'];
    $pos = strpos($cropedImage, ',');
    $rest = substr($cropedImage,$pos); 
    $data = base64_decode($rest);
    //$cropedImage = imagecreatefromstring($data);

    //$img = Image::make($data);
    //$img = $img->resize(150, 150);
    //
    $name = $_FILES['file']['name'];
    $temp = explode('.',$name);
    $extention = array_pop($temp);
    
    $fileName = md5(uniqid(rand()));
    $fileName = $fileName.".".$extention;

    $fileLocation = "images/users/".$fileName;
    file_put_contents ($fileLocation,$data);

    $userObj = new User();
    $user = $userObj->UploadImage($userId,$fileName);
    var_dump($user);
?>

