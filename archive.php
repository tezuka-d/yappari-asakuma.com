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

$pg_args["class"] = "News";
$pg_args["description"] = get_field("description");
$pg_args["keywords"] = get_field("keywords");
$pg_args["ogimg"] = get_field("entry_ogimg");
$pg_args["title"] = get_the_title();
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

if ($year != "") {
	$pg_args["url"] = get_year_link( $year );
	$pg_args["title"] = get_the_time( 'Y年' );

	$tp[] = array (
		"link" => get_year_link( $year ),
		"title" => get_the_time( 'Y年' )
	);
} else {
	$category = get_the_category();
	$pg_args["title"] = $category[0]->cat_name;
	$cat_id = $category[0]->cat_ID;
	$pg_args["url"] = get_category_link($cat_id);

	$tp[] = array (
		"link" => get_category_link($cat_id),
		"title" => $category[0]->cat_name
	);

}

$pg_args["tp"] = $tp;
?>

<?php get_header(); ?>

<article>
<div class="PageBody bg1 archive_php">
<div class="Inner">
<?php
if (is_post_type_archive("blog")) {
	echo '<h1 class="PageBodyTitleA"><span class="large">Blog</span></h1>';
} else if (is_post_type_archive("news")) {
	echo '<h1 class="PageBodyTitleA"><span class="large">News</span></h1>';
}?>
<?php

	$no_img = get_field("no_img", "options");


	if ( $btitle != "" || $btitle2 != "" ) {
		echo '<p class="PageBodyTitleA">';
		if ( $btitle != "" ) { echo '<span class="large">' . $btitle . '</span>'; }
		if ( $btitle2 != "" ) { echo '<span class="small">' . $pg_args["title"] . '</span>'; }
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
		if ($no_img !="") {
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
		} else {
			echo '<div class="BlogListInner no_thumb">';
			echo '<div class="BlogListInfo">';
				if ($newmark != "") {
					echo '<p class="BlogListNew">NEW</p>';
				}
				echo '<p class="BlogListDate">' . $date . '</p>';
			echo '</div>';
			echo '<a href="' . $link . '" class="clearfix">';
			echo '<h3 class="BlogListTitle">' . $title . '</h3>';
			echo '</a>';
			echo '</div>';
		}
	endwhile;

	if($wp_query->max_num_pages > 1) {
		 get_template_part( 'pagination' );
	}


	echo '</section>';
	echo '<section class="BlogSub">';
	get_template_part( 'blogside' );
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
