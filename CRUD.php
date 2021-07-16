<?php 

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //Class to create connections to databases
    class database{

        //initializing the database credentials
        private $host;
        private $dbUserName;
        private $dbPassword;
        private $dbName;

        //protected connect function to connect to the databse
        protected function connect(){

            //please moidify according to your database configuration
            $this->host = "localhost";
            $this->dbUserName = "root";
            $this->dbPassword = "";
            $this->dbName = "bloodBank";

            try{
                $conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->dbUserName, 
                $this->dbPassword);
            }catch(PDOException $e){

                die($e->getMessage());
        
            }
            return $conn;
        }

    }

    //CRUD contains all functions to create/Read/update/delete
    class query extends database{

        //initializing the connection
        protected $conn;

        function __construct(){
            $this->conn = $this->connect();
        }

        //function to prepare and run the QUERY
        public function prep_and_run($query){
            $query = $this->conn->prepare($query);
            try{
                $query->execute();
                $result = $query->fetchAll();
            }
            catch(PDOException $e){
                die($e->getMessage());
            }
            return $result;

        }

        //Function to describe the table
        //SELECT $field FROM $table where $condition $order_by_field $order_by_type $limit
        public function descTable($table){

            $query = "DESC $table";
            return $this->prep_and_run($query);

        }

        //Function to get data(all parametrized)
        //SELECT $field FROM $table where $condition $order_by_field $order_by_type $limit 
        public function getData($table, $field = "*", $conditions = array(), $order_by_field = "", $order_by_type = "DESC", $limit = ""){

            $query = "SELECT $field FROM $table";

            if($conditions != []){

                $query .= " WHERE ";
                $count = count($conditions);
                $i = 0;
                foreach($conditions as $k=>$v){

                    if($count-1 != $i){
                        $query .= "$k='$v' and ";
                    }
                    else{
                        $query .= "$k='$v' ";
                    }
                    $i++;    
                }  
            }

            if($order_by_field != ""){
                $query .= "ORDER BY " . $order_by_field . " " . $order_by_type;
            }
            
            if($limit != ""){
                $query .= " LIMIT " . $limit;
            }
            $result = $this->prep_and_run($query);
            return $result;
        }

        //function to delete data
        //DELETE FROM $table WHERE $condition
        public function deleteData($table, $conditions = array()){

            $query = "DELETE FROM $table";
            
            if($conditions != []){

                $query .= " WHERE ";
                $count = count($conditions);
                $i = 0;
                foreach($conditions as $k=>$v){

                    if($count-1 != $i){
                        $query .= "$k='$v' and ";
                    }
                    else{
                        $query .= "$k='$v' ";
                    }
                    $i++;    
                }  
            }

            $result = $this->prep_and_run($query);
            return $result;
        }

        public function addData($table, $values){

            $valArr = array();
            $feildArr = array();
            
            foreach($values as $k=>$v){
                $valArr[] = $v;
                $feildArr[] = $k;
            }
            $value = implode("','", $valArr);
            $value = "'" . $value . "'";
            $fields = implode(",", $feildArr);
            $query = "INSERT INTO $table ($fields) VALUES ($value)";

            $result = $this->prep_and_run($query);
            return $result;

        }

        //Function to Update Data
        //UPDATE $table SET $values[$K]=$values[$v] WHERE $conditions 
        function updateData($table, $values, $conditions){

            $query = "UPDATE $table SET ";
            $count = count($values);
            $i = 0;
            foreach($values as $k=>$v){

                if($count-1 != $i){
                    $query .= "$k='$v',";
                }
                else{
                    $query .= "$k='$v' ";
                }
                $i++;    
            }
            $query .= " WHERE ";
            $count = count($conditions);
            $i = 0;
            foreach($conditions as $k=>$v){

                if($count-1 != $i){
                    $query .= "$k='$v' and ";
                }
                else{
                    $query .= "$k='$v' ";
                }
                $i++;    
            } 
            $result = $this->prep_and_run($query);
            return $result;

        }

    }

?>