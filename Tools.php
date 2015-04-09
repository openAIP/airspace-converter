<?php 

function utf8_fileWrite($fileHandle, $stringData)
{
  fwrite($fileHandle, utf8_encode($stringData));
}

function copyFromUrlToFile($url, $dirname, $filename)
{
  $file = fopen ($url, "rt"); 

  if (!$file) 
  { 
    return 0;
  }
  else
  {
    $fc = fopen($dirname."/".$filename, "wb"); 
    while (!feof ($file)) 
    {
      $line = fread($file, 1028);
      fwrite($fc, utf8_encode($line));
      //fwrite($fc,$line); 
    } 
    fclose($fc);  
    return 1;
  } 
}

function copyFromUrl($url, $dirname)
{
  $file = fopen ($url, "rb"); 
  if (!$file) 
  { 
    return 0;
  }
  else
  {
    $filename = basename($url); 
    
    $fc = fopen($dirname."/".$filename, "wb"); 
    while (!feof ($file)) 
    {
      $line = fread ($file, 1028); 
      fwrite($fc,$line); 
    } 
    fclose($fc);  
    return 1;
    } 
}

function zipDir($dir, $zipFile)
{
  echo "<BR>\nCreating Zip Archive ".$zipFile."..<BR>\n";

  @unlink($zipFile);

  $zipArch = new ZipArchive();
  $zipArch->open($zipFile, ZIPARCHIVE::CREATE);

  if ($handle = opendir($dir)) 
  {
    while (false !== ($file = readdir($handle)))
    {
      if ($file != "." && $file != "..")
      {
        echo "Adding $dir/$file to Archive as $file..<BR>\n";
        $zipArch->addFile($dir."/".$file, $file);
      }
    }
    closedir($handle);
  }
  
  $zipArch->close();
  echo "Done<BR>\n";
}

function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }

?>