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
$post_type = get_post_type_object( 'events' );
$termname = single_term_title('',false);
$terms = get_term_by( 'name', $termname, 'event_cats', OBJECT);
$pg_args["class"] = "Events";
$pg_args["description"] = $terms->description;
$pg_args["title"] = $terms->name;
$pg_args["url"] = get_term_link($terms->slug, $terms->taxonomy);
$pg_args["type"] = "article";

$tp[] = array (
	"link" => $en_link,
	"title" => "HOME"
);

$tp[] = array (
	"link" => get_post_type_archive_link($post_type->name),
	"title" => $post_type->label
);

$tp[] = array (
	"link" => get_term_link($terms->slug, $terms->taxonomy),
	"title" => $terms->name
);


$pg_args["tp"] = $tp;
?>

<?php get_header(""); ?>

<article>
<section class="gray249" id="CatArea">
<div class="inner clearfix">
<div class="row1">
<p class="CatTitle" id="CatEvents"><span><?php echo $terms->name; ?></span></p>
</div>
</div>
</section>

<section class="white CatTabArea">
<div class="inner clearfix">
<div class="row1">
<?php
//展示会カテゴリ一覧
$current = $terms->slug;
EvTagList($current);
?>
</div>
</div>
</section>

<?php
$i = 0;
while(have_posts()):the_post();
	$terms = get_the_terms( $post->ID, 'event_cats' );
	$i++;
	if ($i%2 == 0) {
		$class = "gray242";
	} else {
		$class = "white";
	}
?>

<section class="<?php echo $class; ?> EntryArea">
<div class="inner clearfix">
<div class="row1">

<div class="EntryHeader">

<p class="EntryHeaderCat"><span class="excaticon_<?php echo $terms[0]->slug; ?>"><?php echo $terms[0]->name; ?></span></p>
<?php the_title('<h1 class="EntryHeaderTitle">', '</h1>'); ?>

<?php if ( get_field("schedule") != "" || get_field("place") ) { ?>

<p class="EntryHeaderInfo">
<?php if ( get_field("schedule") != ""  ) { echo get_field("schedule"); } ?>
<?php if ( get_field("place") != ""  ) { echo '<span class="EntryHeaderPlace"> : ' . get_field("place") . '</span>'; } ?>
</p>
<?php } ?>
</div>

<?php get_template_part('enrtybody');?>


</div>
</div>
</section>
<?php endwhile; ?>

<?php
if($wp_query->max_num_pages > 1) {
	 get_template_part( 'pagination' );
}
?>

</article>

<?php get_footer(); ?>