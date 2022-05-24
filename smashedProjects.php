<?php
include_once("bootstrap.php");
session_start();

$conn = Db::getInstance();

if (isset($_SESSION['id'])) {
    $sessionId = $_SESSION['id'];
    $userDataFromId = User::getUserDataFromId($sessionId);
}

$user = new User();
$key = $_GET['p'];
$userData = User::getUserDataFromId($key);
$userPosts = $user->getUserPostsFromId($key);


$follower = new Follower();
$follower->setFollowerId($_SESSION['id']);
$follower->setFollowingId($key);
$isFollowed = $follower->isFollowedByUser();
$countFollowers = $follower->countFollowers();

$posts = Post::showSmashedProjects($key);

if (empty($posts)) {
    $emptyState = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('style.php'); ?>
    <link rel="stylesheet" href="styles/custom.css">
    <title>Smash - Showcase <?php echo $userData['username']; ?></title>
</head>

<body>
    <?php include_once('header.php'); ?>
    <div class="container">
        <div id="report-success" class="invisible" role="alert"></div>
        <?php if (isset($error)) : ?>
            <div class="row p-3">
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="row d-flex align-items-center">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <img src="<?php echo $userData['profile_pic']; ?>" class="img-thumbnail rounded-circle mt-5" alt="profile picture">
                <p class="username mt-3 mb-1"><?php echo htmlspecialchars($userData['username']); ?> •
                    <?php if (($_SESSION['id'])) : ?>
                        <?php if ($countFollowers["COUNT(id)"] === "0") : ?>
                            <span> no followers yet </span>
                </p>
            <?php elseif ($countFollowers['COUNT(id)'] === "1") : ?>
                <span> <?php echo $countFollowers["COUNT(id)"] ?> follower</span></p>
            <?php else : ?>
                <span> <?php echo $countFollowers["COUNT(id)"] ?> followers</span></p>
            <?php endif; ?>
        <?php endif; ?> </p>
        <p class="biography"><?php echo htmlspecialchars($userData['bio']); ?></p>
        <p class="education"><?php echo htmlspecialchars($userData['education']); ?></p>
        <form action="" method="post">
            <div class="my-4">
                <!-- are you sure alert -->
                <div class="modal fade" id="reportUser" aria-hidden="true" aria-labelledby="report-userLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="report-userLabel">Are you sure you want to report this user?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post">
                                <div class="modal-footer">
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal">No</button>
                                    <input id="report-user" data-userid="<?php echo $userId ?>" data-report_userid="<?php echo $_SESSION['id'] ?>" type="submit" value="Yes" name="report" class="btn btn-primary" data-bs-toggle="modal">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- are you sure alert -->
                <div class="profile-btn">
                    <?php if (!empty($userPosts[0]['social_linkedin'])) : ?>
                        <a href="<?php echo htmlspecialchars($userPosts[0]['social_linkedin']); ?>" class="btn btn-outline-primary mb-2"><img src="assets/icons/icon_linkedin.png" alt="linkedin"></a>
                    <?php endif; ?>

                    <?php if (!empty($userPosts[0]['social_github'])) : ?>
                        <a href="<?php echo htmlspecialchars($userPosts[0]['social_github']); ?>" class="btn btn-outline-primary mb-2"><img src="assets/icons/icon_github.png" alt="github"></a>
                    <?php endif; ?>

                    <?php if (!empty($userPosts[0]['social_instagram'])) : ?>
                        <a href="<?php echo htmlspecialchars($userPosts[0]['social_instagram']); ?>" class="btn btn-outline-primary mb-2"><img src="assets/icons/icon_instagram.png" alt="instagram"></a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
            </div>
        </div>
        <div>
            <div class="d-flex header mr-auto p-2 ">
                <div class="">
                    <h3>My featured projects</h3>
                </div>
                <div class="p-2">
                    <a href="profile.php?p=<?php echo $userData['id'] ?>" name="smashedprojects" class="btn btn-outline-primary">All projects</a>
                </div>
            </div>

            <?php if (!empty($emptyState)) : ?>
                <div class="empty-state">
                    <img class="d-block mx-auto" src="assets/images/empty-state-weareimd.png" alt="empty state">
                </div>
            <?php else : ?>
                <div class="row justify-content-start">
                    <?php foreach ($posts as $key => $p) : ?>
                        <?php $tags = Post::getTagsFromPost($p[0]); ?>
                        <div class="d-flex flex-column">
                            <h2><?php echo $p['title']; ?></h2>
                            <img src="<?php echo $p['image']; ?>" width="100%" height="500px" class="img-project-post" style="object-fit:cover">
                            <div>

                                <a href="post.php?p=<?php echo $p[0]; ?>">

                                </a>
                                <p class="pe-4"><?php echo $p['description']; ?>
                                    <?php foreach ($tags as $tag) : ?>
                                        <span class="link-primary"><?php echo $tag['tag']; ?></span>
                                    <?php endforeach; ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="javascript/follow.js"></script>
    <script src="javascript/report-user.js"></script>
    <script src="javascript/smashed.js"></script>
</body>

</html>