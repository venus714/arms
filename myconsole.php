<?php

function write_to_console($data) {
 $console = $data;
 if (is_array($console))
 {
 $console = implode(',', $console);

 echo "<script>console.log('Console: " . $console . "' );</script>";
}}
write_to_console(['Hello','to this World']);
write_to_console([1,2,3]);

?>