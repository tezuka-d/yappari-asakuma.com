<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

$post_type = get_post_type_object( $post_type );
$ntitle = get_field("ntitle", "options");
$ntitle2 = get_field("ntitle2", "options");

$pg_args["class"] = "News";
$pg_args["description"] = $post_type->description;
$pg_args["title"] = $ntitle2;
$pg_args["url"] = get_post_type_archive_link($post_type->name);
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

if ($year != "") {
	$pg_args["url"] = get_year_link( $year );
	$pg_args["title"] = get_the_time( 'Y年' );

	$tp[] = array (
		"link" => get_year_link( $year ),
		"title" => get_the_time( 'Y年' )
	);
}

$pg_args["tp"] = $tp;

?>

<?php get_header(); ?>

<article>
<div class="PageBody bg1 archive-news_php">
<div class="Inner">
<?php
if (is_post_type_archive("blog")) {
	echo '<h1 class="PageBodyTitleA"><span class="large">Blog</span></h1>';
} else if (is_post_type_archive("news")) {
	echo '<h1 class="PageBodyTitleA"><span class="large">News</span></h1>';
}?>
<?php

	$no_img = get_field("no_img", "options");


	if ( $ntitle != "" || $ntitle2 != "" ) {
		echo '<p class="PageBodyTitleA">';
		if ( $ntitle != "" ) { echo '<span class="large">' . $ntitle . '</span>'; }
		if ( $ntitle2 != "" ) { echo '<span class="small">' . $pg_args["title"] . '</span>'; }
		echo '</p>';
	}

	$colnum = 1;
	$blonum = 1;

	echo '<div class="BlogBody clearfix">';

	echo '<section class="BlogMain">';

	while(have_posts()):the_post();
		$title =  get_the_title();
		$link = get_permalink($post->ID);
		$thumb = get_field("thumb");
		$date = get_the_time('Y.m.d');
		$newmark = get_field("newmark");

		if (!$thumb) { $thumb = $no_img; }
		echo '<div class="NewsListInner">';
		echo '<div class="NewsListInfo">';
			if ($newmark != "") {
				echo '<p class="NewsListNew">NEW</p>';
			}
			echo '<p class="NewsListDate">' . $date . '</p>';
		echo '</div>';
		echo '<a href="' . $link . '">';
		echo '<h3 class="NewsListTitle">' . $title . '</h3>';
		echo '</a>';
		echo '</div>';
	endwhile;

	if($wp_query->max_num_pages > 1) {
		 get_template_part( 'pagination' );
	}


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
