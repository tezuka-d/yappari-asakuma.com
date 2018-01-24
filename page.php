<?php
/**
 * The template for displaying pages
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
<?php
	$colnum = 1;
	$blonum = 1;
	get_template_part( 'pagebody' );
?>
</article>

<aside>
<?php
	get_template_part( 'footerbody' );
?>
</aside>

<?php //TopicPath($tp); ?>

<?php get_footer(); ?>
