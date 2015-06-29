<?php

$dbConfig = parse_ini_file('../../application/configs/config.ini', 'production');
$postConfig = parse_ini_file('../../application/configs/config.ini', 'posting');




define('DATABASE_SERVER', $dbConfig['production']['db.params.host']);
define('DATABASE_USER_NAME', $dbConfig['production']['db.params.username']);
define('DATABASE_USER_PWD', $dbConfig['production']['db.params.password']);
define('DATABASE_NAME', $dbConfig['production']['db.params.dbname']);

class extract {

    public static function getExtractSources() {
        $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
        mysql_select_db(DATABASE_NAME);

        $sourceResult = mysql_query("SELECT * FROM external_category_map")
                or die(mysql_error());
        $noOfSources = mysql_num_rows($sourceResult);
        if ($sourceResult && isset($noOfSources) && $noOfSources > 0) {
            return $sourceResult;
        }
        else
            return null;
    }

    public static function extractDataFromCraigslist($source) {

        $id = $source[0];
        $categoryId = $source['category_id'];
        $extCategoryName = $source['external_category_name'];
        $sourceId = $source['source_id'];
        $getListingsQuery = $source['get_listings_query'];
        $getImagesQuery = $source['get_images_query'];

        $categoryAttrIds = $source['category_attribute_ids'];
        $categoryAttrNames = $source['category_attribute_names'];
        $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
        mysql_select_db(DATABASE_NAME);

        $query = $getListingsQuery;
        $listings = mysql_query($query)
                or die(mysql_error());
        $noOfListings = mysql_num_rows($listings);
        $area = null;
        $price = null;
        $bedrooms = null;
        $address = null;
        if ($listings && isset($noOfListings) && $noOfListings > 0) {

            while ($listingRow = mysql_fetch_assoc($listings)) {

                $area = null;
                $price = null;
                $bedrooms = null;
                $address = null;
                $categoryName = $listingRow['category_name'];
                $title = $listingRow['title'];
                $description = $listingRow['description'];
                $attribute = $listingRow['attribute'];
                $externalKey = str_replace('PostingID: ', '',  $listingRow['external_key']);
                $externalEmail = $listingRow['external_email'];
                $postingDate = str_replace('Date: ', '',  $listingRow['posting_date']);
                $postingDate = new DateTime($postingDate);
                $postingDate = $postingDate->format('Y-m-d H:i:s');
                $externalUrl = $listingRow['external_url'];
                
                $expirationDate = strtotime($postingDate);
                $expirationDate = strtotime($postConfig->expireafter, $expirationDate);
                $expirationDate = date('Y-m-d H:i:s', $expirationDate);
               
                
                //Create posting
                $postingId = null;
                if ($extCategoryName == "apts / housing") {
                    preg_match('~(SGD\d*) \/ (\dbr) - (\d*ft).. - (.*) \((.*)\)~', $title, $matches);
                    if (sizeof($matches) > 0) {
                        $price = str_replace('SGD', '', $matches[1]);
                        $bedrooms = str_replace('br', '', strtolower($matches[2]));
                        $area = str_replace('ft', '', strtolower($matches[3]));
                        $title = $matches[4];
                        $address = $matches[5];
                    } else {

                        preg_match('~(SGD\d*) \/ (\dbr) - (.*) \((.*)\)~', $title, $matches);
                        if (sizeof($matches) > 0) {
                            $price = str_replace('SGD', '', $matches[1]);
                            $bedrooms = str_replace('br', '', strtolower($matches[2]));

                            $title = $matches[3];
                            $address = $matches[4];
                        } else {
                            preg_match('~(SGD\d*) \/ (\d*ft).. - (.*) \((.*)\)~', $title, $matches);
                            if (sizeof($matches) > 0) {
                                $price = str_replace('SGD', '', $matches[1]);

                                $area = str_replace('ft', '', strtolower($matches[2]));
                                $title = $matches[3];
                                $address = $matches[4];
                            } else {
                                preg_match('~(SGD\d*) (.*) \((.*)\)~', $title, $matches);
                                if (sizeof($matches) > 0) {
                                    $price = str_replace('SGD', '', $matches[1]);

                                    $title = $matches[2];
                                    $address = $matches[3];
                                }
                            }
                        }
                    }
                }

                try {



                    $insert = "INSERT INTO posting (posting_status_id, title,description,posting_date,expiration_date " .
                            ",user_id,category_id,post_anonymously,external_key,external_email,external_url,source_id,date_created,date_updated) " .
                            " VALUES (2, '" . $title . "', '" . $description . "', '" . $postingDate . "','" . expiration_date .
                            "',1,'" . $categoryId . "',1,'" . $externalKey . "','" . $externalEmail . "','" . $externalUrl . "','" . $sourceId . "'," .
                            "'" . $postingDate . "','" . $postingDate . "')";

                    $extract_data = mysql_query($insert);
                    if ($extract_data) {
                        $postingId = mysql_insert_id();
                    }
                    if ($postingId > 0) {
                        //Add posting images
                        $query = str_replace('$id', $id, $getImagesQuery);
                        $images = mysql_query($query)
                                or die(mysql_error());
                        $noOfImages = mysql_num_rows($images);
                        if ($images && isset($noOfImages) && $noOfImages > 0) {
                            $counter = 0;
                            while ($imageRow = mysql_fetch_assoc($images)) {


                                $imageId = null;
                                $imageUrl = urldecode($imageRow['imageUrl']);
                                $imageName = (stristr($imageUrl, '?', true)) ? stristr($imageUrl, '?', true) : $imageUrl;
                                $pos = strrpos($imageName, '/');
                                $imageName = substr($imageName, $pos + 1);



                                $insert = "INSERT INTO image (user_id,image_file,image_title,image_url,date_created)

 			VALUES (1, '" . $imageName . "', '" . $imageName . "','" . $imageUrl . "','" . $postingDate . "')";

                                $insert_image = mysql_query($insert);
                                if ($insert_image) {
                                    $imageId = mysql_insert_id();
                                    $isMainImage = 0;
                                    if ($counter == 0)
                                        $isMainImage = 1;
                                    $insert = "INSERT INTO posting_image (posting_id,image_id,is_main_image,date_created)

 			VALUES ('" . $postingId . "', '" . $imageId . "','" . $isMainImage . "','" . $postingDate . "')";
                                }

                                $counter++;
                            }
                        }
                        //Add Address
                        if (isset($address)) {

                            $city = 'Singapore';
                            $lat = '1.3667';
                            $lon = '103.75';

                            $insert = "INSERT INTO address (posting_id,address,city,lat,lon,date_created)

 			VALUES ('" . $postingId . "', '" . $address . "','" . $city . "','" . $lat . "','" . $lon . "','" . $postingDate . "')";

                            $insert_address = mysql_query($insert);
                        }
                        if (isset($categoryAttrIds) && isset($categoryAttrNames)) {
                            $nameArray = explode(",", $categoryAttrNames);
                            $idArray = explode(",", $categoryAttrIds);
                            $value = null;
                            $dimension = null;

                            for ($i = 0; $i < sizeof($nameArray); ++$i) {
                                $value = null;
                                $dimension = null;
                                if ($nameArray[$i] == 'Rent' || $nameArray[$i] == 'Cost' || $nameArray[$i] == 'Salary') {
                                    $value = $price;
                                    if ($extCategoryName == "apts / housing")
                                        $dimension = "Per Month";
                                }
                                else if ($nameArray[$i] == 'Area') {
                                    $value = $area;
                                } else if ($nameArray[$i] == 'Bedrooms') {
                                    $value = $bedrooms . 'br';
                                }

                                if (isset($value)) {
                                    $insert = "INSERT INTO posting_attribute (posting_id,category_attribute_id,value,dimension,date_created)

 			VALUES ('" . $postingId . "', '" . $idArray[$i] . "','" . $value . "','" . $dimension . "','" . $postingDate . "')";

                                    $insert_attribute = mysql_query($insert);
                                }
                            }
                        }
                    }
                } catch (Exception $ex) {
                    
                }
            }
        }
    }

}

?>
