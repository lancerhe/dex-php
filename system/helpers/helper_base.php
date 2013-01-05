<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');

function site_url($url = '') {
    if ( $url ) {
        $url = ltrim($url, '/');
        $Dex =& getInstance();
        $url_mode   = $Dex->config->get('ROUTER_URL_MODE');
        $router_var = $Dex->config->get('ROUTER_VAR');
        if ($url_mode == 1)
            return rtrim(BASE_URL, '/') . "/index.php?{$router_var}=" . $url;
        else
            return rtrim(BASE_URL, '/') . '/' . $url;
    }
    return rtrim(BASE_URL, '/');
}


function strcut($str, $len, $end = '...') {
    $i=$j=0;
    $strlen = mb_strlen($str, 'UTF-8');

    for($i=0; $i < $strlen; $i++) {
        if(strlen(mb_substr($str, $i, 1, 'UTF-8')) > 1) {
            $j+=2;
        } else {
            $j++;
        }

        if($j >= $len) break;
    }

    $returnStr  = mb_substr($str, 0, ++$i, 'UTF-8');
    $returnStr .= $j < $len ? '' : $end;

    return $returnStr;
}


function mynl2br($string) {
    $string = str_replace(' ', '&nbsp;', $string);
    $string = str_replace(array("\r\n", "\r", "\n"),'<br />', $string);
    return $string;
}

function mybr2nl($string){
    $string = preg_replace('/\<br(\s*)?\/?\>/i', chr(13), $string);
    $string = preg_replace('/&nbsp;/i', ' ', $string);
    return $string;
}

function create_file($file, $content){	
	if (file_exists($file) ) 
        unlink($file);
    
	$result = true;
	$fp = fopen($file, "w");
	if ( fwrite($fp, $content) === false) 
        $result = false;
	fclose($fp);
	return $result;	
}