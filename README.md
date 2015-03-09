ip-addr-to-arin-cidr
====================

A web page which accepts an IP address from the user and uses ARIN Whois-RWS API to look up network range and owner.

Better known by the familiar name "Deny From IP".

"Deny From IP" is a web page which displays instructions and accepts an IP address entered by a user.  The web page uses the submitted IP address during a query to the ARIN Whois-RWS API.  The query looks up the network range of IP addresses which contains the IP address submitted by the user.  The associated CIDR and its owner is displayed to the user, along with other information and terms.

This is a simple tool for web host administrators.  It assists during the admin's task of blocking access to a web host, if the admin wishes to do so by blacklisting IP addresses by using the .htaccess file.  A CIDR is a specification for a range of addresses.  The admin may choose to block a range instead of a single IP address for a variety of reasons.  The information returned to the user is displayed in a format which can easily be copy-and-pasted into an .htaccess file by an admin.

Visit the latest stable working "Deny From IP" web page example at http://ip-addr-to-arin-cidr.dalorweb.com.

Copyright (C) Charles Thomaston - ckthomaston@dalorweb.com
