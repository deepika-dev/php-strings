<?php
$value = "Consolidation scenario (Time & Billing). Values: 0 = No consolidation, 1 = Item, 2 = Item + Project, 3 = Item + Employee, 4 = Item + Employee + Project, 5 = Project + WBS + Item, 6 = Project + WBS + Item + Employee. Item means in this case including Unit and Price, these also have to be the same to consolidate";
$result = NULL;
        $search=array("Values:","values:","unit:","entry:","status:"); /* Search Description for given values in array */
        $explodevalues = explode(" ",$value);
        $p = array_intersect($search,$explodevalues);
        $searchResult = array_filter($p);
         if(!empty($searchResult)){
            $availableValue = array_shift($searchResult);
            /* Get matching string from search array */
            $extracted = substr($value, strpos($value, $availableValue)+strlen($availableValue));
            /* Extracting required string to generate values */
            $converted = explode(",",trim($extracted));
            /* Check for presence of = or - or : in string */
            for($i=0; $i < count($converted); $i++){
                if(preg_match("/=|-|:/i",$converted[$i])){
                    list($key, $value) = preg_split( "/=|-|:/", trim($converted[$i]));
                    if($value != NULL){
                       $result[$i] = array("id"=>$key, "description"=>trim($value));
                    }
                }
                else{
                    $result[$i-1]["description"] .= ','.$converted[$i]; /* if value has more than one ',' append new value to previous key */
                }
            }
             $result = array_values($result);
        }
        else if(strpos($value,'=') !== false && strpos($value,'(') === false) {  /* Search Description for "=" and ignore text with "("  in string */
            $explodevalues = explode(".",$value);
            for($i=0; $i < count($explodevalues); $i++){
                /* Check for presence of = or - or : in string */
                if(preg_match("/=|-|:/i",$explodevalues[$i])){
                    if(strpos($explodevalues[$i],',') !== false){
                        $converted = explode(",",trim($explodevalues[$i]));
                        for($j=0; $j < count($converted); $j++){
                            list($key, $value) = preg_split( "/=|-|:/", trim($converted[$j])); /* split string into array using = or - or : */
                            $result[] = array("id"=>$key, "description"=>trim($value));
                        }
                    }
                    else{
                        list($key, $value) = preg_split( "/=|-|:/", trim($explodevalues[$i]));  /* split string  into array using = or - or : */
                        $result[] = array("id"=>$key, "description"=>trim($value));
                    }
                }
            }
        }
        var_dump($result);
 
	?>