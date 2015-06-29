<?php
require 'wp_config.php';

//End

$dbName = null;
$imageUrlHeader = "Image URL";
$imageAltHeader = "Image Alt";

$query = "SELECT pm1.meta_value AS image, pm2.meta_value AS image_alt
          FROM wp_posts as p
          LEFT JOIN wp_postmeta AS pm1 ON p.ID = pm1.post_id  AND pm1.meta_key='_wp_attached_file'
          LEFT JOIN wp_postmeta AS pm2 ON p.ID = pm2.post_id AND pm2.meta_key='_wp_attachment_image_alt' 
          WHERE p.post_type = 'attachment'";

$csv_file = "wordpress_images_alt_text_" . date("Y-m-d") . ".csv";

//Get the DB name from URL parameter
if (isset($_REQUEST['dbname'])) {
    $dbName = $_REQUEST['dbname'];
} else {
    echo "Database parameter is missing.";
    exit;
}


$connection = null;
$csv_output = NULL;

//CSV File Header
$csv_output .= '"' . str_replace('"', '""', $imageUrlHeader) . '",';
$csv_output .= '"' . str_replace('"', '""', $imageAltHeader) . '",';
$csv_output = substr($csv_output, 0, -1) . "\n";  // remove trailing "," and add a line break

//Connect to the database
$connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
mysql_select_db($dbName) or die(mysql_error());

//Database Query
$result = mysql_query($query)
        or die(mysql_error());

//Fetch rows
$noOfRows = mysql_num_rows($result);
if ($noOfRows > 0) {
    while ($row = mysql_fetch_assoc($result)) {
        foreach ($row as $key => $value) {
            $$key = $value;
            $$key = str_replace('"', '""', $$key);
            $var = $$key;
            $csv_output .= "\"$var\",";
        }
        $csv_output .= "\n";
    }
}

$size_in_bytes = strlen($csv_output);
$encoded = chunk_split(base64_encode($csv_output));
 
// create the email and send it off
 
$from = EMAIL_FROM;

// boundary
$semi_rand = md5(time());
$mime_boundary = "----=_NextPart_{$semi_rand}";

$headers = "From: $from";
// headers for attachment
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"$mime_boundary\"";  
// message
$message = "--$mime_boundary\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . BODY . "\n\n";
$message .= "--$mime_boundary\n";

$message .= "Content-Type: application/octet-stream; name=\"" . $csv_file. "\"\n" .
        "Content-Description: " . $csv_file . "\n" .
        "Content-Disposition: attachment;\n" . " filename=\"" . $csv_file . "\"; size=" . $size_in_bytes . ";\n" .
        "Content-Transfer-Encoding: base64\n\n" . $encoded . "\n\n";

 $message .= "--$mime_boundary--";
 
// now send the email
mail(EMAIL_TO, SUBJECT, $message, $headers, "-f$from");

?>


