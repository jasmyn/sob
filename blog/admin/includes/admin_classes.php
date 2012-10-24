<?php
class Blogman
{	
	public function display()
	{
		$q = "select * from blog order by posted desc";
		$r = mysql_query($q);

		$blogman = '<h3>Current Posts</h3>';

		$blogman .= "\t<div id=\"blog\">\n";

		while ($d = mysql_fetch_object($r)) {

			$blogman .= "\t\t<a href=".$_SERVER['PHP_SELF']."?del=1&id=$d->id>[del]</a>&nbsp<a href=".$_SERVER['PHP_SELF']."?edit=1&id=$d->id>[edit]</a>&nbsp<span class='posted'>".$d->title."</span><br />\n";

		}

		$blogman .= "\t</div>\n";

		return $blogman;
	}

	public function addPost($title, $copy, $tags = '')
	{
		$q = "insert into blog values ('','$title','$copy',now(),'$tags')";
		if ($r = mysql_query($q)) {

			echo "<b>Post Added</b>";

		}
	}

	public function delPost($id)
	{
		$db = new Db;
		$result = $db->q("delete from blog where id = $id", 'bool');

		if ($result) {

			echo "Post Deleted";
			
		}

#		$q = "delete from blog where id = $id";
#		if ($r = mysql_query($q)) {

#			echo "<b>Post Deleted</b>";

#		}
	}

	public function editForm($id)
	{
		$q = "select * from blog where id = $id";
		$r = mysql_query($q);
		$d = mysql_fetch_object($r);
	?>
		<h3>Edit Post</h3>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			Title: <input type="text" name="title" value="<?php echo $d->title; ?>" /><br />
			Copy: <textarea name="copy"><?php echo $d->copy; ?></textarea><br />
			Tags: <input type="text" name="tags" value="<?php if ($d->tags) echo $d->tags; ?>" /><br />
			<input type="hidden" name="editsubmit" value="1" />
			<input type="hidden" name="id" value="<?php echo $d->id; ?>" />
			<input type="submit" value="Submit Changes" /><br />
		</form>
	<?php
	}

	public function editSubmit($id, $title, $copy, $tags = '')
	{
		$q = "update blog set title='$title', copy='$copy', tags='$tags' where id = $id";
		if ($r = mysql_query($q)) {
			echo "<b>Post Updated</b>";
		}
	}

	public function inputForm()
	{?>
		<br />
		<h3>New Post</h3>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			Title: <input type="text" name="title" /><br />
			Copy: <textarea name="copy" /></textarea><br />
			Tags: <input type="text" name="tags" /><br />
			<input type="hidden" name="add" value="1" />
			<input type="submit" value="Submit Post" />
		</form>
	<?php	
	}
}

class Commentman
{
	public function display($order='posted')
	{
		$q = "select * from comments order by $order desc";
		$r = mysql_query($q);

			while ($d = mysql_fetch_object($r)) {

				echo "<a href=\"".$_SERVER['PHP_SELF']."?del=1&id=".$d->id."\" >[delete]</a> <a href=\"".$_SERVER['PHP_SELF']."?ban=1&ip=".$d->ip."\" >[ban ip]</a> ".$d->copy." ".$d->ip."<br />";

			}
	}

	public function del($id)
	{
		$q = "delete from comments where id = $id";
		if ($r = mysql_query($q)) {


			echo "<b>Comment Deleted</b><br /><br />\n\n";

		} else {

			echo "<b>Problem Deleting Comment</b><br /><br />\n\n";

		}
	}

	public function ban($ip)
	{
		$q = "insert into banned values ('', '$ip')";
		if ($r = mysql_query($q)) {

			echo "<b>IP Banned</b><br /><br />\n\n";

		}
	}

	public function unban($ip)
	{
		$q = "delete from banned where ip = '$ip'";
		if ($r = mysql_query($q)) {

			echo "<b>IP Unbanned</b><br /><br />\n\n";

		}
	}

	public function banned()
	{
		echo "<h2>Banned IPs</h2>";
		$q = "select * from banned";
		$r = mysql_query($q);
		while ($d = mysql_fetch_object($r)) {

			echo "<a href=\"".$_SERVER['PHP_SELF']."?unban=1&ip=".$d->ip."\">[unban]</a> ".$d->ip."<br />\n";

		}
	}

	public function ipSortButton()
	{?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>?sortIp=1">
			<input type="submit" value="Sort by IP" />
		</form>
	<?php
	}
}
?>
