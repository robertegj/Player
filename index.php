<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>who-loo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="This is a default index page for a new domain."/>
    <style type="text/css">
        body {font-size:10px; color:#777777; font-family:arial; text-align:center;}
        h1 {font-size:64px; color:#555555; margin: 70px 0 50px 0;}
        p {width:320px; text-align:center; margin-left:auto;margin-right:auto; margin-top: 30px }
        div {width:320px; text-align:center; margin-left:auto;margin-right:auto;}
        a:link {color: #34536A;}
        a:visited {color: #34536A;}
        a:active {color: #34536A;}
        a:hover {color: #34536A;}
    </style>
</head>

<script src="jquery.js"></script>
<script src="jquery.audioControls.js"></script>
<script>
$(document).ready(function()
{
$("#playListContainer").audioControls(
{
autoPlay : true,
timer: 'increment',
onAudioChange : function(response){
$('.songPlay').text(response.title + ' ...'); //Song title information
},
onVolumeChange : function(vol){
var obj = $('.volume');
if(vol <= 0){
 obj.attr('class','volume mute');
 }
else if(vol <= 33)
{
 obj.attr('class','volume volume1');
 }
else if(vol > 33 && vol <= 66)
{
 obj.attr('class','volume volume2');
 }
else if(vol > 66)
{
obj.attr('class','volume volume3');
}
else
{
obj.attr('class','volume volume1');
}
}
});
});
</script>

<body>
    <h1><a href="../../"><font color="lightgreen">who-loo</font></a></h1>
	<h2>We TV</h2>
	<h3>
	<ol id="playListContainer" style="list-style-type: decimal;">
	<?php
			error_reporting(E_ALL);
			ini_set('display_errors', 1);
			$max_file_size = 1024*10000000; //a lot of kb
			$path = ""; // Upload directory
			$count = 0;
			$files = 0;	
				
			if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
				// Loop $_FILES to exeicute all files
				foreach ($_FILES['files']['name'] as $f => $name) {     
					if ($_FILES['files']['error'][$f] == 4) {
						continue; // Skip file if any error found
					}	       
					if ($_FILES['files']['error'][$f] == 0) {	           
						if ($_FILES['files']['size'][$f] > $max_file_size) {
							$message[] = "$name is too large!.";
							continue; // Skip large files
						}
						else{ // No error found! Move uploaded files 
							if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name))
							$count++; // Number of successfully uploaded file
						}
					}
				}
				// echo "<META HTTP-EQUIV='refresh' CONTENT='0'>";
			}
			
			if(isset($_GET['d'])){
				$file_name=$_GET['d'];
				$enc_file=urldecode($file_name);
				unlink($enc_file);
				echo "<mark>'" . $file_name . "' has been deleted. </mark><br>";
			}

			foreach (glob("files/*") as $filename) {
			$shortname = basename($filename);
				  echo "<li data-src='$filename'><a href='#'>". $shortname . "<br>" . "</a></li>";
			}

	?>
	</ol>
	</h3>
		<form action="" method="post" enctype="multipart/form-data">
		<input type="file" id="file" name="files[]" multiple="multiple" accept="*" />
		<input id="ac-button" type="submit" value="Upload" />
	</form><br>
    <div>
        <a href="http://anicyber.com">Powered by Anicyber</a>
    </div>
</body>

</html>

