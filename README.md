# airspace-converter
Toolset of PHP CLI scripts to convert between several airspace formats. The following format conversions are supported:

* openAIR -> aip
* openAIR -> gml
* aip -> openAIR ( **This converter outputs polygons only!** )

The specific scripts can be found in the project root. Each script takes one input file as argument.
Depending on the used converter script, a directory that includes the converted file in the desired target format is 
created.

## Usage examples

`php openair2gml.php openair_in/de_openair.txt`

This command will read the input file `de_openair.txt` from the `openair_in/` directory. The converted file 
`de_asp.gml` can be found in the `gml_out/` folder after a successful conversion.


`php openair2aip.php openair_in/de_openair.txt`

This command will read the input file `de_openair.txt` from the `openair_in/` directory. The converted file 
`de_asp.aip` can be found in the `aip_out/` folder after a successful conversion.


`php aip2openair.php aip_in/de_asp.aip`

This command will read the input file `de_asp.aip` from the `aip_in/` directory. The converted file `airspace_de.txt`
can be found in the `openair_out/` folder after a successful conversion.
