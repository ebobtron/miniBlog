<?php

// set local time zone
date_default_timezone_set('America/Chicago'); //UTC

/*
 *    get the last five blog post for right panel selection list
 *******************************************************************/   
function archive_menu()
{
    $files = array_reverse(glob('../include/body/*.txt'));
    
    $list_r = NULL;
    $i = 0;
    foreach($files as $file){
        $list_r[] = array(
                        "file" => date('Y-m-d\THi', strtotime(basename($file, '.txt'))),
                        "display" => date('d M Y', strtotime(basename($file, '.txt')))
                         );
        $i++;
        if($i == 5)
            break;
    } 
    
    return $list_r;
}

/*
 *    get list of blog files to display content of blog
 **********************************************************/
function getBlogFilesData(){
    
    $files = glob('../include/body/*.txt');
    $list_r = NULL;
    
    foreach($files as $file){
        
        $handle = fopen($file, 'r');
        $list_r[] = array( "file" => date('Y-m-d\THi', strtotime(basename($file, '.txt'))),
                           "display" => date('d M Y', strtotime(basename($file, '.txt'))),
                           "title" => fgetss($handle),
                           "dummy" => fgetss($handle),
                           "clip" => fgetss($handle, 256) . '...'
                         );
        
        if($handle)
            fclose($handle);
    }
    
    return $list_r;
}

/*
 *    get selection list of short files for editor 
 *****************************************************/
function getShortSubjectFileList(){
    
    $shortFilesList = glob('../include/short_text/*.txt');
    $list_r = NULL;
    
    foreach($shortFilesList as $file){
        
        $handle = fopen($file, 'r');
        $body = fread($handle, filesize($file));
        $list_r[] = array( "file" => $file,
                           "display" => 'short #: ' . basename($file, '.txt'),
                           "body" => $body . '...'
                         );
        if($handle)
            fclose($handle);
    }
    
    return $list_r;
}

/*
 *    get selection list of draft files for editor 
 ********************************************************/
function getDraftSubjectFileList(){
    
    $draftFilesList = glob('../include/draft/*.txt');
    $list_r = NULL;
    
    foreach($draftFilesList as $file){
        
        $handle = fopen($file, 'r');
        $body = fread($handle, filesize($file));
        $list_r[] = array( "file" => $file,
                           "display" => 'draft #: ' . basename($file, '.txt'),
                           "body" => $body . '...'
                         );
        if($handle)
            fclose($handle);
    }
    
    return $list_r;
} 
?>
