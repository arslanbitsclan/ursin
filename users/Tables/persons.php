<?php

defined('BASEPATH') or exit('No direct script access allowed');




$this->ci->db->query("SET sql_mode = ''");

$aColumns = [
    
    'id',
    'email',
    'firstname',
    'lastname',
    'facebook',
    'phonenumber',
    'password',
   
   
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'persons';
$where        = [];
// Add blank where all filter can be stored
$filter = [];

$join = [];


$aColumns = hooks()->apply_filters('customers_table_sql_columns', $aColumns);
$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    // Bulk actions
    $row[] = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
    // User id
    $row[] = $aRow['id'];
    $company  = $aRow['email'];
    $url = admin_url('clients/client/' . $aRow['id']);
    $company = '<a href="' . $url . '">' . $company . '</a>';
    $company .= '<div class="row-options">';
    $company .= '<a href="' . admin_url('Users/editPerson/' . $aRow['id'] . '">' . _l('Edit') . '</a>';
    $company .= ' | <a href="' . admin_url('Users/deleteperson/' . $aRow['id']) . '" class="text-danger delete">' . l('delete') . '</a>';
    $company .= '</div>';
    $row[] = $company.'aaa';

    $row[] = $aRow['firstname'];
    $row[] = $aRow['lastname'];
    $row[] = $aRow['facebook'];
    $row[] = $aRow['phonenumber'];
    $row[] = $aRow['password'];
    

    
    $output['aaData'][] = $row;
}



