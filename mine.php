<?php /* This files provides the array PHP can use to match a file extension to its mine type, I am using this instead of a .htaccess file in the unlikely event that .htaccess files don't work  */
$mine_type = array(
										"jpg" => "image/jpeg",
										"jpeg" => "image/jpeg",
										"pdf" => "application/pdf",
										"mp3" => "audio/mpg", 
										"exe" => "application/octet-stream",
										"zip" => "application/octet-stream",
									);
/* Please only edit this array */ 

$folderscan = dirname(__FILE__); 
/* This sets the $folderscan variable to the current folder */

$ignore_files = array(".","..","index.php","main.css"); 
/* Since we shall flip the $folder, we need to tell it which values to unset, The easiest way I found was to use an array to store the values */

$folder = scandir("{$folderscan}/store");
/* This defines the $folder variable which we use later */

$folder = array_flip($folder);
/* This flips the $folder array so we can unset the values */

foreach ($ignore_files as $i)
{
	unset($folder[$i]);
}

$folder = array_flip($folder);
/* We flipped the array earlier, so we need to flip it the right way */
?>