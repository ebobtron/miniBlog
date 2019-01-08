<!-- ****  admin_t.php admin template / view  **** -->

<!-- ****  SIGN IN BLOCK  **** 
     ************************* -->
<? if(!$signed_in): ?>
<form action="" method="post">
  <div class="signin">
    sign in please
    <? if($sign_in_error): ?>
      <br>
      <span style="color: #ff0000;"><?= $sign_in_error ?></span>
    <? endif; ?>
    <div class="signin_inner">
      user name<br />
      <input type="text" name="user_name" placeholder="first and last name" /><br />
      password<br />
      <input type="password" name="password" /><br />
      <hr> 
      <input type="submit" name="submit" value="submit" />
      <input type="submit" name="change" value="change password" />
    </div>
  </div>
</form>
<? endif; ?>

<!--  ****  SET USER CREDENTIALS  ****
      ******************************** -->
<? if($first_use): ?>
<form action="" method="post">
  <div class="signin">
    Please provide the requested information
    <div class="signin_inner">
      user name<br />
      <input type="text" name="user_name" placeholder="first and last name" /><br />
      email address<br />
      <input type="email" name="user_email" placeholder="email address" /><br />
      <? if($set_user_error): ?>
      <span style="color: #ff0000;"><?= $set_user_error ?></span>
      <? endif; ?>
      password<br />
      <input type="password" name="password1" /><br />
      repeat password
      <input type="password" name="password2" />
      <hr>
      <input type="submit" name="submit" value="submit" />
    </div>
  </div>
</form>
<? endif; ?>

<!--  ****  BLOG SETUP PAGE BLOCK  ****
      *********************************  -->
<? if($signed_in): ?>
  <div>
    <form action="" method="post">
    main blog page header<br>
    <div style="border:1px solid black;margin:10px">
            <?= $head_line_one ?>
            <?= $head_line_two ?>
            <?= $head_line_three ?>
    </div>
    <textarea name="text"></textarea><br>
    <input type="submit" name="submit_?????" value="save" />
    </form>
  </div>
<? endif; ?>
