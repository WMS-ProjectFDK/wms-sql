<?php

$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

function get_client_ip_env() {
 $ipaddress = '';
 if (getenv('HTTP_CLIENT_IP'))
  $ipaddress = getenv('HTTP_CLIENT_IP');
 else if(getenv('HTTP_X_FORWARDED_FOR'))
  $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
 else if(getenv('HTTP_X_FORWARDED'))
  $ipaddress = getenv('HTTP_X_FORWARDED');
 else if(getenv('HTTP_FORWARDED_FOR'))
  $ipaddress = getenv('HTTP_FORWARDED_FOR');
 else if(getenv('HTTP_FORWARDED'))
  $ipaddress = getenv('HTTP_FORWARDED');
 else if(getenv('REMOTE_ADDR'))
  $ipaddress = getenv('REMOTE_ADDR');
 else
  $ipaddress = 'UNKNOWN IP Address';

 return $ipaddress;
}

function get_os(){ 
    global $user_agent;
    $os_platform    =   "Unknown OS Platform";
    $daftar_os      =   array(
       '/windows nt 10.0/i'    =>  'Windows 10',
       '/windows nt 6.3/i'     =>  'Windows 8.1',
       '/windows nt 6.2/i'     =>  'Windows 8',
       '/windows nt 6.1/i'     =>  'Windows 7',
       '/windows nt 6.0/i'     =>  'Windows Vista',
       '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
       '/windows nt 5.1/i'     =>  'Windows XP',
       '/windows xp/i'         =>  'Windows XP',
       '/windows nt 5.0/i'     =>  'Windows 2000',
       '/windows me/i'         =>  'Windows ME',
       '/win98/i'              =>  'Windows 98',
       '/win95/i'              =>  'Windows 95',
       '/win16/i'              =>  'Windows 3.11',
       '/macintosh|mac os x/i' =>  'Mac OS X',
       '/mac_powerpc/i'        =>  'Mac OS 9',
       '/linux/i'              =>  'Linux',
       '/ubuntu/i'             =>  'Ubuntu',
       '/iphone/i'             =>  'iPhone',
       '/ipod/i'               =>  'iPod',
       '/ipad/i'               =>  'iPad',
       '/android/i'            =>  'Android',
       '/blackberry/i'         =>  'BlackBerry',
       '/webos/i'              =>  'Mobile'
                        );

    foreach ($daftar_os as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }   
    return $os_platform;
}

function getting_browser(){
    global $user_agent;
    $browser        =   "Unknown Browser";
    $daftar_browser  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($daftar_browser as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }
    }
    return $browser;
}

function get_mac(){
  ob_start(); // Turn on output buffering
  system('ipconfig /all'); //Execute external program to display output
  $mycom=ob_get_contents(); // Capture the output into a variable
  ob_clean(); // Clean (erase) the output buffer
  $findme = "Physical";
  $pmac = strpos($mycom, $findme); // Find the position of Physical text
  $mac=substr($mycom,($pmac+36),17); // Get Physical Address
  return $mac;
}

function get_mac_addr(){
  $_IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
  $_PERINTAH = "arp -a $_IP_ADDRESS";
  ob_start();
  system($_PERINTAH);
  $_HASIL = ob_get_contents();
  ob_clean();
  $_PECAH = strstr($_HASIL, $_IP_ADDRESS);
  $_PECAH_STRING = explode($_IP_ADDRESS, str_replace(" ", "", $_PECAH));
  $_HASIL = strtoupper(substr($_PECAH_STRING[1], 0, 17));

  return $_HASIL;
}

$user_os        =   get_os();
$user_browser   =   getting_browser();
$ip_user  = get_client_ip_env();
$mac_user = get_mac();
$get_addr = get_mac_addr();
?>