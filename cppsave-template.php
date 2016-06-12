<?php


include_once "./lib/libatm.php";

session_start();

$coll = new ATM_Collection( $_SESSION["ATM_COLLECTION"] );
$sm = $coll->first();

header( "Content-Type: application/octet-stream" );
header('Content-Disposition: attachment; filename="'.$sm->name(). '.cpp"');

if ( $sm->hash() !== $_SESSION['HASH'] ) { 
  file_put_contents( "machines/". session_id(). "/new.atml", $sm->as_xml() );
  $r = shell_exec( "./update.sh machines ". session_id() );
  $_SESSION['HASH'] = $sm->hash(); 
}

$txt = file_get_contents( "machines/". session_id(). "/Template.cpp" );
if ( $_SESSION['HPPMODE'] ) {
  $txt = preg_replace( '/\bAtm_\w+\.h\b/i', $sm->name(). ".hpp", $txt );
}
echo preg_replace( '/\n/s', "\r\n", $txt );

?>

