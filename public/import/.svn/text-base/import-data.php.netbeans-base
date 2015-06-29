
<?php
require 'import.php';

$sourceResult = import::getImportSources();


if (isset($sourceResult)) {
    while ($source = mysql_fetch_assoc($sourceResult)) {

        $sourceCode = $source['source_code'];
        if ($sourceCode == 'CRAIG')
            import::importDataFromCraigslist($source);
    }
}
?>
