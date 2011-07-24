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
    <a href="progress.php">Progress</a>
    <a href="statistic.php">Statistic</a>
  </div>
  <div id=content>
<p>Download a file</p>
<form method="POST">
Url: &nbsp;&nbsp;&nbsp;<input type="text" name="url" size=65><br>
Pass: <input type="password" name="password" size=10>
<input type="submit" name="submit" value="start">
</form><br>
<?php
require('config.php');
if($_POST['password'] == PASSWORD) {
$logname=md5($_POST['url']);
$filename=split('/', $_POST['url']);
$filename=end($filename);
$ret=system("/usr/bin/wget -b -c -a ".LOGDIR.$logname." -O ".DOWNLOADS.$filename." ".escapeshellcmd($_POST['url']));
preg_match("([0-9]+)", $ret, $pid);
$pidfile=fopen(DATADIR.$logname, "w");
fwrite($pidfile, $pid[0]);
fclose($pidfile);
echo "<meta http-equiv=\"refresh\" content=\"1;URL=progress.php\" />";
} elseif(!empty($_POST['submit'])) {
  echo "Password wrong!";
}
?>
</br>
</div>
</div>
</body>
</html>
