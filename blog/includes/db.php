<?php
class Db
{
    public function dbConnect()
    {
        include 'db_vars.inc';

			$db = mysql_connect($host, $dbuser, $dbpass)
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

        if ($r = mysql_query($q)) {

            $d = mysql_fetch_object($r);

            if ($return = 'result') {

                return $d;

            } elseif ($return = 'bool') {

                return 1;

            }

        } else {

            return 0;

        }

    }

}

$db = new Db;
$db->dbConnect();
?>
