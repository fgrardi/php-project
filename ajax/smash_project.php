<?php
include_once(__DIR__ . '/../bootstrap.php');


if (!empty($_POST)) {
    try {

        //new smashed project

        $postId = intval(($_POST['postid']));
        $userId = intval(($_POST['userid']));

        $posts = new Post();
        $posts->setPostId($postId);
        $posts->setUserId($userId);
        // $count = $posts->smashExists($postId);

        if ($posts->smashExists()===1) {

            $posts->smashed($postId);

            $response = [
                "message" => "smashed.",
                "postid" => $postId,
                "smashed" => 1,
                "status" => "success",
                "userid" => $userId
            ];
        } 
        
       else{

            $posts->unsmashed($postId);

            $response = [
                "message" => "unsmashed.",
                "postid" => $postId,
                "smashed" => 0,
                "status" => "success",
                "userid" => $userId
            ];
        }
    } catch (Exception $e) {
        $response = [
            "status" => "error",
            "message" => "Cannot smash."
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
