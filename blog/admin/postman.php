<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>SOB::PostMan</title>
</head>
<body>
<?php
//load classes
include '../includes/classes.php';
include 'includes/admin_classes.php';

//connect to db
$db = new Db;
$db->dbConnect();

echo '<h1>SOB::postman</h1>';

$blogman = new Blogman;

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

//add post
if ($add && $title && $copy) {
    if (!$tags) {
        $tags = '';
    }
    $blogman->addPost($title, $copy, $tags);

}

//del post
if ($del && $id) {
    $blogman->delPost($id);
}

//show edit form
if ($edit && $id) {
    $blogman->editForm($id);
}

//submit update
if ($editsubmit && $id && $title && $copy) {
    if ($tags) {
        $blogman->editSubmit($id, $title, $copy, $tags);
    } else {
        $blogman->editSubmit($id, $title, $copy);
    }
}


//display posts
echo $blogman->display();

//add post
$blogman->inputForm();
?>
<script type="text/javascript" src="../../scripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode : "textareas"
    });
</script>
</body>
</html>
