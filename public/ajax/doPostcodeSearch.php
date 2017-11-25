<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

if(isset($_GET["postcode"])){
    $postcode = filter_var($_GET["postcode"],FILTER_SANITIZE_STRING);
} else {
    $postcode = '';
}
if($postcode != ''){

    if (preg_match('#^(GIR ?0AA|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]([0-9ABEHMNPRV-Y])?)|[0-9][A-HJKPS-UW]) ?[0-9][ABD-HJLNP-UW-Z]{2})$#', $postcode)) {
        // The UK post code is valid according to your criteria
        $firstChar = substr($postcode,0,1);
        $postcodeArr = explode(' ',$postcode);
        $secondBit = $postcode[0];
        $whole = str_replace(' ','-',$postcode);
        $url = "http://www.192.com/places/" . $firstChar . '/' . $secondBit . '/' . $whole;
        require_once('../../includes/simple_html_dom.php');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36');
        $output = curl_exec($ch);
        curl_close($ch);

        $html = new simple_html_dom($output);
        $table = $html->find('#js-ont-addresses-table');

        $addArr = array();
        foreach($html->find('.js-ont-full-address') as $address){
            $address = strip_tags($address);
            $temp = explode(',',$address);
            $arrLength = sizeof($temp);
            $addressObj = new stdClass();
            $add1 = '';
            for($ix = 0;$ix < $arrLength - 3;$ix++){
                if($add1 != ''){
                    $add1 .= ',';
                }
                $add1 .= $temp[$ix];
            }
            //$addressObj->add1 = $temp[0] . ',' .$temp[1];
            $addressObj->add1 = $add1;
            $addressObj->add2 = trim($temp[$arrLength - 3]);
            $addressObj->add3 = trim($temp[($arrLength - 2)]);
            $addressObj->full = $address;
            $addArr[$temp[0]] = $addressObj;
        }
        asort($addArr);
        $out = new stdClass();
        $out->addresses = $addArr;
        echo json_encode($out);
    }
}