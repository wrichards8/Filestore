<?php if(file_exists("store")==FALSE)
{
	mkdir("store");
	/* If the "store" folder isn't found, it will be created */
}
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
<title>File Storage Area</title>
<link rel= "stylesheet" type= "text/css" href= "main.css">
</head>
<body>
<?php $folderscan = dirname(__FILE__); 
/* This sets the $folderscan variable to the current folder */
$ignore_files = array(".","..","index.php","main.css"); 
/* Since we shall flip the $folder, we need to tell it which values to unset, The easiest way I found was to use an array to store the values */
$folder = scandir("{$folderscan}/store");
/* This defines the $folder variable which we use later */
echo "<h1>File Storage Area</h1>\n";
$folder = array_flip($folder);
/* This flips the $folder array so we can unset the values */
foreach ($ignore_files as $i)
{
	unset($folder[$i]);
}
$folder = array_flip($folder);
/* We flipped the array earlier, so we need to flip it the right way */
echo "<div id=\"filebox\">\n";
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
	echo "<td colspan=\"3\"><p>This folder is empty!</p></td>\n";
	echo "</tr>\n";
}
else
{
	foreach($folder as $folder)
	{
		echo "<tr>";
		$filename = str_replace("_"," ", $folder);
		/* Because spaces must be replaced with underscores, we need to replace underscores with spaces */
		echo "<td><a href=\"{$folder}\">", ucwords($filename) ,"</a></td>\n";
		/* This sets the URL to the file specified by $folder and capitalizes each word */	
		echo "<td>" , number_format(filesize($folder) / 1024000,2), "MB</td>\n";
		/* This works out the filesize in MB */
		echo "<td>" , date("d/m/Y, H:i:s", filemtime($folder)), "</td>\n";
		/* This creates the file modification date */
		echo "</tr>\n";
	}
}	
/*We do not need to perform a htmlentities check, as we are not allowing users to upload files to our server. We would need to check the filenames, if we did, in case the contain HTML as this would cause problems */
?>
</tbody>
</table>
</div>
</body>
</html>
