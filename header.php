<!DOCTYPE html>
<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage sb
 * @since sb
 */

$css_url = get_stylesheet_directory_uri() . "/assets/css/";
$js_url = get_stylesheet_directory_uri() . "/assets/js/";
$img_url = get_stylesheet_directory_uri() . "/assets/img/";
$blog_url = get_bloginfo("url") . "/";
$blog_name = get_bloginfo('name');
$en_link =  get_field('link_en', 'option');
$menu_logo = get_field('logo', 'option');
$logo_size = get_field('logo_size', 'option');
$tel_num = get_field('tel_num', 'option');

global $pg_args;
$pg_id = $pg_args["id"];
$og_title = $pg_args["title"];
$og_url = $pg_args["url"];
$og_type =  $pg_args["type"];
$og_desc = $pg_args["description"];
if ($og_desc == "") { $og_desc = get_field('basic_description', 'option'); }
$og_kw = $pg_args["keywords"];
if ($og_kw == "") { $og_kw = get_field('basic_keywords', 'option'); }
$og_img = $pg_args["ogimg"]["url"];
if ($og_img == "") { $og_img = get_field('og_img', 'option'); }
$og_fbad = get_field('facebook_admin', 'option');
$og_fbapp = get_field('facebook_app', 'option');
$fb_url = get_field('facebook_url', 'option');
$shop_url = get_field('onlineshop', 'option');

if (is_home() ) {
	$tag = "h1";
} else {
	$tag = "p";
}

?>
<html lang="ja">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if( is_mobile() ) :?>
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0,user-scalable=yes">
<?php elseif( is_ipad() ) :?>
<meta name="viewport" content="width=1080">
<?php endif ;?>
<title>
	<?php if ( is_post_type_archive( 'news' ) || is_post_type_archive( 'blog' ) ) {
			$custom_post_title = post_type_archive_title();
			echo $custom_post_title . " | ";
		} else if ($og_title != "") {
			echo $og_title . " | ";
		}
	 ?><?php echo $blog_name; ?>
</title>
<meta name="description" content="<?php echo $og_desc; ?>">
<meta name="keywords" content="<?php echo $og_kw; ?>">

<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $img_url; ?>favicon.ico">
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo $img_url; ?>favicon.ico">
<link href="<?php echo $img_url; ?>icon.png" rel="apple-touch-icon-precomposed">

<!-- meta ogp -->
<?php if ($og_fbad != "") { ?><meta property="fb:admins" content="<?php echo $og_fbad; ?>"><?php } ?>

<?php if ($og_fbapp != "") { ?><meta property="fb:app_id" content="<?php echo $og_fbapp; ?>"><?php } ?>

<?php if ($og_title != "") { ?><meta property="og:title" content="<?php echo $og_title; ?>"><?php } ?>
<?php if ($og_title == "") { ?><meta property="og:title" content="<?php echo $blog_name; ?>"><?php } ?>

<meta property="og:image" content="<?php echo $og_img; ?>">
<meta property="og:type" content="<?php echo $og_type; ?>">
<meta property="og:locale" content="ja_JP">
<meta property="og:url" content="<?php echo $og_url; ?>">
<meta property="og:site_name" content="<?php echo $blog_name; ?>">
<meta property="og:description" content="<?php echo $og_desc; ?>">
<!-- //meta ogp -->

<link rel="stylesheet" href="<?php echo $css_url; ?>slick.css">
<link rel="stylesheet" href="<?php echo $css_url; ?>common.css">
<?php if ( is_front_page() ) : ?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url; ?>sublimeSlideshow.css" media="all" />
<!-- <link rel="stylesheet" href="<?php echo $css_url; ?>index.css"> -->
<?php endif; ?>

<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo $js_url; ?>ihtml5.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo $js_url; ?>irespond.min.js" charset="UTF-8"></script>
<![endif]--> 

<script src="<?php echo $js_url; ?>jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCY8p7ToBFYwm2Oi1kzXy6QIGTzEWqEu90"></script>
<script src="<?php echo $js_url; ?>gmaps.min.js"></script>
<script src="<?php echo $js_url; ?>slick.min.js"></script>
<script src="<?php echo $js_url; ?>jQueryAutoHeight.js"></script>
<script src="<?php echo $js_url; ?>script.js"></script>
<?php if ( is_front_page() ) : ?>
<script type="text/javascript" src="<?php echo $js_url; ?>jquery.sublimeSlideshow.js"></script>
<!-- <script src="<?php echo $js_url; ?>jquery.cookie.js"></script>
<script src="<?php echo $js_url; ?>index.js"></script> -->
<?php endif; ?>

<?php wp_head(); ?>


<?php echo get_field('ga', 'option'); ?>
</head>

<body id="<?php echo $pg_id; ?>">
<header id="GlobalHeader" <?php if(! is_front_page() ) { echo 'class="inner_page"'; } ?>>
<div class="Inner">
<?php 
	if( $menu_logo !="" ) {
	echo '<' . $tag . ' class="HeaderLogo" style="background: url('. $menu_logo["url"] .') no-repeat center;';
	if ( is_mobile() ) {
		echo ' width: 50vw">';
	} else {
		echo ' width:' . $logo_size . '">';
	}
	echo '<a href="' . $blog_url . '">'. $blog_name .'</a></'. $tag .'>';
	}
?>
<?php
	if(! is_mobile() ) {
		echo '<ol class="GlobalHeader__Inner__menu">';
		if ( have_rows("gnavi", "options" ) ) {
			while ( have_rows('gnavi', "options") ) : the_row();
				$txt = get_sub_field("gnavi_txt");
				$link = getLink(get_sub_field("gnavi_link"), get_sub_field("gnavi_url"), get_sub_field("gnavi_anc") );
				$target = get_sub_field("gnavi_target");
				if ($txt != "") {
					echo '<li><a href="' . $link[0] . '" ' . $link[1] . '  target="' . $target[0] . '">' . $txt . '</a></li>';
				}
			endwhile;
		}
		if ($tel_num !="") {
			$oc_tel = "onclick=\"ga('send','pageview','/call');\"";
			echo '<li class="GlobalHeader__Inner__tel"><a href="tel:' . $tel_num . '" '.$oc_tel.'>' . $tel_num . '</a></li>';
		}
		echo '</ol>';
	}
?>
<?php if(is_mobile()):?>
	<a class="hamburger" href="#">
	   <span class="top-bar"></span>
	   <span class="middle-bar"></span>
	   <span class="bottom-bar"></span>
	</a>
<?php endif;?>
<nav id="GlobalNavi">
<div class="GlobalNaviInner">

<a class="hamburger_close" href="#">
	<span class="top-bar"></span>
	<span class="bottom-bar"></span>
</a>

<?php
if ( have_rows("gnavi", "options" ) ) {
	echo '<ul class="GlobalNaviList">';
	while ( have_rows('gnavi', "options") ) : the_row();
		$txt = get_sub_field("gnavi_txt");
		$link = getLink(get_sub_field("gnavi_link"), get_sub_field("gnavi_url"), get_sub_field("gnavi_anc") );
		$target = get_sub_field("gnavi_target");
		if ($txt != "") {
			echo '<li><a href="' . $link[0] . '" ' . $link[1] . '  target="' . $target[0] . '">' . $txt . '</a></li>';
		}
	endwhile;
	echo '</ul>';
}

// if ($menu_logo["url"] != "") {
// 	echo '<div class="GlobalNaviLogo">';
// 	echo '<a href="' .  $blog_url . '"><img src="' . $menu_logo["url"] . '" alt="' . $blog_name . '"></a>';
// 	echo '</div>';
// }

?>


</div>
</nav>

</div>
</header>

<div id="wrap">
