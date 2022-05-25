<?php 

    class Pagination
    {
        var $data;

        function Paginate($values, $limit)
        {
            $totalValues= count($values);

            if(isset($_GET['page'])){
                $currentPage= $_GET['page'];
            } else {
                $currentPage= 1;
            }

            $pages= ceil($totalValues/$limit);
            $start= ($currentPage -1) * $limit;
            $this->data= array_slice($values, $start, $limit);

            for($i=1; $i<= $pages; $i++){
                $numbers[]= $i;
            }
            return $numbers;
        }

        function fetchResult()
        {
            $resultsValues= $this->data;
            return $resultsValues;
        }
    }
/*
    $conn = Db::getInstance();
    $result = $conn->query("select count(id) AS id from posts");
    $postCount= $result->fetchAll();
    $total= $postCount[0]['id'];
    $pages= ceil($total / $limit);

*/

    $pag = new Pagination();
    $data= array("hye", "hi", "top");
    
    $numbers= $pag->Paginate($data, 2);
    $result= $pag->fetchResult();

    foreach($result as $r){
        echo '<div>'.$r.'</div>';
    }

    foreach($numbers as $num){
        echo '<a class="page-link" href="Pagination.php?page='.$num.'">'.$num.'</a>';
    }