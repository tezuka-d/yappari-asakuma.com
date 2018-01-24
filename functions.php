<?php
/**
 * Twenty Fifteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

remove_action( 'wp_head',             '_wp_render_title_tag',            1     );
//remove_action( 'wp_head',             'wp_enqueue_scripts',              1     );
remove_action( 'wp_head',             'feed_links',                      2     );
remove_action( 'wp_head',             'feed_links_extra',                3     );
remove_action( 'wp_head',             'rsd_link'                               );
remove_action( 'wp_head',             'wlwmanifest_link'                       );
remove_action( 'wp_head',             'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head',             'locale_stylesheet'                      );
remove_action( 'publish_future_post', 'check_and_publish_future_post',   10, 1 );
remove_action( 'wp_head',             'noindex',                          1    );
remove_action( 'wp_head',             'print_emoji_detection_script',     7    );
//remove_action( 'wp_head',             'wp_print_styles',                  8    );
remove_action( 'wp_head',             'wp_print_head_scripts',            9    );
remove_action( 'wp_head',             'wp_generator'                           );
remove_action( 'wp_head',             'rel_canonical'                          );
//remove_action( 'wp_footer',           'wp_print_footer_scripts',         20    );
remove_action( 'wp_head',             'wp_shortlink_wp_head',            10, 0 );
remove_action( 'template_redirect',   'wp_shortlink_header',             11, 0 );
//remove_action( 'wp_print_footer_scripts', '_wp_footer_scripts'                 );
remove_action( 'init',                'check_theme_switched',            99    );
remove_action( 'after_switch_theme',  '_wp_sidebars_changed'                   );
remove_action( 'wp_print_styles',     'print_emoji_styles'                     );


if (current_user_can('administrator')) { // 管理者を対象
$op_args = array(
	'page_title' => 'ページ基本設定',
	'menu_slug' 	=> 'theme-general-settings',
	'capability'	=> 'edit_posts',
	'redirect'		=> false,
	'position' => 12,
	'post_id' => 'options'
);
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page($op_args);
}

$op_args = array(
	'page_title' => 'トップページ設定',
	'menu_slug' 	=> 'top_img_setting',
	'capability'	=> 'edit_posts',
	'redirect'		=> false,
	'position' => 13,
	'post_id' => 'toppage'
);
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page($op_args);
}

$op_args = array(
	'page_title' => '共通フッター設定',
	'menu_slug' 	=> 'footer_setting',
	'capability'	=> 'edit_posts',
	'redirect'		=> false,
	'position' => 14,
	'post_id' => 'footer'
);
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page($op_args);
}
}

function getLink($link, $url, $anc) {
	$lnk = "";
	$return = array();
	if($link != "") {
		$lnk = $link;
	} else if ($url != "") {
		$lnk = $url;
	}
	$return[] = $lnk . $anc;
	if ($lnk == "") {
		$return[] = ' class="scroll"';
	}
	
	
	return $return;
}

function my_archives_link($html){
if(preg_match('/[0-9]+?<\/a>/', $html)) {
	$html = preg_replace('/([0-9]+?)<\/a>/', '$1年</a>', $html);
	$html = preg_replace('/\?post_type=news/', '', $html);
}
if(preg_match('/title=[\'\"][0-9]+?[\'\"]/', $html)) {
	$html = preg_replace('/(title=[\'\"][0-9]+?)([\'\"])/', '$1年$2', $html);
}

return $html;
}
add_filter('get_archives_link', 'my_archives_link', 10);

function create_xml_sitemap() {

	$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
			'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

		$sitemap .=
			"\t" . '<url>' . "\n" .
			"\t\t" . '<loc>' . get_bloginfo("url") . '</loc>' . "\n" .
			"\t\t" . '<lastmod>' . date("Y-m-d") . '</lastmod>' . "\n" .
			"\t\t" . '<changefreq>always</changefreq>' . "\n" .
			"\t\t" . '<priority>1</priority>' . "\n" .
			"\t" . '</url>' . "\n";


	$args = array(
		'posts_per_page' => -1,
		'orderby' => 'modified',
		'order' => 'DESC',
		'post_type' => array('post','page','news'),
		'post_status' => 'publish'
	);
	$posts_array = get_posts( $args );
	foreach( $posts_array as $post) {
		$post_modified = explode(' ', $post->post_modified);
		$sitemap .=
			"\t" . '<url>' . "\n" .
			"\t\t" . '<loc>' . get_permalink( $post->ID ) . '</loc>' . "\n" .
			"\t\t" . '<lastmod>' . $post_modified[0] . '</lastmod>' . "\n" .
			"\t\t" . '<changefreq>weekly</changefreq>' . "\n" .
			"\t\t" . '<priority>0.8</priority>' . "\n" .
			"\t" . '</url>' . "\n";
	}
	$sitemap .= '</urlset>' . "\n";

	$fh = fopen( ABSPATH. "sitemap.xml", 'w' );
	if ($fh) {
		fwrite($fh, $sitemap);
		fclose($fh);
		// グーグルに更新したことを通知
		ping_trans( 'http://google.com/ping?sitemap=' . esc_url( home_url('/') ) . 'wp/sitemap.xml');
	}
}
// 投稿ステータスが公開または更新でサイトマップを作成するようにする
add_action( "publish_post", "create_xml_sitemap" );
add_action( "publish_page", "create_xml_sitemap" );
add_action( "publish_property_infomation", "create_xml_sitemap" );
add_action( "publish_interview", "create_xml_sitemap" );
add_action( "publish_recruit", "create_xml_sitemap" );
add_action( "publish_topic", "create_xml_sitemap" );
add_action( "publish_recruit2", "create_xml_sitemap" );

function ping_trans($url) {
	$ch = curl_init();
	if ($ch != false) {
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result= curl_exec($ch);
		curl_close($ch);

		// 送信結果をログファイルに保存
		if ($result == false) {
			$str = date_i18n("Y-m-d H:i:s") . ' send NG.' . "\n";
		} else {
			$str = date_i18n("Y-m-d H:i:s") . ' send OK.' . "\n";
		}
		$fh = fopen( ABSPATH. "sitemap.log", 'a+' );
		if ($fh) {
			fwrite($fh, $str);
			fclose($fh);
		}
	}
}

// ぱんくず出力
function TopicPath($tp) {
	if ($tp) {
		echo '<section id="TopicPath">';
		echo '<div class="Inner">';
		echo '<ul class="TopicPathList">';
		$i = 1;
		foreach($tp as $list) {
			$title = $list["title"];
			$link = $list["link"];
			if (count($tp) > $i) {
				echo '<li><a href="' . $link . '">' . $title . '</a></li>';
			} else {
				echo '<li><span>' . $title . '</span></li>';
			}
			$i++;
		}
		echo '</ul>';
		echo '</div>';
		echo '</section>';
	}
}


function custom_pre_get_posts( $wp_query ) {
	if ( ! is_admin() && $wp_query->is_main_query() ) {
		if ( $wp_query->is_category() || $wp_query->is_tag() ) {
			$post_types = array();
			$all_post_types = get_post_types( array( 'exclude_from_search' => false ) );
			if ( $wp_query->is_category() ) {
				foreach ( $all_post_types as $pt ) {
					$object_taxonomies = $pt === 'attachment' ? get_taxonomies_for_attachments() : get_object_taxonomies( $pt );
					if ( in_array( 'category', $object_taxonomies ) && ! in_array( $pt, $post_types ) ) {
						$post_types[] = $pt;
					}
				}
			}
			if ( $wp_query->is_tag() ) {
				foreach ( $all_post_types as $pt ) {
					$object_taxonomies = $pt === 'attachment' ? get_taxonomies_for_attachments() : get_object_taxonomies( $pt );
					if ( in_array( 'category', $object_taxonomies ) && ! in_array( $pt, $post_types ) ) {
						$post_types[] = $pt;
					}
				}
			}
			if ( $post_types ) {
				$wp_query->set( 'post_type', $post_types );
			}
		}
	}
}
add_action( 'pre_get_posts', 'custom_pre_get_posts' );

//スマートフォンを判別
function is_mobile(){
    $useragents = array(
        'iPhone', // iPhone
        // 'iPad',
        'iPod', // iPod touch
        'Android.*Mobile', // 1.5+ Android *** Only mobile
        'Windows.*Phone', // *** Windows Phone
        'dream', // Pre 1.5 Android
        'CUPCAKE', // 1.5+ Android
        'blackberry9500', // Storm
        'blackberry9530', // Storm
        'blackberry9520', // Storm v2
        'blackberry9550', // Storm v2
        'blackberry9800', // Torch
        'webOS', // Palm Pre Experimental
        'incognito', // Other iPhone browser
        'webmate' // Other iPhone browser
 
    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}

function is_ipad(){
    $useragents = array(
        'iPad'
    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}

/* 【管理画面】管理者以外の投稿メニューを非表示 */
if (!current_user_can('administrator')) { // 管理者以外を対象
function remove_menus () {
global $menu;
remove_menu_page('edit.php'); // 投稿を非表示
remove_menu_page('tools.php'); // ツールを非表示
remove_menu_page('edit-comments.php'); // コメントを非表示
remove_menu_page('upload.php');
}
add_action('admin_menu', 'remove_menus');
}




?>
