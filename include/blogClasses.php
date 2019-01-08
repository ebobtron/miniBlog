<?php
/*
 *    Blog Classes  blogClasses.php
 **************************************/

// this class retieves strings
class configStrings{
    
    var $head_strings;
    #var title strings
    #var other strings

    function __construct($file='../include/config/head_string.json'){
        if(!file_exists($file))
            return 0;
        $this->head_strings = json_decode(file_get_contents($file));
        #var title strings
        #var other strings
    }
    
    function getTitleSting($page=null){
        return $this->head_strings->title;
    }
     
}

class blogUser{
    
    var $user_obj;
    //var $second_obj;
    
    function __construct($file='../include/config/user.json'){
        if(file_exists($file))
            $this->user_obj = json_decode(file_get_contents($file));    
    }
   
    function setUser($user){
        if($user->password1 != $user->password2)
            return 'passwords don\'t match';
         
        $user->password = crypt($user->password1 , '$2a$09$'.$user->password1);
        unset($user->password1);
        unset($user->password2);
        unset($user->submit);
        file_put_contents('../include/config/user.json', json_encode($user));
    }
    
    function userSignIn($object){        
        if($this->user_obj->user_name == $object->user_name){
            if(crypt($object->password, '$2a$09$'.$object->password) == $this->user_obj->password)
                return null;
            else
                return 'password doesn\'t match';
        }
        else
            return 'user name does not match user on file';
    }
    
}

//  exit('<br>exit user sign in');;exit('<br>exit user match');exit('<br>exit: wow passwords match');
?>
