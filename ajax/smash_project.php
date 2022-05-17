<?php
   include_once(__DIR__.'/../bootstrap.php');

   
    if (!empty($_POST)) {
        try {
            //new smashed project
            $postId = intval(($_POST['postid']));
            $userId = intval(($_POST['userid']));
            var_dump($postId);
            var_dump($userId);


            $posts= new Post();
            $posts->setPostId($postId);
            $posts->setUserId($userId);
            $count = $posts->smashExists();
           var_dump($count);
            
            if ($count) {
               $temp = $posts->unsmashed($postId);
               var_dump($temp);

                $response= [
                "status" => "success",
                "userid" => $userId,
                "postid" => $postId,
                "message" => "Unsmashed.",
                'smashed' => false,
                
            ];
            } else {
                $posts->smashed($postId);
                $response = [
                'status' => 'success',
                "userid" => $userId,
                "postid" => $postId,
                'message' => "smashed.",
                'smashed' => true,
               
            ];
            }
        } catch (Exception $e) {
            $response= [
                "status"=> "error",
                "message" => "Cannot smash."
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
