<?php

namespace Bluethink\Actionlog\Helper;

/**
 * Bluethink time helper
 * @category    Bluethink
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var Magento\Framework\Stdlib\DateTime\TimezoneInterface
    */
    protected $_timezoneInterface;
 
    /**
    * @param \Magento\Framework\App\Helper\Context $context
    * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
    */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        //time zone interface 
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
    ) 
    {
        $this->_timezoneInterface = $timezoneInterface;
        parent::__construct($context);
    }
 
    /**
     * @param string $dateTime
     * @return string $dateTime as time zone
    */
    public function getTimeAccordingToTimeZone($dateTime)
    {
        // for get current time according to time zone
        $today = $this->_timezoneInterface->date()->format('m/d/y H:i:s');
 
        // for convert date time according to magento time zone
        $dateTimeAsTimeZone = $this->_timezoneInterface
                                        ->date(new \DateTime($dateTime))
                                        ->format('m/d/y H:i:s');
        return $dateTimeAsTimeZone;
    }
     function get_client_ip() 
    { 
        $ipaddress = ''; 
        if (isset($_SERVER['HTTP_CLIENT_IP'])) 
            $ipaddress = $_SERVER['HTTP_CLIENT_IP']; 
            else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_X_FORWARDED'])) 
            $ipaddress = $_SERVER['HTTP_X_FORWARDED']; 
            else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) 
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_FORWARDED'])) 
            $ipaddress = $_SERVER['HTTP_FORWARDED']; 
            else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR']; 
        else $ipaddress = 'UNKNOWN'; 
        return $ipaddress; 
    }

    function getBrowser() 
   { 
        $u_agent = $_SERVER['HTTP_USER_AGENT']; 
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Internet Explorer'; 
            $ub = "MSIE"; 
        } 
        elseif(preg_match('/Trident/i',$u_agent)) 
        { // this condition is for IE11
            $bname = 'Internet Explorer'; 
            $ub = "rv"; 
        } 
        elseif(preg_match('/Firefox/i',$u_agent)) 
        { 
            $bname = 'Mozilla Firefox'; 
            $ub = "Firefox"; 
        } 
        elseif(preg_match('/Chrome/i',$u_agent)) 
        { 
            $bname = 'Google Chrome'; 
            $ub = "Chrome"; 
        } 
        elseif(preg_match('/Safari/i',$u_agent)) 
        { 
            $bname = 'Apple Safari'; 
            $ub = "Safari"; 
        } 
        elseif(preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Opera'; 
            $ub = "Opera"; 
        } 
        elseif(preg_match('/Netscape/i',$u_agent)) 
        { 
            $bname = 'Netscape'; 
            $ub = "Netscape"; 
        } 
        
        // finally get the correct version number
        // Added "|:"
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
         ')[/|: ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    } 

}