<?php

    error_reporting(E_ALL);  // E_ALL | E_STRICT
    
    require('../include/funcs.php');
    require('../include/blogClasses.php');
    
    $ssl_required = false;
    $armenu_r = null;
    
    #print_r($_SERVER);
    #exit('<br>'.$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
    
    
    // check config for security settings
    $ssl_required = true;        // assume required
    
   /*
    *   if no get data  get newest file name and redirect
    ********************************************************/
    $armenu_r = archive_menu();
    if(!isset($_GET['text']) && $armenu_r){
        header("location: https://" . $_SERVER['SERVER_NAME'] . '/?text=' .
                                                          $armenu_r[0]['file']); 
    }
    
    // if ssl required check and set as needed
    if($ssl_required)
        if(!isset($_SERVER['HTTPS']))
            header("location: https://" . $_SERVER['SERVER_NAME'] .
                                                      $_SERVER['REQUEST_URI']);
            
    
    
    // set a null value
    $display_text = null;
    
    // build the current url for header meta data 
    $dis_url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    
    if(isset($_GET['text']))
    {
        $display_text = date('Y-m-d\THi', strtotime($_GET['text'])) . '.txt';
    }
    
    #print_r($_SERVER);
    $blogpage = true;

    include('fet.php');

?>
