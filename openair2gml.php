<?php

include "Tools.php";
include "includes/open_aip_airspace.converter.aspc_converter.inc";

if ($argc != 3) 
{
  echo "USAGE: php openair2gml.php <openair.txt> <out.gml>\n";
  exit(0);
}

$aspConverter = new AirspaceConverter();
if (!$aspConverter->loadFile($argv[1], "OPENAIR"))
{ 
  echo $aspConverter->warnings;
  echo $aspConverter->errors;
  echo "FAILED<BR>\n";
  exit();
}
      
if ($aspConverter->writeToFile($argv[2], "GML", "23"))
{
  echo $aspConverter->warnings;
  echo "OK\n";
}
else
{
  echo $aspConverter->warnings;
  echo $aspConverter->errors;
  echo "FAILED\n";
}    

?>


