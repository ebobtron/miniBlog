<?php
/*
 *    admin.php: admin controller for miniBlog  copyright 2019 J.Dark et al
 ******************************************************************************/
     error_reporting(E_ALL);
    
    // if https not in use
    if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
        // redirect
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
        exit; //Prevent the rest of the script from executing.
    }

    $user = 'please sign in';
    $signed_in = false;
    $first_use = false;
    $blog_subject = null;
    $set_user_error = null;
    $sign_in_error = null;
    
    if(isset($_COOKIE['goodycookie'])){
        $user = $_COOKIE['goodycookie'];
        $signed_in = true;
    }
        
    require('../include/blogClasses.php');
    $user_h = new blogUser();
    
    // check for first use
    if(!$user_h->user_obj){
        if(isset($_POST['submit']) && isset($_POST['password2'])){
            $set_user_error = $user_h->setUser((object)$_POST);
            if(!$set_user_error){
                header("Location: /public/admin");
                exit('exit: '.$result);
            }
        }
        $first_use = true;
    }        

    // if no cookie found sign in required for admin access
    // sign-in sets a cookie and reloads the page
    if(isset($_POST['submit']) && !$first_use ){
        $sign_in_error = $user_h->userSignIn((object)$_POST);
        if(!$sign_in_error){
            setcookie('goodycookie', $_POST['user_name'], time()+600); //129600
            header("Location: /public/admin");
            exit;
        }
    }
    
    echo "<br>Welcome $user";
    $titleString = 'Admin Page';
    $adminpage = true;
    
    $setup_h = null;  //         new setupClass()
    
    $head_line_one = $setup_h ? $setup_h : 'llne one<br>';
    $head_line_two = $setup_h ? $setup_h : 'llne two<br>';
    $head_line_three = $setup_h ? $setup_h : 'llne three<br>';
    
    // render page
    include '../template/header.php';
    
    include '../template/admin_t.php';
    
    include '../template/footer.php';
    

?>
