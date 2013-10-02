<?php $folder = dirname(__FILE__); 
/* This sets the $folderscan variable to the current folder */

$ignore_files = array(".", "..", "index.php", "main.css", ".htaccess","skip.png","getid3"); 
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
/* We flipped the array earlier, so we need to flip it the right way */
?><!DOCTYPE html>
<html lang="en-GB">
<head>
<title>File Storage Area</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<?php echo "<h1><a href=\"#files\" tabindex=\"1\"><img src=\"skip.png\" alt=\"Skip to Folder Contents\"></a>\n";
echo "File Storage Area\n</h1>\n";
echo "<div id=\"filebox\">\n";
echo "<h2><a id=\"files\">Main File Listing</a></h2>\n";
echo "<table>\n";
echo "<thead>\n";
echo "<tr>\n";
echo "<th>Filename</th>\n";
echo "<th>Size</th>\n";
echo "<th>Last Modified</th>\n";
echo "</tr>\n";
echo "</thead>\n";
echo "<tbody>\n";
if(empty($folder)==TRUE)
{
	echo "<tr>\n";
	echo "<td colspan=\"3\"><div id=\"cent\">\n<hr>\nThis folder is empty!</div></td>\n";
	echo "</tr>\n";
}
else
{
	foreach($folder as $key => $furl)
	{
		echo "<tr>\n";
		$filename 	= str_replace("_", " ", $furl);
		$filename 	= substr($filename, 0, -4);
		$filename 	= ucwords($filename);
		/* Because spaces must be replaced with underscores, we need to replace underscores with spaces */
		$furl = "{$furl}";
		echo "<td><a href=\"index.php?file={$key}\">{$filename}</a></td>\n";
		/* This sets the URL to the key matching the file specified by $folder and capitalizes each word */	
		echo "<td>" , number_format(filesize($furl) / 1024000,2), "MB</td>\n";
		/* This works out the filesize in MB */
		echo "<td>" , date("d/m/Y, H:i:s", filemtime($furl)), "</td>\n";
		/* This creates the file modification date */
		echo "</tr>\n";
	}
}	
/*We do not need to perform a htmlentities check, as we are not allowing users to upload files to our server. We would need to check the filenames, if we did, in case the contain HTML as this would cause problems */
echo "</tbody>\n";
echo "</table>\n";
echo "</div>\n";
$file = (int)$_GET["file"];
if(empty($file)==FALSE)
{
	echo "<div id=\"extend\">\n";
	echo "<h2><a id=\"extra\">Extra File Information</a></h2>\n";
	if(array_key_exists($file, $folder)==FALSE)
	{
		echo "<p>This file doesn't exist</p>\n";
	}
	else
	{
		require_once("getid3/getid3.php");
		/* This requires the getid3.php class*/
		$file_url 			= "{$folder[$file]}"; 
		$getID3 			= new getID3;
		$tags 				= $getID3->analyze($file_url);
		$extension		= end(explode(".", $file_url));
		if($extension== "mp3")
		{	
			echo "<table>\n";
			echo "<tr>\n";
			echo "<td>Titlw</td>\n";
			echo "<td>{$tags['tags']['id3v2']['title'][0]}</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Artist</td>\n";
			echo "<td>{$tags['tags']['id3v2']['artist'][0]}</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Album</td>\n";
			echo "<td>{$tags['tags']['id3v2']['album'][0]}</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Direct Download</td>\n";
			echo "<td><a href=\"/{$file_url}\">Click Here</a></td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td colspan=\"2\"><audio controls>\n<source src=\"{$file_url}\" type=\"audio/mpeg\">\n</audio></td>\n";
			echo "</tr>\n";
			echo "</table>\n";
			/* If the file is an MP3 file, it will be played using HTML5 audio */
		}
		else
		{
			echo "<p><a href=\"{$file_url}\">Download or View</a></p>";
		}
	}
	echo "</div>";
}
?>
</body>
</html>