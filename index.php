<?php
/*
    Filename: index.php
    Rev 2014.0829.2100
    Product: ip-addr-to-arin-cidr
    by ckthomaston@gmail.com
    
    Description:
    
    This file and other files included with this distribution produce a web
    page which displays instructions and a form.  The form allows a user to
    enter an IP address.  After a user submits an IP address, information is
    displayed containing network CIDR information related to that IP address.
    
    The information is displayed in a format which conveniently allows copy-and-
    paste into an .htaccess file by a web site administrator.  The given
    directives "blacklist" the range of IP addresses within which the user-
    submitted IP address is contained.
    
    This software does not write or modify files, the admin must manually
    insert the HTTP directives displayed into an .htaccess file.
    
    Developer's notes:
    
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

include "ip-addr-to-arin-cidr.php";

?>
