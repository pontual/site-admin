<pre>
<?php

require_once("../util.php");

$thumbWidth = 200;
$thumbHeight = 150;

$src_dir = "../../fotos/v2_1/";
$dest_dir = "../../fotos/v2_1/thumbs/";

$files = scandir($src_dir);

foreach ($files as $file) {
  if (substr(strtolower($file), -3) === "jpg") {
    $src_file = $src_dir . $file;
    $new_filename = $dest_dir . pathinfo($file, PATHINFO_FILENAME) . "_thumb.jpg";
    
    print("create $new_filename from $src_file");
    smart_resize_image($src_file, null, $thumbWidth, $thumbHeight, true, $new_filename, false, false, 100);
    print("\n");
  }
}

?>
