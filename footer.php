<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

global $pg_args;

$tp = $pg_args["tp"];
$img_url = get_stylesheet_directory_uri() . "/assets/img/";
$blog_url = get_bloginfo("url") . "/";

$copy = get_field('copy', 'footer');
$footer_logo = get_field('footer_logo', 'footer');
$footer_logo_w = get_field('footer_logo_w', 'footer');
$sp_tel_num = get_field('sp_tel_num', 'footer');
$sp_times_open = get_field('sp_times_open', 'footer');
$sp_times_close = get_field('sp_times_close', 'footer');

?>

<aside class="footer_php">

<section id="FooterBnr">
<div class="Inner">
<?php
if ( have_rows("fbnr", "options" ) ) {
	echo '<ul class="FootBnrList">';
	while ( have_rows('fbnr', "options") ) : the_row();
		$img = get_sub_field("fbnr_img");
		$txt0 = get_sub_field("fbnr_txt0");
		$txt = get_sub_field("fbnr_txt");
		$link = getLink(get_sub_field("fbnr_link"), get_sub_field("fbnr_url"), get_sub_field("fbnr_anc") );
		$target = get_sub_field("fbnr_target");
		if ($txt != "" || $txt0 != "" ) {
			echo '<li><a href="' . $link . '" target="' . $target[0] . '">';
			echo '<div class="FootBnrListThumb"><img src="' . $img["url"] . '" alt="' . $txt . '"></div>';
			echo '<div class="FootBnrTitle"><p><span class="FootBnrTitleSmall">' . $txt0 . '</span><span class="FootBnrTitleLarge">' . $txt . '</span></p></div>';
			echo '</a></li>';
		}
	endwhile;
	echo '</ul>';
}
?>
</div>
</section>

<section id="FooterMap"></section>

<?php
if ( $mb_ltxt != "" ) {
	echo '<section id="FooterContact">';
	echo '<a href="' . $mb_link . '" target="' . $mb_target . '"><span>' . $mb_ltxt . '</span></a>';
	echo '</section>';
}
?>

<nav id="FooterNavi">
<div class="Inner clearfix">

<div class="FootNaviLogo"><a href="<?php echo $blog_url; ?>"><?php echo $blog_name; ?></a></div>

<?php
if ( have_rows("fnavi", "options" ) ) {
	echo '<ul class="FootNaviList1">';
	while ( have_rows('fnavi', "options") ) : the_row();
		$txt = get_sub_field("fnavi_txt");
		$link = getLink(get_sub_field("fnavi_link"), get_sub_field("fnavi_url"), get_sub_field("fnavi_anc") );
		$target = get_sub_field("fnavi_target");
		if ($txt != "") {
			echo '<li><a href="' . $link . '" target="' . $target[0] . '">' . $txt . '</a></li>';
		}
	endwhile;
	echo '</ul>';
}

if ( have_rows("fnavi2", "options" ) ) {
	echo '<ul class="FootNaviList2">';
	while ( have_rows('fnavi2', "options") ) : the_row();
		$txt = get_sub_field("fnavi2_txt");
		$link = getLink(get_sub_field("fnavi2_link"), get_sub_field("fnavi2_url"), get_sub_field("fnavi2_anc") );
		$target = get_sub_field("fnavi2_target");
		$cls = get_sub_field("fnavi2_icon");
		if ($txt != "") {
			echo '<li><a href="' . $link . '" target="' . $target[0] . '" class="' . $cls . '">' . $txt . '</a></li>';
		}
	endwhile;
	echo '</ul>';
}
?>

</div>

</nav>
<?php
if ( is_mobile() ) {
	$oc_tel = "onclick=\"ga('send','pageview','/call');\"";
	if ($sp_tel_num !="" || $sp_times_open !="" || $sp_times_close !="" ) {
		echo '<section class="sp_info bg7">';
			if ($sp_tel_num !="") {
				echo '<div class="sp_info__tel">';
					echo '<p class="sp_info__tel__txt">電話をかける</p>';
					echo '<a href="tel:' . $sp_tel_num . '" class="sp_info__tel__num" '.$oc_tel.'>' . $sp_tel_num . '</a>';
				echo '</div>';
			}
			if ($sp_times_open !="" && $sp_times_close !="") {
				echo '<div class="sp_info__times">';
					echo '<p>営業時間：' . $sp_times_open . '〜' . $sp_times_close . '</p>';
				echo '</div>';
			}
		echo '</section>';
	}
}
?>
</aside>



<footer id="Footer">
<div class="Inner">

<?php
if ( have_rows("sideul", "options" ) ) {
	echo '<div class="RightNav">';
	while ( have_rows('sideul', "options") ) : the_row();
		$ulbg = get_sub_field("bg");
		if( have_rows("li") ) {
			echo '<ul class="' . $ulbg . '">';
			while ( have_rows('li') ) : the_row();
				$txt = get_sub_field("txt");
				$icon = get_sub_field("icon");
				$link = getLink(get_sub_field("link"), get_sub_field("url"), get_sub_field("anc") );
				$target = get_sub_field("target");
				$pagetop = get_sub_field("pagetop");
				if($pagetop && $txt != "") {
					echo '<li><a href="' . $link[0] . '" target="' . $target[0] . '" class="' . $icon . '" id="PageTop"><span>' . $txt . '</span></a></li>';
				} else if ($txt != "") {
					echo '<li><a href="' . $link[0] . '" target="' . $target[0] . '" class="' . $icon . '"><span>' . $txt . '</span></a></li>';
				}
			endwhile;
			echo '</ul>';
		}
	endwhile;
	echo '</div>';
}
?>

<?php
if ( have_rows("fnavi", "footer" ) ) {
	echo '<ul class="FootNaviList">';
	while ( have_rows('fnavi', "footer") ) : the_row();
		$txt = get_sub_field("fnavi_txt");
		$link = getLink(get_sub_field("fnavi_link"), get_sub_field("fnavi_url"), get_sub_field("fnavi_anc") );
		$target = get_sub_field("fnavi_target");
		if ($txt != "") {
			echo '<li><a href="' . $link[0] . '" ' . $link[1] . '  target="' . $target[0] . '">' . $txt . '</a></li>';
		}
	endwhile;
	echo '</ul>';
}
?>
<?php
if ( have_rows("footer_logos", "footer" ) ) {
	echo '<ul class="Footlogo_s">';
	while (have_rows("footer_logos", "footer" )) : the_row();
		$ft_logo = get_sub_field("logos");
		$ft_width = get_sub_field("ft_width");
		$ft_url = get_sub_field("ft_url");
		$target = get_sub_field("target");

		if ($ft_logo['url'] !="") {
			if (is_mobile()) {
				echo '<li class="Footlogo_s__logo Footlogo_s__logo--mobile">';
			} else {
				echo '<li class="Footlogo_s__logo';
				if ($ft_width !="") {
					echo '" style="width: ' . $ft_width . '';
				}
				echo '">';
			}
			if ($ft_url !="") {
				if ($target !="") {
					echo '<a href="' . $ft_url . '" target="_blank">';
				} else {
					echo '<a href="' . $ft_url . '">';
				}
			}
			echo '<img src="' . $ft_logo['url'] . '" alt="' . $ft_logo['alt'] . '">';
			if ($ft_url !="") {
				echo '</a>';
			}
			echo '</li>';
		}
	endwhile;
	echo '</ul>';
}
?>
<p class="FootCopy"><span><?php echo $copy; ?></span></p>

</div>
</footer>

</div>

</body>
</html>

<?php wp_footer(); ?>

