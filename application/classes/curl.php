<?php defined('SYSPATH') or die('No direct script access.');

class Curl {

    private $_useragent = "Mozilla/4.0";
    private $_timeout = 10;
    private $_status;
    private $_encoding;
    private $_data;

    public function __construct($url, $encoding = null)
    {
        $this->exec($url, $encoding);
    }

    private function exec($url, $encoding = null)
    {
        // is cURL installed yet?
        if ( ! function_exists('curl_init'))
        {
            die('Sorry cURL is not installed!');
        }

        // OK cool - then let's create a new cURL resource handle
        $ch = curl_init();

        // Now set some options (most are optional)

        // Set URL to download
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // User agent
        curl_setopt($ch, CURLOPT_USERAGENT, $this->_useragent);

        // Include header in result? (0 = yes, 1 = no)
        curl_setopt($ch, CURLOPT_HEADER, 0);

        // Should cURL return or print out the data? (true = return, false = print)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);

        // Download the given URL, and return output
        $output = curl_exec($ch);

        $this->_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($this->_status !== 200)
        {
            return false;
        }

        $this->_encoding = $encoding ? $encoding : self::get_charset(curl_getinfo($ch, CURLINFO_CONTENT_TYPE), $output);

        $this->_data = self::get_encoding_page($output, $this->_encoding);

        // Close the cURL resource, and free system resources
        curl_close($ch);

        return true;
    }

    public function get_charset($type, $page)
    {
        $charsets = array(
            'cp1251' => array('windows-1251'),
            'utf-8' => array('utf8'),
        );

        $charset = FALSE;

        preg_match('@([\w/+]+)(;\s+charset=(\S+))?@i', $type, $matches);

        if (isset($matches[3]))
        {
            $charset = $matches[3];
            $charset = rtrim($charset, ';');
        }

        preg_match("@<?xml.*encoding=\"([^\s\"]+)?@i", $page, $matches);

        if ( ! $charset AND isset($matches[1]))
        {
            $charset = $matches[1];
        }

        preg_match('@<meta\s+http-equiv="Content-Type"\s+content="([\w/]+)(;\s+charset=([^\s"]+))?@i', $page, $matches);

        if ( ! $charset AND isset($matches[3]))
        {
            $charset = $matches[3];
        }

        $charset = mb_strtolower($charset);

        foreach ($charsets as $true_charset => $charset_array)
        {
            if (in_array($charset, $charset_array))
            {
                $charset = $true_charset;
                break;
            }
        }

        return $charset;
    }

    public function get_encoding_page($html, $encoding)
    {
        if ($encoding == 'utf-8')
        {
            return $html;
        }
        else if ($encoding == 'cp1251' OR $encoding == 'koi8-r')
        {
            return iconv($encoding, 'utf-8', $html);
        }

        return $html;
    }

    public function getEncoding()
    {
        return $this->_encoding;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function getData()
    {
        return $this->_data;
    }
}
