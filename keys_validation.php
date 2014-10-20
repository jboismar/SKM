<?php
  file_put_contents("/tmp/key", str_replace('%2B', '+', $_GET["key"]));
  system("ssh-keygen -lf /tmp/key", $retval);
  system("rm /tmp/key");
?>


