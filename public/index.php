<?php

    error_reporting(E_ALL);  // E_ALL | E_STRICT
    
    include('../include/funcs.php');
    
   /*
    *   if no get data  get newest file name and redirect
    ********************************************************/
    if(!isset($_GET['text'])){
        $armenu_r = archive_menu();
        header("location: /?text=".$armenu_r[0]['file']); 
    }
    
    // set a null value
    $display_text = null;
    
    // build the current url for header meta data 
    $dis_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    
    if(isset($_GET['text']))
    {
        $display_text = date('Y-m-d\THi', strtotime($_GET['text'])) . '.txt';
    }
    
    #print_r($_SERVER);

    include('fet.php');

?>
