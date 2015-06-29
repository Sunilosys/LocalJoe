<?php

class Application_Model_LjBaseModel extends Zend_Db_Table_Abstract {

    /**
     * @var String  
     */
    protected $table_name;

    /**
     * @var String  
     */
    protected $table_pk;

    /**
     * @var String  
     */
    public $where_clause;

    /**
     * @var String  
     */
    public $order_by;
    public $limit;

    /**
     * @var String  
     */
    protected $class_name;

    /**
     * @var String  
     */
    public $sql_stmt;

    /**
     * @var DateTime  
     */
    protected $date_created;

    public function getDate_created() {
        return $this->date_created;
    }

    public function setDate_created($Value) {
        $this->date_created = $Value;
    }

    /**
     * @var DateTime  
     */
    protected $date_updated;

    public function getDate_updated() {
        return $this->date_updated;
    }

    public function setDate_updated($Value) {
        $this->date_updated = $Value;
    }

    /**
     * @var Integer  
     */
    protected $created_by;

    public function getCreated_by() {
        return $this->created_by;
    }

    public function setCreated_by($Value) {
        $this->created_by = $Value;
    }

    /**
     * @var Integer  
     */
    protected $updated_by;

    public function getUpdated_by() {
        return $this->updated_by;
    }

    public function setUpdated_by($Value) {
        $this->updated_by = $Value;
    }

    function __construct() {

        $this->setDate_created(date("Y-m-d H:i:s"));
        $this->setDate_updated(date("Y-m-d H:i:s"));
        $this->setCreated_by(1);
        $this->setUpdated_by(1);
    }

    public function create($DataInfo) {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $db->insert($this->table_name, $DataInfo);
        //exit;
        $id = $db->lastInsertId($this->table_name, $this->table_pk);

        if ($id !== null)
            return $id;
        else
            return false;
    }

    public function update(array $DataInfo, $PkValue) {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $PkWhere = $this->table_pk . " = " . $PkValue;
        $result = $db->update($this->table_name, $DataInfo, $PkWhere);
        return $result;
    }

    public function updateArr($DataInfo, $PkValue) {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        foreach ($PkValue as $key => $val) {
            $PkWhere[] = "$key = $val";
        }

        // echo "<PRE>PkWhere:",print_r($PkWhere);

        $result = $db->update($this->table_name, $DataInfo, $PkWhere);
       
        // return result;
    }

    public function updateWithWhere($dataInfo, $where) {
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $result = $db->update($this->table_name, $dataInfo, $where);
    }

    public function select($withFromPart = true) {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $db->setFetchMode(PDO::FETCH_OBJ);

        $sql = "SELECT * FROM " . $this->table_name;

        if (!empty($this->where_clause)) {

            $sql = $sql . ' WHERE ' . $this->where_clause;
        }
        if (!empty($this->order_by)) {

            $sql = $sql . ' ' . $this->order_by;
        }

        if (!empty($this->limit)) {

            $sql = $sql . ' ' . $this->limit;
        }
        // echo "<PRE>sql:",print_r($sql);

        $resultObj = $db->fetchAll($sql);

        //echo "<PRE>resultObj:",print_r($resultObj);
        //exit;

        if (count($resultObj) > 1) {

            foreach ($resultObj as $key => $val) {

                $obj[] = $this->php_cast($val, $this->class_name);
            }
        } else if (count($resultObj) == 1) {

            $obj[] = $this->php_cast($resultObj[0], $this->class_name);
        } else if (count($resultObj) == 0) {
            $obj = null;
        }

        //echo "<PRE>obj:",print_r($obj);
        //exit;

        return $obj;
    }

    public function query() {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $db->setFetchMode(PDO::FETCH_ASSOC);

        // echo "<PRE>this->sql_stmt:",print_r($this->sql_stmt);
        // exit;
        $log = Zend_Registry::get('log');

        $time_start = microtime(true);


        $resultObj = $db->fetchAll($this->sql_stmt);
        $time_end = microtime(true);
        if (isset($log))
            $log->info("Executed Service " . $this->class_name .". Time Taken " . ($time_end - $time_start));
       



        return $resultObj;
    }

    public function delete($PkValue) {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $PkWhere = $this->table_pk . " = " . $PkValue;

        $result = $db->delete($this->table_name, $PkWhere);

        return $result;
    }

    public function deleteArr($PkValue) {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        foreach ($PkValue as $key => $val) {
            $PkWhere[] = "$key = $val";
        }

        // echo "<PRE>PkWhere:",print_r($PkWhere);

        $result = $db->delete($this->table_name, $PkWhere);

        return $result;
    }

    public function deleteWithStmt($PkWhere) {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $result = $db->delete($this->table_name, $PkWhere);

        // return $result;
    }

    public function php_cast($obj, $class) {

        $reflectionClass = new ReflectionClass($class);
        if (!$reflectionClass->IsInstantiable()) {
            throw new Exception($class . " is not instantiable!");
        }
        if ($obj instanceof $class) {
            return $obj; // nothing to do.
        }

        // lets instantiate the new object
        $tmpObject = $reflectionClass->newInstance();

        $properties = Array();
        foreach ($reflectionClass->getProperties() as $property) {
            $properties[$property->getName()] = $property;
        }

        // we'll take all the properties from the fathers as well
        // overwriting the old properties from the son as well if needed.
        $parentClass = $reflectionClass; // loop init
        while ($parentClass = $parentClass->getParentClass()) {
            foreach ($parentClass->getProperties() as $property) {
                $properties[$property->getName()] = $property;
            }
        }

        // now lets see what we have set in $obj and transfer that to the new object
        if (is_object($obj)) {
            $vars = get_object_vars($obj);
            foreach ($vars as $varName => $varValue) {
                if (array_key_exists($varName, $properties)) {
                    $prop = $properties[$varName];
                    if (!$prop->isPublic()) {
                        $prop->setAccessible(true);
                    }
                    $prop->setValue($tmpObject, $varValue);
                }
            }
        }

        return $tmpObject;
        //echo "<PRE>tmpObject:",print_r($tmpObject);
        //exit;
    }
    
      function formatDateForShortSnippet($postingDate) {

        Zend_Date::setOptions(array('format_type' => 'php'));
        $datetimeformat = Zend_Registry::get('datetimeformat');
        if (Zend_Registry::isRegistered('datetimeformat'))
            $datetimeformat = Zend_Registry::get('datetimeformat');
        else
            $datetimeformat = 'F j, Y, g:i a';
        $zenddate = new Zend_Date($postingDate, "Y-m-d H:i:s");

        if (Zend_Registry::isRegistered('timezone')) {

            $timezone = Zend_Registry::get('timezone');
        } else {
            $timezone = 'UTC';
        }
        $zenddate->setTimezone($timezone);


        $formattedDate = "";
        $todaysDate = date("Y-m-d");
        $postDateYMD = date_format(date_create($zenddate), "Y-m-d");
        if (strtotime($todaysDate) == strtotime($postDateYMD))
            $formattedDate = "Today at " . $zenddate->toString("g:i a");
        else if (strtotime($todaysDate) == strtotime("+1 day", strtotime($postDateYMD)))
            $formattedDate = "Yesterday at " . $zenddate->toString("g:i a");
        else
            $formattedDate = $zenddate->toString($datetimeformat);

        return $formattedDate;
    }


}