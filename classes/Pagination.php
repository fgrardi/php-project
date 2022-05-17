<?php
    //include_once(__DIR__ . "../interfaces/iUser.php");
    include_once(__DIR__ . "/Db.php");

    class Pagination
    {
        private $page;
       
            /**
         * Get the value of page
         */ 
        public function getPage()
        {
                return $this->page;
        }

        /**
         * Set the value of page
         *
         * @return  self
         */ 
        public function setPage($page)
        {
                $this->page = $page;

                return $this;
        }


        public static function countPosts (){
    
            $conn = Db::getInstance();
            $result = $conn->query("select count(id) AS id from posts ");
            $postCount= $result->fetchAll();
            return $postCount;
            
        }

        public static function setPagination(){

                $limit = 15;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($page -1) * $limit;
                $sorting = 'DESC';
           
                $conn = Db::getInstance();
                $statement = $conn->prepare("select * from posts INNER JOIN users ON posts.user_id = users.id LEFT JOIN tags on tags.id= posts.id ORDER BY `date` $sorting LIMIT $start, $limit");
                $statement->execute();
                $result = $statement->fetchAll();
                return $result;

        }


    }