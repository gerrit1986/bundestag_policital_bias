<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="author" content="Gerrit Holz" />
<link rel="stylesheet" type="text/css" href="../style.css">

<title>Counting Words in MySQL Database</title>
</head>

	<body>
		<h1>wordcount.php</h1>
		<p>Purpose: Count all words in speeches in MySQL table bundestagsprotokolle and 
		print <i>number of words</i> for a specific <i>faction</i> to page.</p>
		<p>
		<?php
		/* Author: Gerrit Holz

		set timeout and make error reporting explicit*/
		set_time_limit (6000);
		ini_set ('error_reporting', E_ALL);

		// connect to database
		$db = mysql_connect('localhost', 'root', 'password');
		if (!$db) {
    			die('Unable to connect: ' . mysql_error());
			}

		// make btagprot_utf the current db
		$db_selected = mysql_select_db('btagprot_utf', $db);
			if (!$db_selected) {
    			die ('Could not use btagprot_utf: ' . mysql_error());
			}

		// use utf-8
		mysql_query("SET CHARACTER SET 'utf8'");

		// define variables
		$faction = $_POST["faction"];
		$counter = 0;

		// load all database data in an array
		$result_set = mySQL_query(	"SELECT `text` 
									FROM `bundestagsprotokolle` 
									WHERE `speaker2` LIKE  '%$faction%'
									AND (`type` = 'speech' OR `type` = 'poi');")
									or die(mysql_error());
							
		$array = mySQL_fetch_array($result_set, MYSQL_ASSOC);
										
		// start loop											
		while(is_array($array))
		{$array = mySQL_fetch_array($result_set, MYSQL_ASSOC);
		$text = $array["text"];
		$words = explode(" ", $text);
		$words = array_filter($words);
		$array_size = count($words);
		$list = array (array($faction, $array_size));
		$counter = $counter + $array_size;
		}

		print "Result for $faction: " . $counter;

		?>
		</p>
		<p><a href  ="../index.html">back</a></p>
	</body>
</html>
