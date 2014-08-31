<?php 
/*
    Filename: http-request.php
    Rev 2014.0829.2100
    Product: ip-addr-to-arin-cidr
    by ckthomaston@gmail.com
    
    Usage:
    
        $response = new HTTPRequest('http://www.example.com'); 
        echo $response->DownloadToString();
        
        where $response is the body of the page returned by the URL request.

    Developer's notes:
    
    The source code in this file is re-used from a posting made to the php.net
    web site, by "info at b1g dot de".  This is his description of the class
    code:
    
        "A simple class to fetch a HTTP URL. Supports "Location:"-redirections.
         Useful for servers with allow_url_fopen=false. Works with
         SSL-secured hosts."

    Copious thanks to "info at b1g dot de".

    The code which "info at b1g dot de" posted is 8 years old, so minor changes
    in declarations were made to update it to modern PHP standards.

    For more information about re-using the source code in this product, see
    the other included .php files.  Also, refer to the "ip-addr-to-arin-cidr
    Project UML Class Diagram".
    
    License:

    The license under which this software product is released is GPLv2.  
    
    Disclaimer:
    
    Some of the source code used in this product may have been re-used from
    other sources.
    
    None of the source code in this product, original or derived, has been
    surveyed for vulnerabilities to potential security risks.
    
    Use at your own risk, author is not liable for damages, product is not
    warranted to be useful for anything, copyrights held by their respective
    owners.
*/

class HTTPRequest 
{ 
    private $_fp;        // HTTP socket 
    private $_url;        // full URL 
    private $_host;        // HTTP host 
    private $_protocol;    // protocol (HTTP/HTTPS) 
    private $_uri;        // request URI 
    private $_port;        // port 
    
    // scan url 
    private function _scan_url() 
    { 
        $req = $this->_url; 
        
        $pos = strpos($req, '://'); 
        $this->_protocol = strtolower(substr($req, 0, $pos)); 
        
        $req = substr($req, $pos+3); 
        $pos = strpos($req, '/'); 
        if($pos === false) 
            $pos = strlen($req); 
        $host = substr($req, 0, $pos); 
        
        if(strpos($host, ':') !== false) 
        { 
            list($this->_host, $this->_port) = explode(':', $host); 
        } 
        else 
        { 
            $this->_host = $host; 
            $this->_port = ($this->_protocol == 'https') ? 443 : 80; 
        } 
        
        $this->_uri = substr($req, $pos); 
        if($this->_uri == '') 
            $this->_uri = '/'; 
    } 
    
    // constructor 
    public function HTTPRequest($url) 
    { 
        $this->_url = $url; 
        $this->_scan_url(); 
    } 
    
    // download URL to string 
    public function DownloadToString() 
    { 
        $crlf = "\r\n"; 
        
        // generate request 
        $req = 'GET ' . $this->_uri . ' HTTP/1.0' . $crlf 
            .    'Host: ' . $this->_host . $crlf 
            .    $crlf; 
        
        // fetch 
        $this->_fp = fsockopen(($this->_protocol == 'https' ? 'ssl://' : '') . $this->_host, $this->_port); 
        fwrite($this->_fp, $req);
        $response = "";
        while(is_resource($this->_fp) && $this->_fp && !feof($this->_fp)) 
            $response .= fread($this->_fp, 1024); 
        fclose($this->_fp); 
        
        // split header and body 
        $pos = strpos($response, $crlf . $crlf); 
        if($pos === false) 
            return($response); 
        $header = substr($response, 0, $pos); 
        $body = substr($response, $pos + 2 * strlen($crlf));
        
        // parse headers 
        $headers = array(); 
        $lines = explode($crlf, $header); 
        foreach($lines as $line) 
            if(($pos = strpos($line, ':')) !== false) 
                $headers[strtolower(trim(substr($line, 0, $pos)))] = trim(substr($line, $pos+1)); 
        
        // redirection? 
        if(isset($headers['location'])) 
        { 
            $http = new HTTPRequest($headers['location']); 
            return($http->DownloadToString($http)); 
        } 
        else 
        { 
            return($body); 
        } 
    } 
} 
?>