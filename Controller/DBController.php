<?php 

    class DBController{
        private $host;
        private $username;
        private $password;
        private $database;
        private $conn;

        public function startConnection() {
            $this->host = 'localhost';
            $this->username = 'root';
            $this->password = '';
            $this->database = 'zestube';
            $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);

            if (!$this->conn) {
                echo "Connection failed: " . mysqli_connect_error();
            }
            else{
                return true;
            }
        }

        public function select($sql) {
            $result = mysqli_query($this->conn, $sql);

            if (!$result) {
                echo "Query failed: " . mysqli_error($this->conn);
                return false;
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function update($sql){
            $result = mysqli_query($this->conn, $sql);

            if (!$result) {
                return false;
            }

            return true; 
        }

        public function insert($sql){
            $result = mysqli_query($this->conn, $sql);

            if (!$result) {
                return false;
            }

            return true;
        }

        public function delete($sql){
            $result = mysqli_query($this->conn, $sql);

            if (!$result) {
                return false;
            }

            return true;
        }


        public function closeConnection() {
            if($this->conn) {
                mysqli_close($this->conn);
            }
        }
    }
