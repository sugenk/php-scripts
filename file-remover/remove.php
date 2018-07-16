<?php
$target_dir  = '/home/user';
$target_file = 'target-file.ext';
FileRemover($target_dir, $target_file);
function FileRemover($dir, $file)
{
    $ffs     = scandir($dir);
    $subfile = $file;
    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);
    // prevent empty ordered elements
    if (count($ffs) < 1)
        return;
    foreach ($ffs as $ff) {
        if (is_dir($dir . '/' . $ff)) {
            // recursive
            FileRemover($dir . '/' . $ff, $subfile);
        }
        if (substr($ff, -1 * strlen($file)) == $file) {
            // unlink or remove file
            @unlink($dir . "/" . $ff); // as you wish
        }
    }
}
?>
