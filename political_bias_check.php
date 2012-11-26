<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="imagetoolbar" content="no" />
        <meta name="robots" content="noindex, nofollow" />
        <meta http-equiv="Cache-Control" content="no-cache" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta name="author" content="Gerrit Holz" />

        <title>Political Bias Check</title>
</head>

    <body>
    <h1>Purpose: Compare concepts.txt with MySQL table bundestagsprotokolle and write <i>Faction</i>, <i>Concept</i> and <i>Number of Tokens</i> to results.csv</h1>

    <?php
    // Author: Gerrit Holz

    // set timeout and make error reporting explicit
    set_time_limit (18000);
    ini_set ('error_reporting', E_ALL);

    // connect to database
    $db = mysql_connect('localhost', 'root', 'MBeq42oQ2dt?');
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

    // delete csv
    unlink('results.csv');
	
    //define variables
    $terms = "terms.txt";
    $factions = "factions.txt";
    $start_faction = 0;

    //read file terme line by line and print
    print "<h2>Counting tokens of the following concepts:</h2><br>";
    $f = fopen($terms, "r");
    while ( $line = fgets($f) ) {
    print $line . "<br>";
    }

    //read file terme line by line and print
    print "<h2>Counting tokens in speeches of the following factions:</h2><br>";
    $f = fopen($factions, "r");
    while ( $line = fgets($f) ) {
    print $line . "<br>";
    }

    print "<h2>Here we have results:</h2><br>";

    //start loop terms line by line
    for($start_term = 0; $start_term < 5000; $start_term++) {

    // put text from file line by line into array_begriff
    $array_concept = file($terms, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $concept = $array_concept[$start_term];
    $concept_trimmed = rtrim($concept);

    //start loop fraktionen
    for($start_faction = 0; $start_faction < 5; $start_faction++) {

    // put $factions line by line into $array_factionen and kill whitespace at the end of the line
    $array_faction = file($factions, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $partei = $array_faction[$start_faction];
    $faction_trimmed = rtrim($partei);

    //compare term to content in database
    $sqlquery = " SELECT SUM((LENGTH(TEXT) - LENGTH(REPLACE(TEXT, '$concept_trimmed', ''))) / LENGTH('$concept_trimmed')) 
					     AS frequency
					     FROM bundestagsprotokolle
					     WHERE TEXT LIKE '%$concept_trimmed%'
					     AND speaker2 LIKE '%$faction_trimmed%'";
					
    $query = mysql_query($sqlquery);					
    if (!$query) print "Query failed!";

    //display results
    print "\r\n<br>";
    $output = (int) mysql_result($query, 0, "frequency");
    print $output . " tokens for \"" . $concept_trimmed . "\", which have been used by " . $faction_trimmed or die('Error, Query failed.');

    //write values from array to csv
    $list = array (
        array($concept_trimmed, $faction_trimmed, $output)
    );

    $fp = fopen('results.csv', 'a');
    foreach ($list as $fields) {
      fputcsv($fp, $fields);
    }
    fclose($fp);
    }
    }
    print "<h2>Now we're done. Fine.</h2><br>";
    ?>
    </body>
</html>
