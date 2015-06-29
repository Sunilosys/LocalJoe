<?php

require '3taps.php';
$dbConfig = parse_ini_file('../../application/configs/config.ini', 'production');
$importConfig = parse_ini_file('../../application/configs/config.ini', 'import-data');

define('DATABASE_SERVER', $dbConfig['production']['db.params.host']);
define('DATABASE_USER_NAME', $dbConfig['production']['db.params.username']);
define('DATABASE_USER_PWD', $dbConfig['production']['db.params.password']);
define('DATABASE_NAME', $dbConfig['production']['db.params.dbname']);
define('LOCATION_CODE', $importConfig['import-data']['source_loc']);
define('STATUS', $importConfig['import-data']['status']);

class import {

    public static function getImportSources() {
        $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
        mysql_select_db(DATABASE_NAME);

        $sourceResult = mysql_query("SELECT * FROM source")
                or die(mysql_error());
        $noOfSources = mysql_num_rows($sourceResult);
        if ($sourceResult && isset($noOfSources) && $noOfSources > 0) {
            return $sourceResult;
        }
        else
            return null;
    }

    public static function importDataFromCraigslist($source) {

        $apiBaseUrl = $source['api_base_url'];
        $apiAuthKey = $source['api_auth_key'];
        $sourceId = $source['source_id'];
        $sourceCode = $source['source_code'];

        $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
        mysql_select_db(DATABASE_NAME);


        $apiMapResult = mysql_query("SELECT * FROM api_map where source_id =" . $sourceId)
                or die(mysql_error());
        $noOfApiMaps = mysql_num_rows($apiMapResult);
        if ($apiMapResult && isset($noOfApiMaps) && $noOfApiMaps > 0) {

            while ($rowApiMap = mysql_fetch_assoc($apiMapResult)) {

                $apiId = $rowApiMap['api_id'];
                $categoryId = null;
                $params = array();
                $categoryResult = mysql_query("SELECT category_id FROM category_mapping where api_id =" . $apiId)
                        or die(mysql_error());
                if ($categoryResult) {
                    $category = mysql_fetch_assoc($categoryResult);
                    if (isset($category['category_id']))
                        $categoryId = $category['category_id'];
                }
                $apiParameters = $rowApiMap['api_parameters'];
                $searchText = $rowApiMap['search_text'];
                $params['rpp'] = -1;

                $start = $rowApiMap['last_import_date'];
                $end = gmdate("Y-m-d\TH:i:s\Z");
                if (isset($start)) {
                    $params['start'] = gmdate($start);
                    $params['end'] = $end;
                }

                if (isset($searchText))
                    $params['text'] = $searchText;
                if (isset($apiParameters)) {
                    $apiParameters = $apiParameters . '&annotations={source_loc:' . LOCATION_CODE . '}';
                    $tempArray = explode('&', $apiParameters);
                    for ($i = 0; $i < sizeof($tempArray); $i++) {
                        $param = explode('=', $tempArray[$i]);
                        $params[$param[0]] = $param[1];
                    }
                    $client = new threeTapsClient($apiAuthKey);
                    $results = $client->search->search($params);

                    $externalKey = null;
                    $currentDate = date("Y-m-d H:i:s");

                    $attributeName = null;
                    $attributeGroup = null;
                    $attributeValue = null;

                    $status = STATUS;
                    $content = null;

                
                    try {
                        if (isset($results) && isset($results['results'])) {
                                $apiMapUpdate = mysql_query("update api_map set last_import_date = '" . $end . "' where api_id =" . $apiId)
                            or die(mysql_error());
                            for ($i = 0; $i < sizeof($results['results']); $i++) {
                                if ($results['results'][$i]['accountName'] == null ||
                                        strlen(trim($results['results'][$i]['accountName'])) == 0)
                                    continue;
                                $insertId = 0;
                                $externalKey = $results['results'][$i]['postKey'];

                                $existingResult = mysql_query("SELECT * FROM import_data where external_key ='" . $externalKey . "' and source_id=" . $sourceId)
                                        or die(mysql_error());
                                if ($existingResult && mysql_num_rows($existingResult) > 0)
                                    continue;

                                $insert = "INSERT INTO import_data (external_key, source_id,category_id,content,status,created_date,updated_date)

 			VALUES ('" . $externalKey . "', '" . $sourceId . "', '" . $categoryId . "', '" . $content . "','" . $status . "','" . $currentDate . "','" . $currentDate . "')";

                                $import_data = mysql_query($insert);
                                if ($import_data) {
                                    $insertId = mysql_insert_id();
                                }
                                if ($insertId > 0) {
                                    foreach ($results['results'][$i] as $key => $value) {
                                        if (is_array($value)) {
                                            $uniqueData = array_unique($value);
                                            foreach ($uniqueData as $keyForGroupAttr => $valueForGroupAttr) {
                                                $attributeName = $keyForGroupAttr;
                                                $attributeGroup = $key;
                                                $attributeValue = $valueForGroupAttr;
                                                $insert = "INSERT INTO import_data_attribute (import_id,attribute_name,attribute_group,attribute_value)

 			VALUES ( '" . $insertId . "', '" . $attributeName . "', '" . $attributeGroup . "','" . $attributeValue . "')";

                                                $import_data_attribute = mysql_query($insert);
                                            }
                                        } else {
                                            $attributeName = $key;
                                            $attributeValue = $value;
                                            if ($attributeName == 'body' || $attributeName == 'heading')
                                            {
                                                $attributeValue = stripslashes ($attributeValue);
                                                $attributeValue = urldecode($attributeValue);
                                            }
                                            $insert = "INSERT INTO import_data_attribute (import_id,attribute_name,attribute_value)

 			VALUES ('" . $insertId . "', '" . $attributeName . "', '" . $attributeValue . "')";

                                            $import_data_attribute = mysql_query($insert);
                                        }
                                    }
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        
                    }
                    
                }
            }
        }
        //Call the stored procedure to handle import data
                    $processResult = mysql_query("CALL spCLIndexPostings()")
                            or die(mysql_error());
    }

}

?>
