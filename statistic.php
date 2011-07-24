<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PHP-GET</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id=container>
  <div id=header>
    <h1>PHP-GET</h1>
    <p class=subheading>A web interface for wget</p>
  </div>
  <div id=sidebar>
    <a href="download.php">Download</a>
    <a href="progress.php">Progress</a>
  </div>
  <div id=content>
    <table cellspacing=5 border="0">
      <tr>
	<th width=350><h3>Filename</h3></th>
	<th align=right><h3>Size</h3></th>
	<th></th>
      </tr>
<?php

require('config.php');
require('parse.php');

$dHandle=opendir(DOWNLOADS);
$i=0;
while(false !== ($file = readdir($dHandle))) {

  if($file != "." && $file != "..") {
	$size += filesize(DOWNLOADS."/".$file);
    echo "<tr><th>$file</th>
	  <th>".round(filesize(DOWNLOADS.$file)/1048576,1)."MB</th></tr>";

    $i++;
  }

}
closedir($dHandle);
echo "Total Size: ".round($size/1048576,1)."MB";
?>
</br>
</table>
</div>
</div>
</body>
</html>