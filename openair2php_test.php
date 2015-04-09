<?php

include "includes/open_aip_airspace.converter.aspc_converter.inc";

$aspConverter = new AirspaceConverter();

$testString = "AC F\n".
              "AN COTTBUS (HX)\n".
              "AL GND\n".
              "AH 2500GND\n".
              "DP 51:53:33 N 014:19:37 E\n".
              "DP 51:58:43 N 014:40:39 E\n".
              "DP 51:53:08 N 014:44:13 E\n".
              "DP 51:47:59 N 014:23:13 E\n";

echo "OpenAIR:\n";
echo $testString;

if (!$aspConverter->loadString($testString, "OPENAIR"))
{
  echo $aspConverter->warnings;
  echo $aspConverter->errors;
  echo "Loading Failed\n";
}
else
{
  echo "\nWKT:\n";

  $wkt = $aspConverter->getFirstAirspaceWkt();
  
  if (strlen($wkt) > 0)
  {
    echo $aspConverter->getFirstAirspaceWkt();
  }
  else
  {
    echo "FAILED\n";  
  }
}

echo "\n\n";

$testString = "DP 51:53:33 N 014:19:37 E\n".
              "DP 51:58:43 N 014:40:39 E\n".
              "DP 51:53:08 N 014:44:13 E\n".
              "DP 51:47:59 N 014:23:13 E\n";

echo "OpenAIR:\n";
echo $testString;

if (!$aspConverter->loadString($testString, "OPENAIR"))
{
  echo $aspConverter->warnings;
  echo $aspConverter->errors;
  echo "Loading Failed\n";
}
else
{
  echo "\nWKT:\n";

  $wkt = $aspConverter->getFirstAirspaceWkt();
  
  if (strlen($wkt) > 0)
  {
    echo $aspConverter->getFirstAirspaceWkt();
  }
  else
  {
    echo "FAILED\n";  
  }
}

echo "\n\n";

$testString = "V X=49:17:15 N 009:22:40 E\n".
              "DC 1.0\n";

echo "OpenAIR:\n";
echo $testString;

if (!$aspConverter->loadString($testString, "OPENAIR"))
{
  echo $aspConverter->warnings;
  echo $aspConverter->errors;
  echo "Loading Failed\n";
}
else
{
  echo "\nWKT:\n";

  $wkt = $aspConverter->getFirstAirspaceWkt();
  
  if (strlen($wkt) > 0)
  {
    echo $aspConverter->getFirstAirspaceWkt();
  }
  else
  {
    echo "FAILED\n";  
  }
}

?>


