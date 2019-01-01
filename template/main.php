
<!-- ******  LEFT PANE  ******
     ************************* -->
<div class="divmain m_l">
  <form action="obser.php" method="post" name="obser">
    <p class="pad"><input class="menu" type="submit" value="short observations"
           title="click for more observations" disabled /></p>
  </form>

  <div class="pad italic"><?= $short ?></div>
<!-- 
    <? if($sf): ?>
     <p style="text-align:right">
  
      <a href="shorts.php?f=<?= $sf ?>" class="slink"> ...more</a>

    <? endif; ?>  
 -->
<div id="left_clipart">
  <img style="width:90%;" 
     src="../public/img/uppng-christmas-tree-clipart-santa-claus-christmas-ornam-9b4e840df9f3a29e.png" alt="tree">
</div>
</div>

<!--*
    *  CENTER PANE OR BODY </p>
    ************************  -->
<div class="divmain m_c">
  <p class="body-date pad"><?= $display_date ?></p>
  <p class="pad"><?= $body ?>
</div>

<!--*
    *  RIGHT PANE OF WINDOW
    *************************  -->

<div class="divmain m_r">
  <p class="pad"><img src="img/image.jpg" alt="USFlag" class="lilf" />
  <p class="pad">
    <form action="/" method="get" id="blog_form">
    <ul>
      <? foreach($armenu_r as $li): ?>
        <li>
            <button class="menu" type="submit" name="text" value="<?= $li['file'] ?>">
              <?= $li['display'] ?>
            </button>
        </li>
      <? endforeach; ?>  
    </ul>
    </form>
    <button class="menu" onclick="pop_contents();" >more...</button>
  <p class="center" style="font-size:.7em"> &copy; 2014-2018 James Dark, et al.</p>
  <p class="center">
  <a href="mailto:jd@jdbtw.com?Subject=Your Blog"><button>have something to say?</button></a></p>
</div>

<!-- ******  comment section of page  ******
     ***************************************-->

<div class="commentwrapper">
  <form action="comment" method="post" id="submit">
    <div style="padding-bottom:0;">
      <span style="font-size:.7em">very attractive comment box by
      <a href="https://css-tricks.com/author/chriscoyier/">Chris Coyier</a></span>
    </div>
    <textarea name="comment" id="styled"
                  onfocus="this.value=''; setbg('#e5fff3');"
                      onblur="setbg('white')" disabled>
    Coming soon
    </textarea><!--  Enter your comment here...  -->
    <div>
      <input type="button" name="submit" value="send comment" disabled
                                            onclick="showComDialog()" />
      <input type="hidden" name="assoc_file" value="<?= $file ?>" />  
    </div>          
  </form>
  
  <!-- ******  comments display below  ******
       ************************************** -->
  <? if(isset($comments)): ?>
    <? foreach($comments as $comment): ?> 
      <div class="comment_display">
        <?= $comment->name ?>
        <blockquote>
          <?= $comment->comment ?>
        </blockquote>
		<? foreach($replies as $reply): ?>
		  <? if($reply->comment_idex == $comment->idex): ?>
			<blockquote class="replies">
			  <span style="font-style:normal;"><?= $reply->name ?>:</span>
		      <?= $reply->reply ?>
			</blockquote>
		  <? endif; ?>
		<? endforeach; ?>
        <input type="submit" name="reply" value="reply" >
        <hr>
      </div>
    <? endforeach; ?>
  <? endif; ?>
  <hr />
</div>

<!--
   *
   *     popup contents selection window     
   ****************************************** -->
   
<div class="popupWindow" id="popupWin">

  <div class="contentsWindow">
    <? foreach($content_list as $blog): ?>
        
      <p style="text-align: left;">
      <button class="menu" type="submit" name="text" form="blog_form"
                                               value="<?= $blog['file'] ?>" >
              <?= $blog['display'] ?>
      </button>
      </p>
            
            <blockquote>
            <h3><?= $blog['title'] ?></h3>
            <?= $blog['clip'] ?>
            </blockquote>
      <? endforeach; ?>
  </div>
</div>

<!-- ******  pop up comment submit dialog  ******
     ******************************************** -->
   
<div class="popDialog" id="commentSubDia">
  <button onclick="closeDiaWin('commentSubDia');">X</button>
  <h3>Confirm Comment Submission</h3>
  <input type="text" name="name" placeholder="name" form="submit" selected />
  <input type="email" name="email"
                  placeholder="valid email address" form="submit" />
  <input type="submit" name="submit" value="send" form="submit" />
</div>

<script>
    function pop_contents(){
        document.getElementById("popupWin").style.visibility = "visible";
    }
    function closeDiaWin(a){
        document.getElementById("commentSubDia").style.visibility = "hidden";
    }
    function showComDialog(){
        document.getElementById("commentSubDia").style.visibility = "visible";
    }
</script>

