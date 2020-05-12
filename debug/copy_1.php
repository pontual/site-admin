<pre>
<?php

$src_dir = "../../fotos/ptlsite/";
$dest_dir = "../../fotos/v2_1/";

$files = scandir($src_dir);

foreach ($files as $file) {
  if (substr(strtolower($file), -3) === "jpg") {
    $new_filename = $dest_dir . pathinfo($file, PATHINFO_FILENAME) . "_1.jpg";
    
    print("copy $file to $new_filename");
    copy($src_dir . $file, $new_filename);
    print("\n");
  }
}

?>
