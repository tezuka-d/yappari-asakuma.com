<?php
/**
Template Name: ブログトップ用
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

$title = get_the_title();

$pg_args["description"] = get_field("description");
$pg_args["keywords"] = get_field("keywords");
$pg_args["ogimg"] = get_field("entry_ogimg");
$pg_args["title"] = $title;
$pg_args["url"] = get_the_permalink();
$pg_args["type"] = "article";

$btitle = get_field("btitle", "options");
$btitle2 = get_field("btitle2", "options");

$tp[] = array (
	"link" => get_bloginfo("url") . "/",
	"title" => "Home"
);

$family = ($post->ancestors);
foreach(array_reverse($family) as $fid) {
		$ftitle = get_the_title($fid);
		$flink = get_permalink($fid);
		$tp[] = array (
			"link" => $flink,
			"title" => $ftitle
		);
}

$tp[] = array (
	"link" => get_the_permalink(),
	"title" => get_the_title()
);

$pg_args["tp"] = $tp;

?>

<?php get_header(); ?>

<article>
<div class="PageBody bg1">
<div class="Inner">

<?php

	$no_img = get_field("no_img", "options");

	if ( $btitle != "" || $btitle2 != "" ) {
		echo '<p class="PageBodyTitleA">';
		if ( $btitle != "" ) { echo '<span class="large">' . $btitle . '</span>'; }
		if ( $btitle2 != "" ) { echo '<span class="small">' . $btitle2 . '</span>'; }
		echo '</p>';
	}

	echo '<div class="BlogBody clearfix">';

	echo '<section class="BlogMain">';

	$paged = (int) get_query_var('paged');
	$args = array(
		'paged' => $paged,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_type' => 'post',
		'post_status' => 'publish'
	);
	$the_query = new WP_Query($args);
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$title =  get_the_title();
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
		endwhile;
	}

	if($the_query->max_num_pages > 1) {
		echo '<div class="BlogPagenate">';
		$paginate_base = get_pagenum_link(1) . '%_%';
		$paginate_format = '/page/%#%/';
		
		echo paginate_links(array(
			'base' => $paginate_base,
			'format' => $paginate_format,
			'total' => $wp_query->max_num_pages,
			'mid_size' => 2,
			'current' => max(1, $paged),
			'total' => $the_query->max_num_pages,
			'prev_next' => false
		));
		echo '</div>';
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

<?php //TopicPath($tp); ?>

<?php get_footer(); ?>
