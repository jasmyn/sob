<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>SOB::CommentMan</title>
</head>
<body>
<?php
//load classes
include '../includes/classes.php';
include 'includes/admin_classes.php';

//connect to db
$db = new Db;
$db->dbConnect();

echo '<h1>SOB::commentman</h1>';

$commentman = new Commentman;

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

//del comment
if ($del && $id) {
    $commentman->del($id);
}

//display comments
if ($sortIp) {
    $order = 'ip';
} else {
    $order = 'posted';
}

//ban IP
if ($ban && $ip) {
    $commentman->ban($ip);
}

//unban IP
if ($unban && $ip) {
    $commentman->unban($ip);
}

//display comments
echo $commentman->display($order);

//banned IPs
$commentman->banned();
?>
</body>
</html>
