<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0 
 */

$title = "404 Not Found";
$pg_args["title"] = $title;
$pg_args["url"] = get_the_permalink();
$pg_args["type"] = "article";
$pg_args["id"] = "notfound";
$tp[] = array (
	"link" => get_bloginfo("url") . "/",
		"title" => "HOME"
);
$tp[] = array (
	"link" => get_the_permalink(),
	"title" => $title
);
$pg_args["tp"] = $tp;

get_header(); ?>

<article>
<section class="gray249 PageBody" id="CatArea">
<div class="inner clearfix Inner">
<div class="row1">
<h1 class="PageBodyTitleA CatTitle en" id="Cat404"><span class="large">404 Not Found</span></h1>
</div>
</div>
</section>

<section class="white PageBodyArea PageBody">
<div class="inner clearfix Inner">
<div class="row1">
<p>お探しのページは<br>見つかりませんでした</p>
</div>
</div>
</section>
</article>


<?php get_footer(); ?>
