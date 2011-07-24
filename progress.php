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
    <a href="statistic.php">Statistic</a>
  </div>
  <div id=content>
    <table cellspacing=5 border="0">
      <tr>
	<th width=350><h3>Filename</h3></th>
	<th align=right><h3>Size</h3></th>
	<th align=right><h3>Rcved</h3></th>
	<th align=right><h3>Percent</h3></th>
	<th align=right><h3>Speed</h3></th>
	<th align=right><h3>Status</h3></th>
	<th></th>
      </tr>
<?php

require('config.php');
require('parse.php');

$dHandle=opendir(LOGDIR);
$i=0;
while(false !== ($file = readdir($dHandle))) {

  if($file != "." && $file != "..") {
  $Task = new parse_log(LOGDIR.$file);

  if(isset($_GET['del']) && $file==$_GET['del']) {
    if($Task->Finished==true) {
      unlink(mysql_escape_string(LOGDIR.$file));
      unlink(mysql_escape_string(DATADIR.$file));
      exit;
    } else {
      $pidfile=fopen(DATADIR.$file, "r");
      $pid=fread($pidfile, 5);
      fclose($pidfile);
      exec("/bin/kill -9 $pid");
      $ret = unlink(mysql_escape_string(LOGDIR.$file));
      if($ret == false) { echo "<th align=right><font color=red>There was an error removing the logfile.</font></th>"; }
      $ret = unlink(mysql_escape_string(DATADIR.$file));
      if($ret == false) { echo "<th align=right><font color=red>There was an error removing the logfile.</font></th>"; }
      exit;
    }
}
//   echo "Error: ".$Task->Error."<br>";
  if($Task->Finished) { echo "<tr><th><a href=getFile.php?file=$Task->File>".$Task->File."</a></th>"; } else { echo "<tr><th>".$Task->File."</th>"; }
  echo "<th align=right>".$Task->Size."</th>";
  echo "<th align=right>".$Task->Downloaded."</th>";
  echo "<th align=right>".$Task->Process."</th>";
  echo "<th align=right>".$Task->Speed."</th>";
  if($Task->Finished) { echo "<th align=right>Completed</th><th><a href=?del=$file><font color=red>delete</font></a></th></tr>"; } else { echo "<th align=right>Loading</th><th><a href=?del=$file>delete</a></th></tr>"; }


    $i++;
  }

}
?>
</br>
</table>
</div>
</div>
</body>
</html>