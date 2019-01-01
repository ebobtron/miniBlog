<?php
/*
 *    jsonfunctions.php   
 **********************************/
 
function getContributorId($data){

    /*  index.json contents: index, name, email, valid   */
    
    $idex_id = 0;
    $json_r = null;
    $errorMsg = null;
    $contrib = null;
    $isfound = false;
    $valid = 0; // 0 = false, 1 = true, 3 = banned
    
    // look for the file.  scan json or make new
    if(file_exists('../include/json/index.json'))
        // open and return array
        $json_r = json_decode(file_get_contents('../include/json/index.json'), true);
         
        
    if($json_r)
        foreach($json_r as $contrib){     // scan array for matching email address
            if($data->email === $contrib['email']){
                $isfound = true;
                $idex_id = $contrib['index'];
                break;
            }    
            $idex_id++;
            if($idex_id != $contrib['index'])       // sanity test
                $errorMsg = "Fatal error: index.json file's index corupted, script ended";
        }
        
    if($contrib['valid'] == 3)                   // contributor banned from blog
        $errorMsg = 'Contributor '. $contrib['email']. ' is banned from this blog';
    if($errorMsg)                           // on error return to calling script
        return $errorMsg;

    if($isfound)            // if found return data
        return array('index' => $idex_id, 'valid_user'=>$contrib['valid'],
                     'name' => $contrib['name'], 'comment'=>$data->comment,
                     'assoc_file' =>$data->assoc_file );         
    
    // if not found add new commenter to index file
    $idex_id++;
    $Obja = new stdClass;
    $Obja->index = $idex_id;
    $Obja->name = $data->name;
    $Obja->email = $data->email;
    $Obja->valid = $valid;
    
    $json_r[]= (array)$Obja;
    file_put_contents('../include/json/index.json', json_encode($json_r));
    
    unset($Obja->email);
    $Obja->comment = $data->comment;
    $Obja->newcommenter = null;
    $Obja->assoc_file = $data->assoc_file;
    return (array)$Obja;
}

/*
 *    compare and return notice or not commenter: name/email mismatch
 **********************************************************/
function compareNames($submission, $lookedup){
    
    if(!strcasecmp($submission['name'], $lookedup['name']))
        return 0;
    
    return 'Commenter name mismatch for '. $submission['email'].'.'.
           'The name first given with this email address will be used.  '.
           'To change the name associated with the above email please '.
           'contact the blog administrator using the email in question.';  
}

/*
 *    get valid status by commenter id
 *****************************************/
function getValidFromID($id){
    
    $json_r = json_decode(file_get_contents('../include/json/index.json'), true);
    
    foreach($json_r as $commenter){
        
        if($commenter['index'] == $id)
            return $commenter['valid'];
    }
    return 0;
}

/*
 *    get comments for blog post
 ***********************************/
function getComments($data){
    // set the defaults
    $validlist_r = null;
    $file = '../include/comments/' . basename($data, '.txt') . '.json';
    
    // if valid file 
    if(file_exists($file)){
        
        $comlist_r = json_decode(file_get_contents($file), true);

        foreach($comlist_r as $comment){
            if(getValidFromID($comment['id']) == 1 ){
                $validlist_r[] = $comment;
            }
        }
        return $validlist_r;         
    }
    else
        return 0;       // no comments file / no comments
}

/*
 *    find or make directory    
 *******************************/
function check_make_path($path){
    return is_dir(pathinfo($path, PATHINFO_DIRNAME)) || 
           mkdir(pathinfo($path, PATHINFO_DIRNAME));
}

/*
 *    add / push comment to comment file
 *******************************************/
function pushCommentToFile($data){

    $jObj = new stdClass;
    $jObj->name = $data['name'];
    $jObj->id = $data['index'];
    $jObj->comment = $data['comment'];
       
    $basefile = basename($data['assoc_file'], '.txt');
    $commentfile = '../include/comments/' . $basefile . '.json';
    check_make_path($commentfile);
    
    if(file_exists($commentfile)){
        $comments_r = json_decode(file_get_contents($commentfile));
        $jObj->idex = count($comments_r->comments);
        $comments_r->comments[] = $jObj;
        file_put_contents($commentfile, json_encode($comments_r));
    }
    else{
        $jObj->idex = 0;
        $comments_r->comments[] = $jObj;
        file_put_contents($commentfile, json_encode($comments_r));
    }
    
    return 0;  // all OK
}

/*
 *    validate commenter email address
 *****************************************/
function sendValidationEmail($submission, $id){

    
    if($id[''] == 0){ 
        
        // encrypt commenter id and send email

        $id_hashed = md5($id['id']);
        echo '<br>id hased: ' . $id_hashed;
        //$data_r->$id = $id_hashed;
    }
    

/*
    $key = "encryptkey1943"; // this can be any key value you want
    
    $id_uncrypted = decrypt_md5($uIDcrypted, $key);
*/

}

function get_indexJson_asObject(){
    return json_decode(file_get_contents('../include/json/index.json'));
}

/*********************  CLASS DEFINITIONS  *********************/
/*
 *    class implimentation of regular helper functions
 *********************************************************/
class json_helper {
    
    var $jObject;   // = new stdClass();
    var $indexfile;

    // json_helper contructor
    function __construct($file = '../include/json/index.json'){
        if(!file_exists($file))
            throw new Exception('Message: json file not found');
        if($file)
		    $this->jObject = json_decode(file_get_contents($file));
        $this->indexfile = $file;
	}
        
    // return json file contents as decoded object
    function get_json_object($file = null){
        if($file)
            return json_decode(file_get_contents($file));
        else
            return $this->jObject;
    }
    
    // get commenter id and add new commenter record
    function get_commenter_id($replyobj){
        foreach($this->jObject as $cmenter){
           if($cmenter->email == $replyobj->email){
               if($cmenter->valid == 3)
                   return 'Error: email address banned from the blog';
               else
                   return $cmenter->index;
           }        
       }
       /*   index.json contents: index, name, email, valid   */
       $replyobj->index = count($this->jObject) +1;
       $replyobj->valid = 0;
       $this->jObject[] = $replyobj;
       file_put_contents($this->indexfile, json_encode($this->jObject));
       return $replyobj->index;
    }
    
    // push object 2 into 1: adds to the end
    function push_to_object($obj1, $obj2){
        
        if(is_object($obj1)){
            $a_obj = new ArrayObject($obj1->jObject);  
            $next = $a_obj->count();
            $a_obj->offsetSet($next, $obj2);
            return $obj1;
        }
    }
    
    // remove record from json file
    function remove_json_record($user_email){
        
        // unset record
        $temp = (array)$this->jObject;
        $i = 0;
        foreach($temp as $record){
            if($record->email == $user_email){
                unset($temp[$i]);
            }
            $i++;
        }
        
        // reindex the array Object
        $i = 0;
        $temp_object;
        foreach($temp as $record){
            $record->index = $i+1;
            $temp_object[] = $record;
            $i++;
        }
        $this->jObject = (object)$temp_object;
    }
    
    function get_Status_by_index($index){
    }
}


class blog_Comment extends json_helper {
    
    var $comment_file;
    var $jCommentObject;
    var $validlist_r;
    
    // blog_Comment contructor
    function __construct($file){
        $this->comment_file = $file;
        if(!file_exists($file))
            return 'Message: no file to open';
        if($file)
		   $this->jCommentObject = json_decode(file_get_contents($file));  
	    parent::__construct();
    }
    
    // get validity status of commenter: 0 not validated, 1 validated, 3 banned
    function get_status_by_index($index){
        foreach($this->jObject as $commenter){
             if($commenter->index == $index)
                return $commenter->valid;
        }
    }
    
    // return only comments from valid commenters
    function getValidComments(){
        foreach($this->jCommentObject->comments as $comment){
            if($this->get_status_by_index($comment->id) == 1)
                $validlist_r[] = $comment;
        }
        if(isset($validlist_r))
            return (object)$validlist_r;
    }

    // return only valid replies
    function getValidReplies(){
        foreach($this->jCommentObject->replies as $reply){
            if($this->get_status_by_index($reply->id) == 1)
                $validlist_r[] = $reply;
        }
        if(isset($validlist_r))
            return (object)$validlist_r;
    }

    // push reply
    function push_reply($object){
        
        $this->jCommentObject->replies[] = $object;
        file_put_contents($this->comment_file, json_encode($this->jCommentObject));
    }

  
}


?>


