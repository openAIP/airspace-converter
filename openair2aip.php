<?php

include "includes/open_aip_airspace.converter.aspc_converter.inc";

// recreate the output dir..
rrmdir("./aip_out");
mkdir("./aip_out");

$aspConverter = new AirspaceConverter();

if ($handle = opendir('./openair_in')) {
   
  while (false !== ($file = readdir($handle))) 
  {
    if ($file != "." && $file != "..") 
    {
      if (substr ($file, 2, 1) != "_")
      {
        echo "Skip $file..<BR>\n";
        continue;
      }
      
      echo "Processing $file..<BR>\n";
        
      if (!$aspConverter->loadFile("./openair_in/$file", "OPENAIR"))
      {
        echo $aspConverter->warnings;
        echo $aspConverter->errors;
        echo "FAILED<BR>\n";
        continue;
      }
            
      $inputCountryCode = strtolower(substr($file, 0, 2));
      $aipFileName = "./aip_out/".$inputCountryCode."_asp.aip";
      
      if ($aspConverter->writeToFile($aipFileName, "OPENAIP", "23"))
      {
	      echo $aspConverter->warnings;
	      echo "OK<BR>\n";
      }
      else
      {
        echo $aspConverter->warnings;
        echo $aspConverter->errors;

        echo "FAILED<BR>\n";
      }    
    }
  }
  
  closedir($handle);
}

echo "Finished<BR>\n";

?>


