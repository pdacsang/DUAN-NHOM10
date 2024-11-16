<?php
    class AdminDanhMuc{
        public $conn;

        public function __construct()
        {
            $this->conn = connectDB();
        }

        public function getAllDanhMuc(){
            try{
                $sql = 'SELECT * FROM danh_mucs';
                $stml = $this->conn->prepare($sql);
                $stml->execute();

                return $stml->fetchAll();
            }catch(Exception $e){
                echo "Lỗi" . $e->getMessage();
            }
        }
    }
?>