<?php if(file_exists("store")==FALSE)
{
	mkdir("store");
	/*If the "store" folder does not exist then it will be created dynamically */
}
$folder = dirname(__FILE__)."/store"; 
/* This sets the $folderscan variable to the current folder */

$ignore_files = array(".", "..", "index.php", "main.css", ".htaccess"); 
/* Since we shall flip the $folder, we need to tell it which values to unset, The easiest way I found was to use an array to store the values */

$folder = scandir($folder);
/* This defines the $folder variable which we use later */

$folder = array_flip($folder);
/* This flips the $folder array so we can unset the values */

foreach ($ignore_files as $i)
{
	unset($folder[$i]);
}

$folder = array_flip($folder);
/* We flipped the array earlier, so we need to flip it the right way */ ?>