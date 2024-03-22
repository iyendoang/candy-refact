<?php
// Load .env file
$env = parse_ini_file('../../../../.env');
var_dump($env['DB_HOST']);
// Assign database configuration values from .env
$sq_hostname = $env['DB_HOST'];
$sq_dbusername = $env['DB_USER'];
$sq_dbpassword = $env['DB_PASS'];
$sq_dbname = $env['DB_NAME'];

defined('BASEPATH') OR exit('No direct script access allowed');
 
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'	=> '',
    'hostname' => $sq_hostname,
    'username' => $sq_dbusername,
    'password' => $sq_dbpassword,
    'database' => $sq_dbname,
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);


$db['serverdb'] = array(
    'dsn'	=> '',
    'hostname' => $sq_hostname,
    'username' => $sq_dbusername,
    'password' => $sq_dbpassword,
    'database' => 'sv3_super_admin',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
