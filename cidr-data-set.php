<?php
/*
    Filename: cidr-data-set.php
    Rev 2014.0930.0030
    Project: ip-addr-to-arin-cidr
    Copyright (C) Rex Addiscentis - raddiscentis@addiscent.com
    
    Description:
    
        The CIDRdataSet class is a data aggregation object.  It stores parsed
        ARIN Whois-RWS network-related information, all of which is stored as
        received from the IPaddrToCIDRworker class, with one exception; the
        "add_cidr()" method constructs a proper CIDR spec using the passed-in
        values, e.g., 127.0.0.1 and 8 are concatenated to produce 127.0.0.1/8.
        "add_cidr()" also maps the cidr length value to its network range size,
        e.g., 8=>16M.
        
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

class CIDRdataSet
{
    // allow look up of net block size from cidrLength
    private $netblock_size_map = array
                            (
                            "32" => "1",
                            "31" => "2",
                            "30" => "4",
                            "29" => "8",
                            "28" => "16",
                            "27" => "32",
                            "26" => "64",
                            "25" => "128",
                            "24" => "256",
                            "23" => "512",
                            "22" => "1K",
                            "21" => "2K",
                            "20" => "4K",
                            "19" => "8K",
                            "18" => "16K",
                            "17" => "32K",
                            "16" => "64K",
                            "15" => "128K",
                            "14" => "256K",
                            "13" => "512K",
                            "12" => "1M",
                            "11" => "2M",
                            "10" => "4M",
                            "9" => "8M",
                            "8" => "16M",
                            "7" => "32M",
                            "6" => "64M",
                            "5" => "128M",
                            "4" => "256M",
                            "3" => "512M",
                            "2" => "1B",
                            "1" => "2B"
                            );

    private $ipaddr_validated = NULL; // validated IP address entered by user
    private $cidr_date_time = NULL; // date and time data was fetched from ARIN
    
    private $CIDRnbsize =   array
                            (
                                "CIDR_SPEC" => "",
                                "NETBLOCK_SIZE" => ""
                            );
    private $CIDRnbsize_list = array ();
    
    private $company_name = NULL;
    private $company_handle = NULL;
    private $customer_name = NULL;
    private $customer_handle = NULL;

    public function set_ipaddr ($ipaddr_validated = NULL) {
        $this->ipaddr_validated = $ipaddr_validated;
    }
    
    // 
    public function set_cidr_date_time ($cidr_date_time = NULL) {
        $this->cidr_date_time = $cidr_date_time;
    }
    
    // build a $cidr_spec and netblock size pair and add them to the list
    public function add_cidr ($address_range_start = NULL, $cidr_length = NULL) {
        
        $cidr_spec = $address_range_start . '/' . $cidr_length;
        
        $this->CIDRnbsize["CIDR_SPEC"] = $cidr_spec;
        
        $nbsize = $this->netblock_size_map[$cidr_length];
        
        $this->CIDRnbsize["NETBLOCK_SIZE"] = $nbsize;
        
        array_push($this->CIDRnbsize_list, $this->CIDRnbsize);
    }
    
    // 
    public function set_company_info ($in_company_name = NULL, $in_company_handle = NULL) {
        
        $this->company_name = $in_company_name;
        
        $this->company_handle = $in_company_handle;
    }
    
    // 
    public function set_customer_info ($in_customer_name = NULL, $in_customer_handle = NULL) {
        
        $this->customer_name = $in_customer_name;
        
        $this->customer_handle = $in_customer_handle;
    }
    
    // 
    public function get_ipaddr () {
       return $this->ipaddr_validated;
    }
    
    // 
    public function get_cidr_date_time () {
        return $this->cidr_date_time;
    }
    
    // 
    public function get_cidr_spec_nbsize () {
        return $this->CIDRnbsize_list;
    }
    
    // 
    public function get_company_info (&$out_company_name, &$out_company_handle) {
        
        $out_company_name = $this->company_name;
        
        $out_company_handle = $this->company_handle;
    }
    
    // 
    public function get_customer_info (&$out_customer_name, &$out_customer_handle) {
        
        $out_customer_name = $this->customer_name;
        
        $out_customer_handle = $this->customer_handle;
    }
}
?>
