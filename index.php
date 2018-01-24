<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage saito museum
 * @since saito museum
 */

$post_type = get_post_type_object( $post_type );
$terms = get_the_terms( $post->ID, 'classification' );
$img_url = get_stylesheet_directory_uri() . "/assets/img/";
$bg_url = get_stylesheet_directory_uri() . "/assets/images/";

$pg_args["id"] = "top";
$pg_args["url"] = get_bloginfo("url") . "/";
$pg_args["type"] = "website";

?>

<?php get_header(); ?>

<article>

<?php
	if (! is_ipad() ) {
		echo '<section id="TopImg">';
	} else {
		echo '<section id="TopImg" class="ipad">';
	}
	// echo '<div id="index-content">';
	// echo '<div class="index-content-box">';
	// echo '<p id="index-logo">Loading...</p>';
	// echo '</div>';
	// echo '</div>';
	$timg_logo = get_field('timg_logo', 'toppage');
	if ($timg_logo !="" && ! have_rows('timg_campaign', "toppage")) {
		echo '<p class="TopImg__logo"><img src="' . $timg_logo . '" alt="' . $txt . '"></p>';
	}
	if ( have_rows('timg_campaign', "toppage") ) {
		while ( have_rows('timg_campaign', "toppage") ) : the_row();
			$cam_txt = get_sub_field("campaign_txt");
			$cam_link = get_sub_field('campaign_link');
			$cam_url = get_sub_field('campaign_url');
			$cam_color = get_sub_field('campaign_color');
			$cam_bg = get_sub_field('campaign_bg');
				echo '<a href="' . $cam_link . '" class="TopImg__campaign" style="background:' . $cam_bg . '">';
				if ($cam_url == "" && $cam_link !== "") {
					echo '<p style="color:' . $cam_color . ';">';
				} else if ($cam_link == "") {
					echo '<p style="color:' . $cam_color . ';">';
				} else {}
				echo $cam_txt;
				echo '</p>';
				echo '</a>';
		endwhile;
	}
	echo '<div class="PageScroll"><p><a href="#">scroll</a></p></div>';
	echo '</section>';
	if ( have_rows("timg_pc", "toppage" ) ) {
		while ( have_rows('timg_pc', "toppage") ) : the_row();
			$img = get_sub_field("img");
			global $num;
			$num++;
			${$images}[$num] = $img;
		endwhile;
	}
?>
<script type="text/javascript">
$(function(){
	var js_num = 1;
	var minWidth = 800;
    $.sublime_slideshow({
        src:[

        {url:"<?php echo ${$images}[1]; ?>",/*title:""*/},
        {url:"<?php echo ${$images}[2]; ?>",/*title:""*/},
        {url:"<?php echo ${$images}[3]; ?>",/*title:""*/},
        ],
        duration:   7,
        fade:       4,
        scaling:    1.2,
        rotating:   2,
        overlay:    "<?php echo $bg_url; ?>pattern.png"
    });
    $("ul.sm-slider").appendTo("#TopImg");
    $(window).resize(function(){
    	if ( window.innerWidth > minWidth ) {
    		$('#TopImg .sm-slider li span').addClass('bg-at');//.css("background-attachment","fixed");
    		$('#TopImg.ipad .sm-slider li span').removeClass('bg-at');
    	}
    }).trigger('resize');
    $('.sm-slider').css("position","absolute").css("overflow","hidden");
    $('.sm-slider:after').css("position","absolute");
});
</script>
<?php
	$colnum = 1;
	$blonum = 1;
	get_template_part( 'pagebody' );
?>
<section id="sns" class="PageBody">
	<div class="Inner">
	<?php if (! is_mobile() ) :?>
		<ol class="timeline">
			<li class="sns__timeline__in">
				<?php echo do_shortcode( '[instagram-feed]' ) ?>
			</li>
			<li class="sns__timeline__fb"><iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2F%25E3%2582%2584%25E3%2581%25A3%25E3%2581%25B1%25E3%2582%258A%25E3%2581%2582%25E3%2581%2595%25E3%2581%258F%25E3%2581%25BE%25E4%25B9%259D%25E6%25AE%25B5%25E4%25B8%258B%25E5%25BA%2597-513319395728072%2F&tabs=timeline&height=525&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=false&appId" height="525" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe></li>
			<li class="sns__timeline__tw"><a class="twitter-timeline" data-height="525" href="https://twitter.com/yappari_kdst?ref_src=twsrc%5Etfw" data-chrome="nofooter">Tweets by yappari_kdst</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></li>
		</ol>
	<?php else :?>
		<ol class="sns__icon">
			<li class="sns__icon__in"><a href="https://www.instagram.com/yappari_kds/" target="_blank"></a></li>
			<li class="sns__icon__fb"><a href="https://www.facebook.com/%E3%82%84%E3%81%A3%E3%81%B1%E3%82%8A%E3%81%82%E3%81%95%E3%81%8F%E3%81%BE%E4%B9%9D%E6%AE%B5%E4%B8%8B%E5%BA%97-513319395728072/" target="_blank"></a></li>
			<li class="sns__icon__tw"><a href="https://twitter.com/yappari_kdst" target="_blank"></a></li>
		</ol>
	<?php endif;?>
	</div>
</section>

</article>

<aside>
<?php
	get_template_part( 'footerbody' );
?>
</aside>





<?php get_footer(); ?>
