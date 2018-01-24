<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

$post_type = get_post_type_object( $post_type );

$pg_args["class"] = "News";
$pg_args["description"] = get_field("description");
$pg_args["keywords"] = get_field("keywords");
$pg_args["ogimg"] = get_field("entry_ogimg");
if (is_singular("blog")) {
	$pg_args["title"] = get_the_title() . " | Blog";
} else if (is_singular("news")) {
	$pg_args["title"] = get_the_title() . " | News";
} else {
	$pg_args["title"] = get_the_title();
}
$pg_args["url"] = get_the_permalink();
$pg_args["type"] = "article";

$ntitle = get_field("ntitle", "options");
$ntitle2 = get_field("ntitle2", "options");

$tp[] = array (
	"link" => get_bloginfo("url") . "/",
	"title" => "HOME"
);

$tp[] = array (
	"link" => get_post_type_archive_link($post_type->name),
	"title" => $ntitle2
);

$tp[] = array (
	"link" => get_the_permalink(),
	"title" => get_the_title()
);

$pg_args["tp"] = $tp;

?>

<?php get_header(); ?>

<article>
<div class="PageBody bg1 single-news_php">
<div class="Inner">

<?php
if (is_singular("blog")) {
	echo '<h1 class="PageBodyTitleA"><span class="large">Blog</span></h1>';
} else if (is_singular("news")) {
	echo '<h1 class="PageBodyTitleA"><span class="large">News</span></h1>';
}?>
<?php

	if ( $ntitle != "" || $ntitle2 != "" ) {
		echo '<p class="PageBodyTitleA">';
		if ( $ntitle != "" ) { echo '<span class="large">' . $ntitle . '</span>'; }
		if ( $ntitle2 != "" ) { echo '<span class="small">' . $ntitle2 . '</span>'; }
		echo '</p>';
	}


	$colnum = 1;
	$blonum = 1;

	echo '<div class="BlogBody clearfix">';

	echo '<section class="BlogMain">';
	get_template_part( 'newsbody' );
?>

<div class="BlogNavi">
<div class="prev"><?php previous_post_link('%link','PREV') ?></div><!--
--><div class="all"><a href="<?php echo get_post_type_archive_link($post_type->name); ?>">LIST</a></div><!--
--><div class="next"><?php next_post_link('%link','NEXT') ?></div>
</div>

<?php
	echo '</section>';
	echo '<section class="BlogSub">';
	get_template_part( 'newsside' );
	echo '</section>';
	echo '</div>';

?>


</div>
</div>

</article>

<aside>
<?php
	get_template_part( 'footerbody' );
?>
</aside>


<?php get_footer(); ?>
