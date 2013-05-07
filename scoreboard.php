<?php
include_once "config.php";
if ( isset ($_GET['top']) )
{
db_connect();
$rezultat=$mysqli->query("SELECT * FROM rezultat WHERE id_mode=0 ORDER BY rezultat DESC;");
if ($rezultat->num_rows > 0)
    echo "imamo neÅto";
else
    echo "nemamo rezultata";
db_disconnect();
}else
{echo "Nothing to see here";
}
?>
