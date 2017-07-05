<?php
class DB{
    private static $_instance;
    private static $_connection;
    private static $_table = null;
    private $_insert = null;
    private $_select = null;
    private $_where = null;

    private function __construct() {
        try {
            self::$_connection = new Pdo('mysql:host=localhost;dbname=guiatop;charset=utf8', 'root', '');
            self::$_connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch (Exception  $e) {
            throw new Exception ($e->getMessage(), 1);
        }
    }

    public static function instance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function table($table) {
        $db = self::instance();
        self::$_table = $table;
        return $db;
    }

    public function insert(array $values) {
        $db = self::instance();
        $this->_insert =  "INSERT INTO " . self::$_table . " (`" . implode(array_keys($values), "`, `") . "`) VALUES ('" . implode($values, "', '") . "')";
        return $db;
    }

    public function run() {
        $db = self::instance();
        self::$_connection->query($this->_insert);
        return $db;
    }

    public function insertId(){
        return self::$_connection->lastInsertId();
    }

    public function select($fields = '*') {
        $db = self::instance();
        if (is_array($fields))
            $fields = "`" . implode($fields, "`, `") . "`";
        $this->_select = "SELECT {$fields} FROM ".self::$_table;
        return $db;
    }

    public function where(array $options){
        // 3D array: array('name' => 'test', 'operator' => '=', 'condition' => 'AND')
        // operator (<, >, =, <>, LIKE)
        // condition (AND, OR)
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
        $this->_select .= $string;

        return $db;
    }

    public function orderBy($columns, $type = 'ASC'){
        $db = self::instance();
        if (is_array($columns))
            $columns = implode($columns, ", ");
        $this->_select .= " ORDER BY ".$columns." ".$type;
        return $db;
    }

    public function limit(){}

    public function fetch(){
        return self::$_connection->query($this->_select)->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($resultType = 1){
        $result = self::$_connection->query($this->_select);
        switch ($resultType) {
            case 1:
                // by field names only as array
                return $result->fetchAll(PDO::FETCH_ASSOC);
            case 2:
                // by field position only as array
                return $result->fetchAll(PDO::FETCH_NUM);
            case 3:
                // by both field name/position as array
                return $result->fetchAll();
            case 4:
                // by field names as object
                return $result->fetchAll(PDO::FETCH_OBJ);   
        }
    }
}