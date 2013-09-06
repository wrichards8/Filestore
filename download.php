<?php require_once("mine.php");
$id = (int)$_GET["id"];
if(empty($id)==TRUE)
{
	die("Please go back and select a file");
}
else
{
	if(array_key_exists($id, $folder)==FALSE)
	{
		echo "<p>This file doesn't exist</p>\n";
		/* This checks to see if the file is in the folder's array */
	}
	else
	{
		$media			= file_get_contents("store/{$folder[$id]}");
		/* This will extract the contents of the file chosen */
		$ending 			= end(explode(".", $folder[$id]));
		/* This will get the file extension from the end of the file */
		$mine_type 	= array_flip($mine_type);
		/* This will flip the array */
		if(in_array($ending, $mine_type)==FALSE)
		{
			die("You can't download this file");
			/* This checks if the file extension exists in the array */
		}
		else
		{
			$mine_type 	= array_flip($mine_type);
			/* This flips the array back which gives the mime type */
			header("Content-Type: {$mine_type[$ending]}");
			include($media);
		}
	}
}
?>