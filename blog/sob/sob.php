<?php
$blog = new Blog;
$comments = new Comments;
$db = new Db;
$db->dbConnect();

/* Processing */

//sanitize & simplify
if ($_GET) {
    $cleanGet = array();
    $cleanGet = $db->sanitize($_GET);
    extract($cleanGet);

}
if ($_POST) {
    $cleanPost = array();
    $cleanPost = $db->sanitize($_POST);
    extract($cleanPost);

}

//add comment
if ($postComment && $id && $copy && $author) {
    //check ip
    $ip = $_SERVER['REMOTE_ADDR'];
    $banned = $comments->isBanned($ip);

    if (!$banned) {
        $comments->add($id, $copy, $author, $ip);
    } else {
        echo "<span id=\"message\">Banned User</span>";
    }

}

//display comment page
if (($comment || $postComment) && $id) {
    echo $blog->displayOne($id);
    $comments->form($id);
#	echo "<hr />";

} else {
    //comment check
    $ids = array();
    $ids = $blog->ids();

    $check = array();
    $check = $comments->check($ids);

    //display posts
    $entries = $blog->display($check);
    echo $entries;
}
?>
