/*
    Filename: readme.txt
    Rev 2014.0930.0030
    Project: ip-addr-to-arin-cidr  
    Copyright (C) Charles Thomaston - raddiscentis@addiscent.com
    
    Important: Apache Web Server Version Compatibility Note

        This program is _not_ compatible with _Apache Web Server v2.4_ and
        later.  "Ip-addr-to-arin-cidr" uses the "deny from" _.htaccess_ file
        directive to block service to IP addresses.  However, the "deny from"
        (etc) directive set has been deprecated in _Apache v2.4_; the "deny
        from" directive has been replaced by a different IP allow/block
        directive set, ("Require all granted... Require not ip X.X.X.X, etc").
        Therefore, "ip-addr-to-arin-cidr", is _only_ useful in older versions
        of _Apache Web Server_ which correctly support the "deny from"
        directive.  Please see the _Apache_ documentation for additional
        information.
  
        This project remains online for those who must use older versions of
        _Apache_ which are compatible, though operating an obsolete version of
        _Apache_ is not recommended.

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
        - output-worker.php - class required by ip-addr-to-arin-cidr.php
        - itac-class-diagram.gif - docmentation for developers
        - README.md - project description on GitHub.com
        - LICENSE - A license file describing terms of use
    
    Installation Instructions:
    
        IMPORTANT NOTE: the "ip-addr-to-arin-cidr.php" file contains
        essential information required to fully complete installation.
        Constants in that file must be adjusted to your web site directory
        hierarchy, or the PHP runtime will generate errors on the tool's
        web page when executing. For more information, read the comments at
        the beginning of the code in the "ip-addr-to-arin-cidr.php" file.
    
        The gist of the installation process is as follows.  Place the six
        included .php project files in a web server directory, e.g.,
        "http://example.com/ip-addr-to-arin-cidr/", which is accessible
        on the web and has Internet access.  After adjusting the file hierarchy
        definitions as described in "ip-addr-to-arin-cidr.php", load
        "index.php" from the tool's web page directory, into a web browser.
        After you have confirmed a working website page installation, use the
        tool by following the instructions given on the tool's web page.
        
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
