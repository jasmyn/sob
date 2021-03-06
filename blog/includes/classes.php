<?php
class Db
{
    public function dbConnect()
    {
        include 'db_vars.inc';

        $db = mysql_connect($host, $dbuser, $dbpass);
        if (!$db) {
            die("Cannot connect to mySQL.");
        }

        mysql_select_db($dbname, $db)
            or die("Cannot connect to database.");
    }

    public function sanitize($dirty)
    { //takes an array, must be connected to db
        $clean = array();

        foreach	($dirty as $key => $value) {

            $clean["$key"] = mysql_real_escape_string($value);

        }

        return $clean;
    }

    public function q($q, $return = 'result')
    {
        if ($r = mysql_query($q) or die ( mysql_errno() + "<br />" + mysql_error() )) {
            if ($r === true) { //if it's true (statement doesn't return a result set/ resourse (INSERT, UPDATE, DELETE, DROP, etc)) don't try to fetch an object from the resource
                return 1;
            } else { //otherwise process the resource (SELECT, SHOW, DESCRIBE, EXPLAIN, etc)
                $d = mysql_fetch_object($r);
                return $d;
            }
        } else {
            return 0;
        }
    }

}

class Comments
{
    public function add($id, $copy, $author, $ip)
    {
        $db = new Db;
        $db->dbConnect();
        $db->q("insert into comments values ('', '$id', '$author', '$copy', '$ip', now())");
    }

    public function form($id)
    {?>
    <br />
    <h3>Add Something</h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Author: <input type="text" name="author" /><br />
        Comment: <textarea name="copy" /></textarea><br />
        <input type="hidden" name="ip" value="<?php echo $ip; ?>" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="postComment" value="1" />
        <input type="submit" value="Submit Comment" />
    </form>
    <br /><a href="<?php echo $_SERVER['PHP_SELF']; ?>" style="color:#b6b6b6;position:relative;left:420px;">Return to Posts</a><br /><br />
    <?php
    }

    public function check($ids)
    { //pass it the kind of array returned from Blog->ids()
        $check = array();
        foreach ($ids as $key => $value) {

            $q = "select id from comments where postId = $value";
            $r = mysql_query($q);

            $num = mysql_num_rows($r);

            if ($num > 0) {

                $check[$value] = $num;

            } else {

                $check[$value] = 0;

            }

        }
        return $check;
    } //returns an array, key = postId, value = number of comments

    public function isBanned($ip)
    {
        $q = "select * from banned where ip = '$ip'";
        $r = mysql_query($q);
        $rows = mysql_num_rows($r);

        if ($rows > 0) {

            return 1;

        } else {

            return 0;

        }
    }
}

class Blog
{
    public function display($check)
    {
        $q = "select * from blog order by posted desc";
        $r = mysql_query($q);

        $blog = '';

        $blog .= "\n\t<div id=\"blog\">\n";

        while ($d = mysql_fetch_object($r)) {

            $blog .= "\t\t<span class='posted'>".stripslashes($d->posted)."</span><br />\n";
            $blog .= "\t\t<span class='title'>".stripslashes($d->title)."</span><br />\n";
            $blog .= "\t\t<span class='copy'>".stripslashes($d->copy)."</span><br />\n";

            if ($d->tags) {

                $blog .= "\t\t<span class='tags'>".stripslashes($d->tags)."</span><br />\n";

            }

            if ($check[$d->id] != 1) {
                $s = 's';
            } else {

                $s = '';

            }

            $blog .= "\t\t<span class='comment'><a href=\"".$_SESSION['PHP_SELF']."?comment=1&id=".$d->id."\">[".$check[$d->id]." comment$s]</a></span><br /><br />\n\n";
        }

        $blog .= "\t</div>\n";

        return $blog;
    }

    public function displayOne($id)
    {
        $post = '';

        $post .= "\n\t<div id=\"blog\">\n";

        $q = "select * from blog where id='$id'";
        $r = mysql_query($q);

        while ($d = mysql_fetch_object($r)) {

            $post .= "\t\t<span class='posted'>".stripslashes($d->posted)."</span><br />\n";
            $post .= "\t\t<span class='title'>".stripslashes($d->title)."</span><br />\n";
            $post .= "\t\t<span class='copy'>".stripslashes($d->copy)."</span><br />\n";

            if ($d->tags) {

                $post .= "\t\t<span class='tags'>".stripslashes($d->tags)."</span><br />\n";

            }

        }

        $post .= "\t</div>\n";

        $post .= "\n\t<div id=\"comments\">\n";

        $post .= "\n\t<h3>Comments</h3>";

        $q = "select * from comments where postId='$id' order by posted desc";
        $r = mysql_query($q);

        while ($d = mysql_fetch_object($r)) {

            $post .= "\t\t<span class='author'>".stripslashes($d->author)."</span><br />\n";
            $post .= "\t\t<span class='comment'>".stripslashes($d->copy)."</span><br /><br />\n\n";

        }

        $post .= "\t</div>\n";

        return $post;
    }

    public function ids()
    { //returns an array with the values corresponding to your post id
        $IDs = array();
        $q = 'select id from blog';
        $r = mysql_query($q);
        while ($d = mysql_fetch_object($r)) {
            $IDs[] = $d->id;
        }
        return $IDs;
    }
}
?>
