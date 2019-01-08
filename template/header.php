<!DOCTYPE HTML>
<!-- written by James Dark et al.  -->
<html lang="en">
<!--  
  user = James Dark, jd@jdbtw.com
  blog_subject = conservative commentary
  -->
  <head>
    <meta charset="UTF-8">
    <? if(isset($blogpage)): ?>
        <meta name="subject" content="<?= $blog_subject ?>">
        <meta name="author" content="<?= $user ?>">
        <meta property="og:url" content="<?= $dis_url ?>" />
        <meta property="og:type" content="blog" />
        <meta property="og:title" content="<?=$titleString?>"/>
        <meta property="og:description"
                         content="Conservative commentary on today's politics"/>
        <meta name="og:site_name" content="A Darker View"/>
        <title><?= $hh->getTitleSting() ?></title>
    <? endif; ?>
    <? if(isset($adminpage)): ?>
        <title><?= $titleString ?></title>
    <? endif; ?>
    
    <link href="../include/css/blog.css" rel="stylesheet" />
    
  </head>
  <body>
  <? if(isset($adminpage)): ?>
    <h2>miniBlog Administration Configuration Page</h2>
  <? endif; ?>
  <? if(isset($blogpage)): ?>
  <div class="headwrapper">
  <h3>A Darker View</h3>
  <p class="t2">
  A darker view of the left and many liberals.&nbsp; Conservative opinion based
  on facts instead of fantasy or wishful thinking.&nbsp; I turn over the rock,
  looking at the darker and slimier side of leftist / liberal dogma, trying to
  expose the BS for what it truly is.</p>
  <p class="t2" style="font-size:160%;">James Dark</div>
  <? endif; ?>
  