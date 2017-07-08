<?php
class DB{
    private static $_instance;
    private static $_connection;
    private static $_table = null;
    private $_query = null;
    private $_where = null;
    private $_result = null;

    /**
     * Setup connection
     */
    private function __construct() {
        try {
            self::$_connection = new Pdo('mysql:host=localhost;dbname=guiatop;charset=utf8', 'root', '');
            self::$_connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch (Exception  $e) {
            throw new Exception ($e->getMessage(), 1);
        }
    }

    /**
     * Return existing instance of DB class
     * or make a new one
     *
     * @return object
     */
    public static function instance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Set table to be used
     *
     * @param String $table
     * @return object
     */
    public static function table($table) {
        $db = self::instance();
        self::$_table = $table;
        return $db;
    }

    /**
     * Insert method
     *
     * @param array $values 3D array with values
     * @return object
     */
    public function insert(array $fields) {
        $db = self::instance();
        $this->_query =  "INSERT INTO " . self::$_table . " (`" . implode(array_keys($fields), "`, `") . "`) VALUES ('" . implode($fields, "', '") . "')";
        return $db;
    }

    /**
     * Select method
     *
     * @param string $fields separated by comma
     * @param array $fields 3D array with
     * @return object
     */
    public function select($columns = '*') {
        $db = self::instance();
        if (is_array($columns))
            $columns = "`" . implode($columns, "`, `") . "`";
        $this->_query = "SELECT {$columns} FROM ".self::$_table;
        return $db;
    }

    /**
     * Update method
     *
     * @param array $fields 3D array with values
     * @return object
     */
    public function update(array $fields){
        $db = self::instance();
        $this->_query = "UPDATE ".self::$_table." SET ";
        $string = array();
        foreach ($fields as $k => $v)
            $string[] = $k." = '".$v."'";

        $this->_query .= implode($string, ", ");
        return $db;
    }

    /**
     * Delete method
     *
     * @return object
     */
    public function delete() {
        $db = self::instance();
        $this->_query = "DELETE FROM ".self::$_table;;
        return $db;
    }

    /**
     * Run insert/update/delete query's
     *
     * @return object
     */
    public function run() {
        $db = self::instance();
        $this->_result = self::$_connection->prepare($this->_query);
        $this->_result->execute();
        return $db;
    }

    /**
     * Return last inserted id from insert query
     *
     * @return int
     */
    public function insertId(){
        return self::$_connection->lastInsertId();
    }

    /**
     * Return affected rows by update/delete query's
     *
     * @return int
     */
    public function affectedRows(){
        return $this->_result->rowCount();
    }

    /**
     * "WHERE" fields used in select/delete query's
     * $options is a 3D array with some default options
     * Ex: array('name' => 'test', 'operator' => '=', 'condition' => 'AND')
     * operator (<, >, =, <>, LIKE)
     * condition (AND, OR)
     * 
     * @param array $options
     * @return object
     */
    public function where(array $options){
        $db = self::instance();

        if (!array_key_exists('operator', $options)) $operator = '=';
        else $operator = $options['operator'];
        if (!array_key_exists('condition', $options)) $condition = 'AND';
        else $condition = $options['condition'];

        unset($options['operator']);
        unset($options['condition']);

        $string = null;
        foreach ($options as $k => $v) {
            if(count($this->_where) == 0) $string = " WHERE ".$k." ".$operator." '".$v."'";
            else $string .= " ".$condition." ".$k." ".$operator." '".$v."'";
            $this->_where++;
        }
        $this->_query .= $string;

        return $db;
    }

    /**
     * Used for select query
     *
     * @param string $columns separated by comma
     * @param array $columns 3D array
     * @param string $type ASC(default) or DESC
     * @return void
     */
    public function orderBy($columns, $type = 'ASC'){
        $db = self::instance();
        if (is_array($columns))
            $columns = implode($columns, ", ");
        $this->_query .= " ORDER BY ".$columns." ".$type;
        return $db;
    }

    /**
     * Limit the return of selected rows
     * in select query's
     * 
     * @param string $values separated by comma
     * @param array $values 3D array with
     * @return object
     */
    public function limit($values){
        $db = self::instance();
        if (is_array($values))
            $values = implode($values, ', ');
        $this->_query .= " LIMIT ".$values;
        return $db;
    }

    /**
     * Fetch first row
     *
     * @return array
     */
    public function fetch(){
        $this->_result = self::$_connection->query($this->_query)->fetch(PDO::FETCH_ASSOC);
        return $this->_result;
    }

    /**
     * Fetch all rows
     * $resultType (1,2,3,4)
     * 1 by field names only as array
     * 2 by field position only as array
     * 3 by both field name/position as array
     * 4 by field names as object
     * 
     * @param integer $resultType
     * @return array
     */
    public function fetchAll($resultType = 1){
        $this->_result = self::$_connection->query($this->_query);
        $option = null;
        switch ($resultType) {
            case 1:
                $option = PDO::FETCH_ASSOC;
            case 2:
                $option = PDO::FETCH_NUM;
            case 3:
                $option = null;
            case 4:
                $option = PDO::FETCH_OBJ;   
        }
        return ($option)? $this->_result->fetchAll($option) : $this->_result->fetchAll();
    }
}