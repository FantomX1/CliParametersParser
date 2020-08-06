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
     * @return array|false|int|string
     */
    public function parse()
    {


        $params = implode(" ", $GLOBALS['argv']);


// replace by a single value
//$params = preg_replace('/\-{1,2}[a-zA-z]+ *= */','|', $params);

        $params = preg_match_all(
            '/'.
            '( (?<!-)\-{1,2}[a-zA-z]+ *=? *)'.

            // do not accept even the first dash
            '([^-]*(?!\-)+'.
            // value, not followed by -
            //'(?!\-)'.
            ')/',
            $params,
            $matches
        );


// params, left side
        // trims every element by a character in another array passed as a 3rd parameter with pregenerated ' ' values
        $params = array_map('trim', $matches[1], array_fill(0,count($matches[1]),' '));


// params , left side , paramL=valueR
        foreach ($params as &$param) {
            // remove  single letter params with double dash prefix
            if (strpos($param, "--")!==false && strlen($param)<=5){
                echo $param." \n\n\n\n";
                //unset($el);
                $param = "";
            }
        }



        $params = array_map('trim', $params, array_fill(0, count($params),'-'));
        $params = array_flip($params);


// to be able to find param, also by the first letter, use in code by first letter
        foreach ($params as $resKey => $resItem) {

            // was removed as incorrect double dash -- usage for shortened parameters
            if (empty($resKey)) {
                continue;
            }
            // array index0 values1
            // array inddex0 values2
            // indexValues1 valuesIndex0
            // indexValues1 = values2[valuesIndex0]

            // map values from the second array, corresponding by keys, values pushed to keys, other values mapped by same,
            // could be used array combine
            //$resKey0= first item
            $params[$resKey] = $params[$resKey[0]] = $matches[2][$resItem];

        }


        return $params;
    }





}
