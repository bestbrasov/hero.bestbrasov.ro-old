<?php
$fh = fopen("lastcheck.txt","w");
fwrite($fh, time());
fclose($fh);
?>