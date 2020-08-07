<?php


//namespace fantomx1\CliParametersParser;

namespace fantomx1;


/**
 * Class CliParamsParser
 * @package fantomx1
 */
class CliParamsParser
{


    /**
     *
     * parses command line parameters into an array , eg . -p=value --directory=value -c=value --option valueOption
     *
     * @return array|false|int|string
     */
    public function parse()
    {

        // passed arguments are available in the $GLOBALS array
        $params = implode(" ", $GLOBALS['argv']);


// replace by a single value, not to replace but to match corresponding parameters to corresponding values
//$params = preg_replace('/\-{1,2}[a-zA-z]+ *= */','|', $params);

        $params = preg_match_all(
            '/'.
            // parameter is any item having beginning with 1-2 dashes, but not having a 3rd one before
            // followed by alpha characters (perhaps add numerical) followed by arbitrary number of spaces
            // or having an equal sign after
            '( (?<!-)\-{1,2}[a-zA-z]+ *=? *)'.

            // do not accept even the first dash, value cannot accept dash and ends up when a new dash begins
            // so cant contain and cannot be followed by a one, maybe should except space too
            '([^-]*(?!\-)+'.
            // value, not followed by -
            //'(?!\-)'.
            ')/',
            $params,
            $matches
        );


        // matches[1] = params, left side , matches[2] = params right side
        // trims every element by a character in another array passed as a 3rd parameter with pregenerated ' ' values
        $params = array_map('trim', $matches[1], array_fill(0,count($matches[1]),' '));


// params , left side , paramL=valueR
        foreach ($params as &$param) {
            // workaround the above regexp allowed params like --p, whereas it should allow only -p, or full size --param
            // remove  single letter params with double dash prefix , the regexp should be remade to this not complicately
            if (strpos($param, "--") !== false && strlen($param)<=5){
                echo $param." \n\n\n\n";
                //unset($el);
                $param = "";
            }
        }



        // trim any dashes from all the array elements, to have params in array ['-p','--directory'] => ['p', 'directory']
        $params = array_map('trim', $params, array_fill(0, count($params),'-'));
        // make param names indexes of an array
        // [0=>'p', 1=>'directory'] => ['p'=>'0', 'directory'=>'1']
        $params = array_flip($params);


        // map params (params' indexes) to their values ['p'=>'0', 'directory'=>'1'] = > ['p'=>'pParam', 'directory'=>'directoryParam']
        foreach ($params as $paramName => $paramIndex) {

            // if a param was removed (became empty) as incorrect double dash -- usage for shortened parameters
            if (empty($paramName)) {
                continue;
            }

            $params[$paramName] = $matches[2][$paramIndex];

        }
        $params = $this->mapParamsWithShortFlags($params);


        return $params;
    }

    /**
     * @param array $params
     * @return array
     */
    private function mapParamsWithShortFlags(array $params)
    {
// to be able to find param, also by the first letter, use in code by first letter
        foreach ($params as $paramName => $paramValue) {

            // array index0 values1
            // array inddex0 values2
            // indexValues1 valuesIndex0
            // indexValues1 = values2[valuesIndex0]

            // map values from the second array, corresponding by keys, values pushed to keys, other values mapped by same,
            // could be used array combine
            //$resKey0= first item
            $params[$paramName[0]] = $params[$paramName];
        }
        return $params;
    }


}
