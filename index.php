<?php
/*
    Filename: index.php
    Rev 2014.0914.0730
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
        insert the HTTP directives displayed into an .htaccess file.
    
    Files:
    
        A complete set of files for this distribution contains all of the
        following:
        
        - readme.txt
        - index.php - launches the ip-addr-to-arin-cidr.php web page
        - ip-addr-to-arin-cidr.php - page which prompts and executes query
        - cidr-data-set.php - class required by ip-addr-to-arin-cidr.php
        - http-request.php - class required by ip-addr-to-arin-cidr.php
        - ipaddr-to-cidr-worker.php - class required by ip-addr-to-arin-cidr.php
        - ipaddress-validator.php - class required by ip-addr-to-arin-cidr.php
        - output-worker.php - class required by ip-addr-to-arin-cidr.php
        - itac-class-diagram.png - docmentation for developers
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
        Project UML Class Diagram" file, itac-class-diagram.png.
    
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

include "ip-addr-to-arin-cidr.php";

?>
