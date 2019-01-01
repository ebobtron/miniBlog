<?php 
    
    // initialize variables
    $titleString = 'Dark Blog';
    $textString = null;
    $short_files = null;
    $short_display_index = null;
    $short = null;
    $today = date('y-m-d  H');
    
    // get random shorts data
    if(file_exists( '../include/short_text/*.txt')){
        $short_files = glob( '../include/short_text/*.txt');
        $file_count = count($short_files);
        $short_display_index = rand(0, $file_count - 1);
        $short_handle = fopen($short_files[$short_display_index], 'r');
        $short = fread($short_handle, filesize($short_files[$short_display_index]));
    }
    
    
    $display_date = null;
    
    // not working: more shorts thing
    if(filesize($short_files[$short_display_index]) > 500){
        $sf = basename($short_files[$short_display_index], '.txt');
    }
    else
        $sf = null;
    
    
    // get and create file string: selected or latest blog post file name
    if($display_text){
        $file = '../include/body/' . $display_text;
    }
    else{
        $body_files = glob('../include/body/*.txt');
        $body_count = count($body_files);
        $file = $body_files[$body_count - 1];
    }
    
    // get body text if file exits
    if(file_exists($file)){
        $body_handle = fopen($file, 'r');
        $body = fread($body_handle, filesize($file));
        rewind($body_handle);
        $titleString = fgets($body_handle);
        
        if($body_handle)
            fclose($body_handle); 
        
        $display_date = date('d M Y', strtotime(basename($file, '.txt')));
    }
    else
        $body = 'Sorry, document not found';
    
    // remove html format tags
    $titleString = strip_tags($titleString);
    $textString = strip_tags($textString);
    
    // get filenames for last five posts menu
    $armenu_r = archive_menu();
    
    // get list for popup post selector page
    $content_list = getBlogFilesData();
    
    // get comments for selected or latest blog post
    require('../include/jsonfunctions.php');
    
    // build comment file name
    $comment_file = '../include/comments/'.basename($file,'txt').'json';
    
    // get comments and replies if there are any
    if(file_exists($comment_file)){
        $comment_obj = new blog_Comment($comment_file);
        $comments = $comment_obj->getValidComments();
        $replies = $comment_obj->getValidReplies();
    }
    
    #print_r($armenu_r);    exit('end fet.php line 56');

    // ****  RENDER PAGE  ****
    include('../template/header.php');   
    
    include('../template/main.php');
    
    if($_POST)
        echo print_r($_POST, true);
    
    include('../template/footer.php');
  
 ?>
  