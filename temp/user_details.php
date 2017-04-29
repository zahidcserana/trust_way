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

  	$userObj = new User();
 	$user = $userObj->GetUserDetails($userId);

 	$photoUrl = 0;
?>
<?php
    include_once('include/top.php');
    
?>
<h3><u>Personal Details</u></h3>

<div class="f_section">
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-md-3 col-sm-3 col-xs-4 f_label">Upload Image</label>
            <div class="col-md-5 col-sm-5 col-xs-8">
            <?php
            if($user['image']=='')
            {?>
        		<img src="images/avator.png" id="base_image" alt="..." style="max-width: 150px; max-height: 150px">
            <?php
        	}
            else
            {?>
        		<img src="<?php echo 'images/users/'.$user['image'];?>" id="base_image" alt="..." style="max-width: 150px; max-height: 150px">
            <?php
        	}
            ?>
                <div class="btn-group-vertical">
                    <a href="javascript:void(0)" id="picture_change" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="f_section">
		<form action="" method="POST" role="form" class="form-horizontal" id="pd_forms" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="id" value="$user['id']">
		
			<div class="form-group">
				<label class="col-md-3 col-sm-4 col-xs-4 f_label">User Name</label>
				<div class="col-md-5 col-sm-6 col-xs-8">
					<input type="text" name="username" class="form-control" value="<?php echo $user['username'];?>" required/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-sm-4 col-xs-4 f_label">Email Address</label>
				<div class="col-md-5 col-sm-8 col-xs-8">
					<input type="email" name="email" class="form-control" value="<?php echo $user['email'];?>" required/>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<button type="submit" class="btn btn-save-continue" id="save_pd_btn"><i class="fa fa-pencil"></i> Update</button>
				</div>
			</div>
		</form>
	</div>

	<div class="modal fade" id="modalChangePicture" role="dialog">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <!--<div class="modal-header">
	                <button id="modal_close" type="button" class="close" data-dismiss="modal">x</button>
	                <h4 class="modal-title">Upload image</h4>
	            </div>-->
	            <div class="modal-body">
	                <div class="f_section">
	                	<div align="center">
			                <h4>Upload image</h4>
			            </div>
						<div class="col-md-12" id="upImage" style="text-align: center;">
						  <div id="image-div1">
							<img id="image_upload" src="" style="width: 100%;" alt="..." style='display: none;'>
						  </div>
						  <img id="imageCropped" src="" style="display: none; width:100%;">
							<br>
							<br>
							<a href="javascript:void(0)" id="change_picture" class="btn btn-primary" style="display: none;">Change</a>
							<div class="btn-group-horizontal">
								<a href="javascript:void(0)" id="back" class="btn btn-primary" style="display: none;">Back</a>
								<a href="javascript:void(0)" id="save" class="btn btn-primary" style="display: none;">Save</a>
								<a href="javascript:void(0)" id="discard" class="btn btn-primary" style="display: none;">Cancel</a>
								<input type='button' id='getCroppedImage' class="btn btn-primary" value='Get Cropped Area' >
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<input type="file" id="imageFile" name="photo" style="display: none;">
							<br>
							<div class="progress" style="display: none;">
							  	<div id="progressBar" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
							</div>
						</div>
					</div>
	            </div>
	        </div>
	    </div>
	</div>

<!--javascript -->
	<script src="cropper/cropper.min.js"></script>
	<link rel="stylesheet" href="cropper/cropper.css">
	<style>
		img {
		  	max-width: 100%;
		}
	</style>
	<script>
		$(document).ready(function(){
			var cropper;
			var div2Width;
			var imageWidth;
			$("#change_picture").click(function()
			{ 
				$( "#imageFile" ).click();
			});
			$("#picture_change").click(function()
			{ 
				$( "#imageFile" ).click();
			});
			$( "#imageFile" ).change(function()
			{
				console.log('cropper created');
				var _URL = window.URL || window.webkitURL;
				img = new Image();
				img.onerror = function() { alert('Please chose an image file!'); };
        		img.onload = function () {
        			var imageWidth = this.width;
	        		$("#imageCropped").hide();
                  	$('#image_upload').attr('src',this.src);
                  	$("#image-div1").show();
                  	$("#change_picture").hide();
					$("#back").hide();
					$("#save").hide();
					$("#discard").show();
					$("#getCroppedImage").show();
                  	$('#modalChangePicture').modal('show');
       			};
        		img.src = _URL.createObjectURL(this.files[0]);
			});

			$("#getCroppedImage").click(function(){
				var imageSrc = cropper.getCroppedCanvas().toDataURL('image/jpeg');
				$("#image-div1").hide();
				$("#imageCropped").show();
				$("#imageCropped").attr('src', imageSrc );
				$("#save").show();
              	$("#discard").show();
              	$("#back").show();
              	$("#change_picture").hide();
              	$("#getCroppedImage").hide();
        		
			});

			$( "#save" ).click(function()
			{
				$(".progress").show();
				var img = document.getElementById('imageFile');
				var cropedImg = $('#imageCropped').attr('src');
				$('#base_image').attr('src',cropedImg);
				var data = new FormData();
				data.append('file', img.files[0]);
				data.append('cropedImageContent', cropedImg);
				var Url = "image_upload.php";

	            var xhr = new XMLHttpRequest();
	            xhr.upload.addEventListener('progress',function(ev){
	                var progress = parseInt(ev.loaded / ev.total * 100);
	                $('#progressBar').css('width', progress + '%');
	                $('#progressBar').html(progress + '%');
	            }, false);
	            xhr.onreadystatechange = function(ev)
	            {
	            	console.log(xhr.readyState);
	                if(xhr.readyState == 4){
	                    if(xhr.status = '200')
	                    {
	                		$("#imageCropped").hide();
	                		$(".progress").hide();
							$("#save").hide();
							$("#back").hide();
	        				$("#discard").hide();
                			$("#getCroppedImage").hide();
                			$('#progressBar').css('width','0' + '%');
	                		$('#progressBar').html('0' + '%');
	                		$('#modalChangePicture').modal('hide');
	                    }
	                    
	                }
	            };
	            xhr.open('POST', Url , true);
	            xhr.send(data);
	            return false;
			});

			$( "#back" ).click(function()
			{	
				$("#image-div1").show();
				$("#imageCropped").hide();
				$("#discard").show();
                $("#getCroppedImage").show();
				$("#save").hide();
				$("#back").hide();
				$("#change_picture").hide();
				
			});

			$( "#discard" ).click(function()
			{	
				$('#modalChangePicture').modal('hide');
			});

			$("#modalChangePicture").on('hidden.bs.modal', function () {
				console.log('hide modal');
				cropper.destroy();
				$("#imageFile").val("");
			});

			$('#modalChangePicture').on('shown.bs.modal', function() {
				var div2Width = $("#upImage").width();
	          	if (this.width<div2Width) 
	          	{
	          		document.getElementById('image-div1').style.width = this.width;
	          	}
	          	var image = document.getElementById('image_upload');
	          	
				cropper = new Cropper(image, {
				  aspectRatio: 1,
				  crop: function(e) {
					console.log(e.detail.x);
					console.log(e.detail.y);
					console.log(e.detail.width);
					console.log(e.detail.height);
					console.log(e.detail.rotate);
					console.log(e.detail.scaleX);
					console.log(e.detail.scaleY);
				  }
				});
			});
		});
	</script>

<?php
  	include('include/footer.php');
?>