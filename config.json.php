<?php
include( 'config.php' );

$all_consts = get_defined_constants(true);

header('Content-type: application/json; charset=utf-8');
echo json_encode( $all_consts['user'], JSON_PRETTY_PRINT );
