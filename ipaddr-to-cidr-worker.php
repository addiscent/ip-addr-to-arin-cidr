<?php
/*
    Filename: ipaddr-to-cidr-worker.php
    Rev 2014.0914.0730
    Project: ip-addr-to-arin-cidr
    Copyright (C) Charles Thomaston - ckthomaston@dalorweb.com
    
    Description:
    
        The IPaddrToCIDRworker class is responsible for requesting data from
        the ARIN Whois-RWS API, for a specific IP address.  The data is fetched
        via the HTTPRequest class.  The data received is an XML object.  The
        IPaddrToCIDRworker parses the desired information from the XML object,
        and stores it in the CIDRdataSet class.  
        
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

// status returned by class IPaddrToCIDRworker
define ("STATUS_SUCCESS", TRUE);
define ("STATUS_FAIL", FALSE); 

class IPaddrToCIDRworker
{

    // Remove undesired chars from the beginning of $in_string.
    //      $in_string:  string to remove chars from, (left end)
    //      $strstr_arg: remove all chars from left of $in_string, up to,
    //      but not including, $strstr_arg.  Note:  strstr() leaves $strstr_arg
    //      match not removed, must use ltrim() to remove it
    private function ltrim_to_data ($in_string, $strstr_arg) {
        
        $str_remain = strstr($in_string, $strstr_arg);
        $str_remain = ltrim($str_remain, $strstr_arg);
        
        return $str_remain;
    }
    
    // 
    public function get_cidr_data_result ($ipaddr_validated = NULL, &$CIDRdataSet = NULL) {
    
        // query ARIN for net block data of specified IP address
        $result = new HTTPRequest ('http://whois.arin.net/rest/ip/' . $_POST["ipaddr"]); 
        $body_string =  $result->DownloadToString(); 
    
        //  search for cidrLength first because it is encountered before associated startAddress
        //  find cidrLength by discarding string segment up to and including "cidrLength>"
        $string_remainder = $this->ltrim_to_data ($body_string, "cidrLength>");
    
        // save the cidrlength ---------------------------------------
        $cidr_length = strstr($string_remainder, "<", TRUE);
        
        // There must be at least one CIDR to build. Bug out if $cidr_length is invalid
        if (($cidr_length == "") || ($cidr_length > "32") || ($cidr_length < "1"))
            return STATUS_FAIL;

        //  find block start IP address by discarding string
        //  segment up to and including "startAddress>"
        $string_remainder = $this->ltrim_to_data ($string_remainder, "startAddress>");
    
        // save the block start IP address ---------------------------
        $address_range_start = strstr($string_remainder, "<", TRUE);
    
        // bug out if IP startAddress not found
        if ($address_range_start == "")
            return STATUS_FAIL;

        // stash sthe startAddress and cidrLength we've found thus far
        $CIDRdataSet->add_cidr ($address_range_start, $cidr_length);

        $CIDRdataSet->set_ipaddr ($ipaddr_validated);
        $CIDRdataSet->set_cidr_date_time (date('M d, Y  H:i') . " GMT");

        // there may be more than one net block. Keep searching until no more are found
        $netblock_found = TRUE;
        do {
            //  find CIDRlength by discarding string segment up to and including "cidrLength>"
            $string_remainder = $this->ltrim_to_data ($string_remainder, "cidrLength>");
    
            // save the cidrlength ---------------------------------------
            $cidr_length = strstr($string_remainder, "<", TRUE);
            
            // exit loop if no more valid cidrLengths found
            if (($cidr_length == "") || ($cidr_length > "32") || ($cidr_length < "1"))
                break;
    
            //  find block start IP address by discarding string
            //  segment up to and including "startAddress>"
            $string_remainder = $this->ltrim_to_data ($string_remainder, "startAddress>");
    
            // save the range start IP address ---------------------------
            $address_range_start = strstr($string_remainder, "<", TRUE);
    
            // exit loop if no more valid data found
            if ($address_range_start == "")
                break;
    
            $CIDRdataSet->add_cidr ($address_range_start, $cidr_length);
            
        } while ($netblock_found == TRUE);
    
        //  find organization name by discarding string segment up to
        //  and including 'orgRef name="'
        $string_remainder = $this->ltrim_to_data ($body_string, 'orgRef name="');
    
        // save 'orgRef name"' if it was found
        if ($string_remainder != "") { // orgRef name=" found
        
            // save the organization name -----------------------------
            $company_name = strstr($string_remainder, '"', TRUE);
            
            //  find organization handle by discarding string
            //  segment up to and including 'handle="'
            $string_remainder = $this->ltrim_to_data ($string_remainder, 'handle="');
    
            // save the organization handle ----------------------------
            $company_handle = strstr($string_remainder, '"', TRUE);
            
            $CIDRdataSet->set_company_info ($company_name, $company_handle);
        }
    
        //  find customer name by discarding string
        //  segment up to and including 'customerRef name="'
        $string_remainder = $this->ltrim_to_data ($body_string, 'customerRef name="');
    
        // save 'customerRef name"' if it was found
        if ($string_remainder != "") { // customerRef name=" found
            // save the customer name --------------------------------
            $customer_name = strstr($string_remainder, '"', TRUE);
    
            //  find customer handle by discarding string
            //  segment up to and including 'handle="'
            $string_remainder = $this->ltrim_to_data ($string_remainder, 'handle="');
    
            // save the customer handle ------------------------------
            $customer_handle = strstr($string_remainder, '"', TRUE);
            
            $CIDRdataSet->set_customer_info ($customer_name, $customer_handle);
        }
        
        return STATUS_SUCCESS;
    }
}
?>