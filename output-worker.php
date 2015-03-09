<?php
/*
    Filename: output-worker.php
    Rev 2015.0309.0110
    Project: ip-addr-to-arin-cidr
    Copyright (C) Charles Thomaston - ckthomaston@dalorweb.com
    
    Description:
    
        The OutputWorker class is responsible for output to the web page.  It
        provides a prompt and input form, and displays the results of the data
        recieved from the ARIN Whois-RWS API, via the CIDRdataSet class.  It
        also annunciates error messages.
        
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

class OutputWorker
{
    private function set_snippet ($snippet_string) {
        
        echo '<span style="font-family:courier new,courier,monospace"><strong><span style="color:#002222"><span style="background-color:#FFFF66">'
            .       $snippet_string
            . '</span></span></strong></span>';
    }            
    
    public function set_error_msg ($err_msg, $local_home_page) {
        
        $this->display_instructions_form ($local_home_page);
        
        echo '<span style="font-family:courier new,courier,monospace"><strong><span style="color:#002222"><span style="background-color:#FF8822">'
            .       $err_msg
            . '</span></span></strong></span>';
    }            
    
    // display instructions and IP address input form
    private function display_instructions_form ($local_home_page) {
        
        echo '<h1>'
        .       "Deny From IP"
        .   "</h1>"
        .   '<h5>'
        .       "Project: ip-addr-to-arin-cidr, rev 2015.0309.0110"
        .   "</h5>"
        .   '<p>'
        .       "This is a simple web host administrator's tool. It's only function is to provide
                information. It was developed to assist a web host administrator with the job
                of blacklisting unauthorized users.  One way of disallowing use by
                unauthorized users is by blacklisting via the web host's
                .htaccess file."
        .   "</p>"
        .   '<p>'
        .       "This tool neither writes nor modifies files on the client side,
                nor on the server side. If you wish to use the code
                snippet displayed below to modify your .htaccess file, you may copy-and-paste it
                into your .htaccess file manually.  Note that only the snippet highlighted
                 in yellow is .htaccess file safe."
        .   "</p>"
        .   '<p>'
        .   "<small>"
        .       '<span style="background-color:#FF0000">&nbsp;'
        .           '<span style="color:#FFFFFF">'
        .            "Warning:&nbsp;"
        .           "</span>"
        .       "</span>&nbsp;"
        .       "<strong>"
        .           "Do not edit your .htaccess file unless you are well advised of the risks."
        .       "</strong>"
        .   "</small>"
        .   '<div style="background: #f0f0ff; border: 1px solid #ccc; padding: 5px 10px; width: 50%;">'
        .       '<p style="text-align: left;">'
        .           "<small>"
        .                'View, download, or fork the "Deny From IP" PHP source code on GitHub at: <br>'
        .                    '<a href="https://github.com/ckthomaston/ip-addr-to-arin-cidr">'
        .                    "https://github.com/ckthomaston/ip-addr-to-arin-cidr</a>"
        .           "</small>"
        .       "</p>"
        .   "</div>"
        .       "<h2>"
        .           "User Instructions"
        .       "</h2>"
        .       '<p>'
        .           "Submit an IP address, e.g., 127.0.0.1, in the edit box below.
                    A network CIDR will be displayed, placed in a code snippet
                    format suitable for copy-and-paste into an .htaccess file."
        .       "</p>"
        .   '<form action='
		.		$local_home_page
		.		' method="post">'
        .   '<p>'
        .       'IP Address: <input type="text" name="ipaddr"> <input type="submit">'
        .   "</p>"
        .   "</form>";
    }
    
    // display CIDR data set
    public function set_cidr_data ($CIDRdataSet = NULL, $local_home_page) {
        
        $this->display_instructions_form ($local_home_page);
        
        if ($CIDRdataSet == NULL) {
            return;
        }
        
        // list company name
        $org_name = NULL;
        $org_handle = NULL;
        
        $CIDRdataSet->get_company_info ($org_name, $org_handle);
        
        if ($org_name != "") {
            echo "<p>"
                .   "Organization name: "
                .   $org_name
                .   "<br/>"
                .   "Organization handle: "
                .   $org_handle
               . "</p>";
        }
        
        // list customer name
        $customer_name = NULL;
        $customer_handle = NULL;
        
        $CIDRdataSet->get_customer_info ($customer_name, $customer_handle);
        
        if ($customer_name != "") {
            echo "<p>"
                .   "Customer name: " 
                .   $customer_name
                .   "<br/>"
                .   "Customer handle: "
                .   $customer_handle
                . "</p>";
        }
        echo "<p>
                <em>
                    <small>
                        Note the date and time is GMT/UTC, it is not adjusted for your time zone.</small>
                    </small>
                </em>
             </p>";
             
        // construct a courtesy "deny from" code snippet block for user to
        // manually copy/paste into .htaccess file.
        $date_time = $CIDRdataSet->get_cidr_date_time();
        
        $this->set_snippet ("# Date and time of this entry: $date_time");
        echo "<br/>";
        
        $ip_addr = $CIDRdataSet->get_ipaddr ();
        
        $this->set_snippet ("# deny from $ip_addr");
        echo "<br/>";
    
        $cidr_netblocks = $CIDRdataSet->get_cidr_spec_nbsize();
        
        foreach ($cidr_netblocks as $net_tuple) {
            
            $cidr_spec = $net_tuple["CIDR_SPEC"];
            $this->set_snippet ("# " . $cidr_spec . " netblock size: " . $net_tuple["NETBLOCK_SIZE"]);
            echo "<br/>";
        }
        
        foreach ($cidr_netblocks as $net_tuple) {
            
            // construct a CDIR IP block spec by using the starting address and the cidrlength.
            $cidr_spec = $net_tuple["CIDR_SPEC"];
            $this->set_snippet ("deny from " . $cidr_spec);
            echo "<br/>";
        }
        
    }
}
?>