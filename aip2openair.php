<?php

include "includes/open_aip_airspace.converter.aspc_converter.inc";

// recreate the output dir..
rrmdir("./openair_out");
mkdir("./openair_out");

$aspConverter = new AirspaceConverter();

if ($handle = opendir('./aip_in')) {
   
  while (false !== ($file = readdir($handle))) 
  {
    if ($file != "." && $file != "..") 
    {
      if (substr ($file, -3) != "aip")
      {
        echo "Skip $file..<BR>\n";
        continue;
      }
      
      echo "Processing $file..<BR>\n";
        
      if (!$aspConverter->loadFile("./aip_in/$file", "OPENAIP"))
      {
        echo $aspConverter->warnings;
        echo $aspConverter->errors;
        echo "LOAD FAILED<BR>\n";
        continue;
      }
            
      $openairFileName = "./openair_out/". str_replace("aip", "txt", $file);
      
      if ($aspConverter->writeToFile($openairFileName, "OPENAIR", "23"))
      {
	      echo $aspConverter->warnings;
	      echo "OK<BR>\n";
      }
      else
      {
        echo $aspConverter->warnings;
        echo $aspConverter->errors;

        echo "WRITE FAILED<BR>\n";
      }    
    }
  }
  
  closedir($handle);
}

echo "Finished<BR>\n";

?>


