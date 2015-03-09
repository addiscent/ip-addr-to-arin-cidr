<?php
/*
    Filename: ip-addr-to-arin-cidr.php
    Rev 2015.0309.0110
    Project: ip-addr-to-arin-cidr  
    Copyright (C) Charles Thomaston - ckthomaston@dalorweb.com
    
    Description:
    
        This file and other files included with this distribution produce a web
        page which displays instructions and a form.  The form allows a user to
        enter an IP address.  After a user submits an IP address, information
        is displayed containing network CIDR information related to that
        IP address.
        
        The information is displayed in a format which conveniently allows
        copy-and-paste into a .htaccess file by a web site administrator.
        The information is displayed in the form of a snippet including
        directives, ("deny from NNN.NNN.NNN.NNN"), which will "blacklist" the
        range of IP addresses containing the user-submitted IP address.
        
        This software does not write or modify files, the admin must manually
        insert the displayed HTTP directives into an .htaccess file.
    
    Files:
    
        A complete set of files for this distribution contains all of the
        following:
        
        - readme.txt
        - index.php - launches the ip-addr-to-arin-cidr.php web page
        - ip-addr-to-arin-cidr.php - page which prompts and executes query
        - cidr-data-set.php - class required by ip-addr-to-arin-cidr.php
        - http-request.php - class required by ip-addr-to-arin-cidr.php
        - ipaddr-to-cidr-worker.php - class required by ip-addr-to-arin-cidr.php
        - output-worker.php - class required by ip-addr-to-arin-cidr.php
        - itac-class-diagram.gif - docmentation for developers
        - README.md - project description on GitHub.com
        - LICENSE - A license file describing terms of use
    
    Installation Instructions:
    
        Place the seven included .php files in a web server directory, e.g.,
        http://example.com/ip-addr-to-arin-cidr/, which is accessible on the
        web and has Internet access.  Load "index.php" from that directory
        into a web browser.  Follow the instructions given on the web page
        which is displayed.
    
    Developer's notes:
    
        For more information about re-using the source code in this product, see
        the other included .php files.  Also, refer to the "ip-addr-to-arin-cidr
        Project UML Class Diagram" file, itac-class-diagram.gif.
    
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

/*  these directory hardcodes below are hackful, but should hopefully give you
    some hints about how to "port" this tool to a variety of web sites.
    Note that you must replace one each of the commented-out TOOL_FILES_DIR and
    TOOL_WEB_PAGE definitions with correct values for your website,
    otherwise, you will not make your time joyful.
*/
 
//  If you are working in a WordPress web site directory hierarchy, this define is
//  most likely the directory where you will want to place the tool's PHP, files.
// define ("TOOL_FILES_DIR", "wp-content/ip-addr-to-arin-cidr/");

//  In a WordPress website directory hierarchy, this define reflects
//  whatever you named the tool's page in the WordPress Dashboard. In that page,
//  you invoke the tool using inline embedded PHP code, i.e., :
//      include "ip-addr-to-arin-cidr.php"; // do not uncomment this one here! :)
//  Beware, WordPress does not natively allow embedded PHP, but it will not warn
//  you.  In order to embed PHP in a WordPress web page, you must first install
//  a plugin, which typically uses short-codes.  "Shortcode Exec PHP" has
//  worked for me, but I have only put it to light use. YMMV...
// define ("TOOL_WEB_PAGE", "http://dwt.dalorweb.com/deny-from-ip");

//  below are example definitions placing the tool in a web doc_root by itself,
//  (if you have just a small number of files, or you like doc_root clutter).
// define ("TOOL_FILES_DIR", "");
// define ("TOOL_WEB_PAGE", "http://ip-addr-to-arin-cidr.dalorweb.com/index.php");

require TOOL_FILES_DIR . "http-request.php";
require TOOL_FILES_DIR . "output-worker.php";
require TOOL_FILES_DIR . "ipaddr-to-cidr-worker.php";
require TOOL_FILES_DIR . "cidr-data-set.php";

// result returned by ip2long() - ipaddr is valid or invalid
define ("IPAV_VALID", TRUE);
define ("IPAV_INVALID", FALSE);

$OutputWorker = new OutputWorker();
$IPaddrToCIDRworker = new IPaddrToCIDRworker();
$CIDRdataSet = new CIDRdataSet();

if (!array_key_exists ('ipaddr', $_POST)) {
    
    $OutputWorker->set_cidr_data (NULL, TOOL_WEB_PAGE); // empty data causes user prompt
    
} else {
    
    $ipaddr_not_validated = $_POST['ipaddr'];
    $result = ip2long($ipaddr_not_validated);
    
    if ($result == IPAV_VALID) {
        
        $ipaddr_validated = $ipaddr_not_validated;
        $result = $IPaddrToCIDRworker->get_cidr_data_result ($ipaddr_validated, $CIDRdataSet);
        
        if ($result == STATUS_SUCCESS) {
            $OutputWorker->set_cidr_data ($CIDRdataSet, TOOL_WEB_PAGE);
            
        } else {
            
            $err_msg = "Unable to retrieve data from ARIN Whois-RWS API.";
            $OutputWorker->set_error_msg ($err_msg, TOOL_WEB_PAGE);
        }
    } else {
        
        $err_msg = "Invalid IP address specified : $ipaddr_not_validated";
        $OutputWorker->set_error_msg ($err_msg, TOOL_WEB_PAGE);
    }
}
?>