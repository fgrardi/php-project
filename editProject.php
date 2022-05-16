<?php
include_once("bootstrap.php");

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
} else {
    $postId =  $_GET['p'];
    $projectData = Post::getPostDataFromId($postId);

        if (!empty($_POST['submit'])) {
            try {
                $post = new Post();
                $post->setTitle($_POST['title']);
                $post->editTitle($postId);
                            
                $tags= new Tag();
                $tags->setTag($_POST['tags']);
                $tags->editTags($postId);

                header('Location: index.php');
                echo "oke";
            } catch (Throwable $e) {
                $error = $e->getMessage();
                echo "ni oke";

            }
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('style.php'); ?>
    <title>Edit your project</title>
</head>
<body>
    <?php require_once("header.php"); ?>

    <div class="container py-4">
        <a href="index.php" class="btn btn-outline-primary">Cancel</a>


        <div class="upload-intro text-center pt-4">
            <h1>Editing your project: </h1>
        </div>

        <div class="col-7 py-5 m-auto">
            <?php if (isset($error)):?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif;?>

            <form class="uploadzone" action="#" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <!-- <label for="floatingInput">Edit the title of your project</label> -->
                    <input type="text" class="form-control" id="floatingInput" name="title" placeholder="<?php echo $projectData['title'] ?>">
                </fieldset>

                <fieldset>
                    <!-- <label for="tags">Edit your tags</label> -->
                    <input type="text" class="form-control" id="tags" name="tags" placeholder="Give it some tags like #branding">
                    <div class="form-text">Don't forget the famous '#' before your tag</div>
                </fieldset>
                <input class="btn btn-primary col-12" type="submit" value="Save changes" name="submit">
            </form>
        </div>
    </div>

    <?php require_once("footer.php"); ?>
</body>
</html>