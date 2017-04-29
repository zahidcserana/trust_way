<?php
	require_once __DIR__."/class/database.class.php";
    require_once dirname(__FILE__).'/class/user_info.class.php';

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

    //var_dump($userId,$fileName);

    $userObj = new UserInfo();
    $user = $userObj->UploadImage($userId,$fileName);

   // return json_encode(array('success'=>'true','file_name'=>$fileLocation));
?>

