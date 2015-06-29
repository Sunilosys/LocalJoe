<?php

// Sets the file header to show this is an XML file
header("Content-type: text/xml");
 
$directory = dirname(__FILE__);
$dir_last_modified_time = dirmtime($directory);
$dir_last_modified_time = date('Y-m-d', $dir_last_modified_time);

$dbConfig = parse_ini_file('../application/configs/config.ini', 'production');
$connection = null;

// The xml header is written this way to avoid the <? tags being seen as code
// by PHP (a problem if short_open_tag == 1)
echo('<?xml version="1.0" encoding="UTF-8"?>');

$rootUrl = $dbConfig['production']['website_url'];

echo('<urlset xmlns="http://www.google.com/schemas/sitemap/0.9">');

//Home page
echo('<url>');
echo('<loc>');
echo($rootUrl . '#page=home');
echo('</loc>');
echo('<lastmod>');
echo($dir_last_modified_time);
echo('</lastmod>');
echo('<changefreq>');
echo('Monthly');
echo('</changefreq>');
echo('<priority>');
echo('1.0');
echo('</priority>');
echo('</url>');

//Create Post page
echo('<url>');
echo('<loc>');
echo($rootUrl . '#page=createpost');
echo('</loc>');
echo('<lastmod>');
echo($dir_last_modified_time);
echo('</lastmod>');
echo('<changefreq>');
echo('Monthly');
echo('</changefreq>');
echo('<priority>');
echo('1.0');
echo('</priority>');
echo('</url>');

//My Account Page
echo('<url>');
echo('<loc>');
echo($rootUrl . '#page=profile');
echo('</loc>');
echo('<lastmod>');
echo($dir_last_modified_time);
echo('</lastmod>');
echo('<changefreq>');
echo('Monthly');
echo('</changefreq>');
echo('<priority>');
echo('1.0');
echo('</priority>');
echo('</url>');
//Search Page
echo('<url>');
echo('<loc>');
echo($rootUrl . '#page=search');
echo('</loc>');
echo('<lastmod>');
echo($dir_last_modified_time);
echo('</lastmod>');
echo('<changefreq>');
echo('Monthly');
echo('</changefreq>');
echo('<priority>');
echo('1.0');
echo('</priority>');
echo('</url>');
if (isset($dbConfig)) {
    try {
        $connection = mysql_connect($dbConfig['production']['db.params.host'], $dbConfig['production']['db.params.username'], $dbConfig['production']['db.params.password']) or die(mysql_error());
        mysql_select_db($dbConfig['production']['db.params.dbname']) or die(mysql_error());
        $result = mysql_query("SELECT * FROM posting where posting_status_id = 2")
                or die(mysql_error());
        $noOfPostings = mysql_num_rows($result);
        if ($result && isset($noOfPostings) && $noOfPostings > 0) {
            while ($row = mysql_fetch_assoc($result)) {
                echo('<url>');
                echo('<loc>');
                echo($rootUrl . 'api/post/' . $row['posting_id']);
                echo('</loc>');
                echo('<lastmod>');
                echo(date_format(date_create($row['date_updated']), "Y-m-d"));
                echo('</lastmod>');
                echo('<changefreq>');
                echo('Daily');
                echo('</changefreq>');
                echo('<priority>');
                echo('1.0');
                echo('</priority>');
                echo('</url>');
            }
        }
    } catch (Exception $ex) {
        mysql_close($connection);
    }
}

echo('</urlset>');

//======================== START OF FUNCTION ==========================//
// FUNCTION: dirmtime                                                  //
//=====================================================================//
   /**
    * Returns the last modified time of the directory
    * @param string $directory
    * @return int
    */
function dirmtime($directory) {
    // 1. An array to hold the files.
    $last_modified_time = 0;

    // 2. Getting a handler to the specified directory
    $handler = opendir($directory);

    // 3. Looping through every content of the directory
    while ($file = readdir($handler)) {
        // 3.1 Checking if $file is not a directory
        if(is_file($directory.DIRECTORY_SEPARATOR.$file)){
            $files[] = $directory.DIRECTORY_SEPARATOR.$file;
            $filemtime = filemtime($directory.DIRECTORY_SEPARATOR.$file);
            if($filemtime>$last_modified_time) {
                $last_modified_time = $filemtime;
            }
	}
    }

    // 4. Closing the handle
    closedir($handler);

    // 5. Returning the last modified time
    return $last_modified_time;
}
//=====================================================================//
//  FUNCTION: dirmtime                                                 //
//========================== END OF METHOD ============================//
?>