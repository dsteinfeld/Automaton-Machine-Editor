<?php

include_once "../lib/libatm.php";

session_start();

$coll = new ATM_Collection( $_SESSION["ATM_COLLECTION"] );

$sm = $coll->first();

$sm->link( $_GET['state'], $_GET['event'], $_GET['new'] );

$_SESSION["ATM_COLLECTION"] = $coll->as_xml();


