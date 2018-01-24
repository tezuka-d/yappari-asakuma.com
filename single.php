<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

$pg_args["class"] = "News";
$pg_args["description"] = get_field("description");
$pg_args["keywords"] = get_field("keywords");
$pg_args["ogimg"] = get_field("entry_ogimg");
if (is_singular("blog")) {
	$pg_args["title"] = get_the_title() ." | Blog";
} else if (is_singular("news")) {
	$pg_args["title"] = get_the_title() ." | News";
} else {
	$pg_args["title"] = get_the_title();
}
$pg_args["url"] = get_the_permalink();
$pg_args["type"] = "article";

$btop = get_field("btop", "options");
$btitle = get_field("btitle", "options");
$btitle2 = get_field("btitle2", "options");

$tp[] = array (
	"link" => get_bloginfo("url") . "/",
	"title" => "HOME"
);

$tp[] = array (
	"link" => get_the_permalink($btop->ID),
	"title" => $btop->post_title
);

$tp[] = array (
	"link" => get_the_permalink(),
	"title" => get_the_title()
);

$pg_args["tp"] = $tp;


?>

<?php get_header(); ?>

<article>
<div class="PageBody bg1 single_php">
<div class="Inner">
<?php
if (is_singular("blog")) {
	echo '<h1 class="PageBodyTitleA"><span class="large">Blog</span></h1>';
} else if (is_singular("news")) {
	echo '<h1 class="PageBodyTitleA"><span class="large">News</span></h1>';
}?>
<?php

	if ( $btitle != "" || $btitle2 != "" ) {
		echo '<p class="PageBodyTitleA">';
		if ( $btitle != "" ) { echo '<span class="large">' . $btitle . '</span>'; }
		if ( $btitle2 != "" ) { echo '<span class="small">' . $btitle2 . '</span>'; }
		echo '</p>';
	}

	$colnum = 1;
	$blonum = 1;

	echo '<div class="BlogBody clearfix">';

	echo '<section class="BlogMain">';
	get_template_part( 'blogbody' );
?>

<div class="BlogNavi">
<div class="prev"><?php previous_post_link('%link','PREV') ?></div><!--
--><div class="all"><a href="<?php echo get_post_type_archive_link( get_post_type() ); ?>">LIST</a></div><!--
--><!-- <div class="all"><a href="<?php echo get_the_permalink($btop->ID); ?>">LIST</a></div> --><!--
--><div class="next"><?php next_post_link('%link','NEXT') ?></div>
</div>

<?php
	echo '</section>';
	echo '<section class="BlogSub">';
	get_template_part( 'blogside' );
	echo '</section>';
	
	echo '</div>';

?>


</div>
</div>
<?php if (! is_singular("blog") ): ?>
<section class="PageBody bg2 single_php">
<div class="Inner">

<h2 class="PageBodyTitleA"><span class="large">Recent Post</span></h2>

<?php
if ( is_singular("blog") ) {
} else {
	$no_img = get_field("no_img", "options");

	$postlist = get_posts( array(
		'posts_per_page' => 5,
		'offset' => 0,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'post_type' => 'post'
	));

	if($postlist) {
		echo '<div class="BlogRecentList">';
		foreach( $postlist as $post ) {
			$title = $post->post_title;
			$link = get_permalink($post->ID);
			$thumb = get_field("thumb");
			$date = get_the_time('Y.m.d');
			$newmark = get_field("newmark");

			if (!$thumb) { $thumb = $no_img; }
			echo '<div class="BlogListInner">';
			if ($newmark != "") {
				echo '<p class="BlogListNew">NEW</p>';
			}
			echo '<a href="' . $link . '" class="clearfix">';
			echo '<div class="BlogListThumb"><img src="' . $thumb["url"] , '" alt="' . $title . '"></div>';
			echo '<div class="BlogListTxt">';
			echo '<p class="BlogListDate">' . $date . '</p>';
			echo '<h3 class="BlogListTitle">' . $title . '</h3>';
			echo '</div>';
			echo '</a>';
			echo '</div>';
		}
		echo '</div>';
	}
	wp_reset_query();
}?>

</div>
</section>
<?php endif ;?>
</article>


<aside>
<?php
	get_template_part( 'footerbody' );
?>
</aside>





<?php get_footer(); ?>
