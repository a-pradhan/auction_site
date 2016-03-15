DateTime::RFC850
2016-03-19 21:39:00

<?php
$time = strtotime("2016-03-19 21:39:00");
$newformat = date('D, d H:i',$time);
echo htmlentities($time);
echo "<br />";
echo "<br />";
echo htmlentities($newformat);

$stringen = "" . $newformat;
echo "<br />";
echo htmlentities($stringen);

?>


