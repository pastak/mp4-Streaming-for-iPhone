<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=SHIFT-JIS" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<!--
<link rel="apple-touch-icon" href="iui/iui-logo-touch-icon.png" />
-->
<meta name="apple-touch-fullscreen" content="YES" />
<style type="text/css" media="screen">@import "iui/iui.css";</style>
<script type="application/x-javascript" src="iui/iui.js"></script>
<style>
	.infomation{
		-webkit-border-radius:10px;
		background-color:white;
		min-height:50px;
		padding:5px;
	}
</style>
</head>

<body>
<div class="toolbar">
        <h1 id="pageTitle"></h1>
        <a id="backButton" class="button" href="#"></a>
</div>
<?php
	$loadDirList=array(
	"D:/toOrb/MP4",
	"D:/videos"
	);
	$videofiles=array();
	$i=0;
	echo"<ul id='home' title='Video' selected='true'>\n";
	foreach($loadDirList as $path){
		if($handle = opendir($path)){
			while (false !== ($file = readdir($handle))) {
				if($file == "." || $file == ".."){
					continue;
				}
				$videofiles[$i++]=array($path."/".$file,$file);
				echo"<li><a href='#$i'>$file</a></li>\n";
			}
		}
	}
	echo"</ul>\n";
?>
<?php
	$j=0;
	foreach($videofiles as $video){
		echo'<div id="'.$j++.'" class="panel" title="Now Playing">'."\n\t";
		echo"<h2>".$video[1]."</h2>\n";
		echo"<embed style='margin:5px;' width='240' height='160' src='getmp4.php?p=".urlencode($video[0])."' type='video/mp4'/><br />\n";
		echo"<div class='infomation'>\n";
		echo"<span style='font-weight:bold;'>Local File Path</span><br />$video[0]\n";
		echo"</div>\n";
		echo"</div>\n";
}
?>
</body>
</html>