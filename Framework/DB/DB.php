<?php

namespace Giga\Framework\DB;

use Giga\Configs\Config;

class DB
{
    private static $_instance;

    private $_db,
            $_query,
            $_results,
            $_table,
            $_count,
            $prev_field,
            $prev_value,
            $prev_operator;

    /**
     * DB constructor.
     */
    private function __construct()
    {
        try {
            $this->_db = new \PDO('mysql:host=' . Config::get('mysql.host') . ';dbname='. Config::get('mysql.db') ,
                Config::get('mysql.username'),Config::get('mysql.password'));

        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function connect()
    {
        if(!isset(self::$_instance))
        {
            self::$_instance = new DB();
        }
        return self::$_instance;

    }

    /**
     * @param array $values
     * @return bool
     */
    public function update($values = [])
    {
        if ( $values )
        {
            $fields = '';
            $x = 1;
            foreach ( $values as $key => $value )
            {
                $fields .= $key . "= ?";
                if ( $x < count($values) )
                {
                    $fields .= ', ';
                }
                $x++;
            }

            $sql = "UPDATE {$this->_table} SET {$fields} WHERE id = {$this->_results[0]->id}";

            $this->query($sql, $values);
            return true;
        }
        return false;
    }

    /**
     * @param $table
     * @return $this
     */
    public function table($table)
    {
        $this->_table = $table;
        return $this;
    }

    /**
     * @param array $fields
     * @return bool
     */
    public function create($fields)
    {
        $keys = array_keys($fields);
        $values = '';
        $x = 1;

        foreach ($fields as $value)
        {
            $values .= "?";
            if ($x < count($fields))
            {
                $values .= ', ';
            }
            $x++;
        }
        $sql = "INSERT INTO {$this->_table} (`". implode('`, `', $keys) . "`) VALUES ({$values})";
        
        if ( $this->query($sql, $fields) )
        {
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $value = [1];

        $sql = "SELECT * FROM {$this->_table} WHERE id >= ?";
        $this->query($sql, $value);
        return $this->_results;
    }

    /**
    *   @return datas between datetime
    */

    public function between($from = null, $to = null, $format = "datetime")
    {
        if ($from && $to)
        {
            $sql = ("SELECT * FROM {$this->_table} WHERE {$format} BETWEEN ? AND ?");


            $this->query($sql, array($from, $to));
            return $this;
        }
    }

    /**
    *   @return datas between datetime with previous sql query
    */

    public function andBetween($from, $to, $format = "datetime")
    {
        if ($this->prev_operator)
        {
            $operator = $this->prev_operator;
        }
        $operator = "=";

        $sql = ("SELECT * FROM {$this->_table} WHERE {$this->prev_field} {$operator} ? AND {$format} BETWEEN ? AND ?");

        $this->_results = [];
        $this->query($sql, array($prev_value, $from, $to));
        return $this;
    }

    /**
     * @return bool|DB
     */
    public function where()
    {
        $array = func_get_args();

        if (count($array) == 2)
        {
            $field = $array[0];
            $value = $array[1];

            $this->prev_field = $field;
            $this->prev_value = $value;

            $sql = ("SELECT * FROM {$this->_table} WHERE {$field} = ?");

            $this->query($sql, array($value));
            return $this;
        }else if ( count($array) === 3 )
        {
            $field = $array[0];
            $operator = $array[1];
            $value = $array[2];
            $operators = ['=', '>', '<', '<=', '>=', 'LIKE'];

            $this->prev_field = $field;
            $this->prev_value = $value;

            $this->prev_operator;

            $sql = "SELECT * FROM {$this->_table} WHERE {$field} {$operator} ?";

            $this->query($sql,[$value]);
            return $this;
            
        }
        return false;
    }

    /**
    *   @return sql query with AND operator
    */

    public function andWhere()
    {
        $array = func_get_args();

        if (count($array) == 2)
        {
            $field = $array[0];
            $value = $array[1];

            $sql = ("SELECT * FROM {$this->_table} WHERE {$this->prev_field} = ? AND {$field} = ?");

            $this->_results = [];
            $this->query($sql, array($value, $this->prev_value));
            return $this;

        }else if ( count($array) === 3 )
        {
            $field = $array[0];
            $operator = $array[1];
            $value = $array[2];

            $sql = "SELECT * FROM {$this->_table} WHERE {$field} {$operator} ? AND {$this->prev_field} {$this->prev_operator} ?";

            $this->_results = [];
            $this->query($sql,array($value, $this->prev_value));
            return $this;
            
        }
        return false;
    }


    /**
     * @return mixed
     */
    public function first()
    {
        if (!empty($this->_results)) {
            return $this->_results[0];
        }
        return false;
    }


    /**
     * @return mixed
     */
    public function get()
    {
        return $this->_results;
    }


    /**
     * @param $sql
     * @param array $params
     * @return bool|DB
     */
    public function query($sql, $params = array())
    {
        $this->_query = $this->_db->prepare($sql);

        if (count($params))
        {
            $x = 1;
            foreach ($params as $item)
            {
                $this->_query->bindValue($x, $item);
                $x++;
            }
            if ( $this->_query->execute() )
            {
                $this->_results = $this->_query->fetchAll(\PDO::FETCH_OBJ);
                $this->_count   = $this->_query->rowCount();
            }
            else
            {
                return false;
            }
        }
        return $this;

    }

    public function count()
    {
        return $this->_count;
    }

}

