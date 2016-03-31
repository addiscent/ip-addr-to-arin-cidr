#### Important: Apache Web Server Version Compatibility Note

  This program is _not_ compatible with _Apache Web Server v2.4_ and later.  "Ip-addr-to-arin-cidr" uses the "deny from" _.htaccess_ file directive to block service to IP addresses.  However, the "deny from" (etc) directive set has been deprecated in _Apache v2.4_; the "deny from" directive has been replaced by a different IP allow/block directive set, ("Require all granted... Require not ip X.X.X.X, etc").  Therefore, "ip-addr-to-arin-cidr", is _only_ useful in older versions of _Apache Web Server_ which correctly support the "deny from" directive.  Please see the _Apache_ documentation for additional information.
  
  This project remains online for those who must use older versions of _Apache_ which are compatible, though operating an obsolete version of _Apache_ is not recommended.

# ip-addr-to-arin-cidr

This is a PHP/HTML web page which accepts an IP address from the user and uses ARIN Whois-RWS API to look up network range and owner.

This project is also knows by the name "Deny From IP".

"Deny From IP" is a web page which displays instructions and accepts an IP address entered by a user.  The web page uses the submitted IP address during a query to the ARIN Whois-RWS API.  The query looks up the network range of IP addresses which contains the IP address submitted by the user.  The associated CIDR and its owner is displayed to the user, along with other information and terms.

This is a simple tool for web host administrators.  It assists during the admin's task of blocking access to a web host, if the admin wishes to do so by blacklisting IP addresses by using the .htaccess file.  A CIDR is a specification for a range of addresses.  The admin may choose to block a range instead of a single IP address for a variety of reasons.  The information returned to the user is displayed in a format which can easily be copy-and-pasted into an .htaccess file by an admin.

Visit the latest stable working "Deny From IP" web page example at http://ip-addr-to-arin-cidr.addiscent.com.

Copyright (C) Charles Thomaston - raddiscentis@addiscent.com
