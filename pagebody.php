<?php

global $colnum;
global $blonum;
if (is_home() ) {
	$pid = "toppage";
	$ph1 = "h2";
} else {
	$pid = $post->ID;
	$ph1 = "h1";
}

if( have_rows("param", $pid ) ) {
	while ( have_rows("param", $pid ) ) : the_row();
		$bgcls = get_sub_field("bg");
		$bgimg = get_sub_field("bgimg");
		$title = get_sub_field("title");
		$title2 = get_sub_field("title2");
		$bg = "";
		if ( $bgimg != "" ) {
			$bg = ' style="background-image : url(' . $bgimg["url"] . ');"';
		}
		echo '<section class="PageBody ' . $bgcls . '';
		if (! is_front_page() ) {
			echo ' pagebody_php';
		}
		if ( get_sub_field('bgparallax') && ! is_ipad()) {
			echo ' bgparallax';
		}
		if ( get_sub_field('bgpattern') ) {
			echo ' bgpattern';
		}
		if( have_rows("items") ) {
			while ( have_rows("items") ) : the_row();
				$itemtype = get_sub_field("type");
				if ( $itemtype == "ニュース一覧" ) {
					echo ' news_section';
				}
			endwhile;
		}
		echo '"' . $bg . '>';
		if ( get_sub_field('font_color') ) {
			echo '<div class="Inner fclr_white" id="col' . $colnum . '">';
		} else {
			echo '<div class="Inner " id="col' . $colnum . '">';
		}

		if ( $title != "" || $title2 != "" ) {
			echo '<' . $ph1 . ' class="PageBodyTitleA">';
			if ( $title != "" ) { echo '<span class="large">' . $title . '</span>'; }
			if ( $title2 != "" ) { echo '<span class="small">' . $title2 . '</span>'; }
			echo '</' . $ph1 . '>';
			$ph1 = "h2";
		}

		if( have_rows("items") ) {
			while ( have_rows("items") ) : the_row();
				$itemtype = get_sub_field("type");
				if ( $itemtype == "テキスト＋画像" ) {
					$type_width =  get_sub_field("type_width");
					$txt_type =  get_sub_field("txt_type");
					$ttle =  get_sub_field("title");
					$txtArea =  get_sub_field("txtArea");
					$imgArea = get_sub_field("imgArea");
					$btn = get_sub_field("btn");
					op_txts($type_width, $txt_type, $ttle, $txtArea, $imgArea, $btn);
				} else if ( $itemtype == "ギャラリー" ) {
					$imgArea = get_sub_field("imgArea");
					$btn = get_sub_field("btn");
					op_gallery($imgArea, $blonum, $btn);
				} else if ( $itemtype == "テーブル" ) {
					$type_width =  get_sub_field("type_width");
					$tbltype = get_sub_field("tbltype");
					$tbl = get_sub_field("tbl");
					$btn = get_sub_field("btn");
					op_tbl($type_width, $tbltype, $tbl, $btn);
				} else if ( $itemtype == "地図" ) {
					$type_width =  get_sub_field("type_width");
					$lat = get_sub_field("lat");
					$lng = get_sub_field("lng");
					$zoom = get_sub_field("zoom");
					$maptype = get_sub_field("maptype");
					op_map($type_width, $lat, $lng, $zoom, $blonum, $maptype, $btn);
				} else if ( $itemtype == "ニュース一覧" ) {
					$post_type = get_sub_field("post_type");
					$disp_num = get_sub_field("disp_num");
					//$disp_type = get_sub_field("disp_type");
					$btn = get_sub_field("btn");
					op_news($post_type, $disp_num, $btn);
				} else if ( $itemtype == "ブログ一覧" ) {
					$post_type = get_sub_field("post_type");
					$disp_num = get_sub_field("disp_num");
					$disp_type = get_sub_field("disp_type");
					$btn = get_sub_field("btn");
					op_blogs($post_type, $disp_num, $disp_type, $btn);
				} else if ( $itemtype == "ページリンク" ) {
					$disp_type = get_sub_field("disp_type");
					$lset = get_sub_field("lset");
					$btn = get_sub_field("btn");
					op_linkset($disp_type, $lset, $btn);
				} else if ( $itemtype == "WYSIWYG" ) {
					$wysiwyg = get_sub_field("wysiwyg");
					op_wysiwyg($wysiwyg);
				} else if ( $itemtype == "コンタクトフォーム" ) {
					$type_width =  get_sub_field("type_width");
					$wysiwyg = get_sub_field("wysiwyg");
					op_frm($type_width, $wysiwyg);
				} else if ( $itemtype == "商品メニュー" ) {
					$menu_ttle =  get_sub_field("menu_title");
					$menu_type = get_sub_field("menu_type");
					$product_set = get_sub_field("product_set");
					$menu_txtArea =  get_sub_field("menu_txtArea");
					op_product($menu_ttle, $menu_type, $product_set, $menu_txtArea);
				}
				$blonum++;
			endwhile;
		}

		echo '</div>';
		echo '</section>';
		$colnum++;
	endwhile;
 }
 
 
function op_txts($type_width, $txt_type, $ttle, $txtArea, $imgArea, $btn) {

	echo '<div class="PageBodyParam clearfix ' . $txt_type . ' ' . $type_width . '">';

	if ($txt_type == "imgBottom") {
		echo '<div class="PageBodyTxts">';
		if ($ttle != "") {
			echo '<h3 class="PageBodyTitleB">' . $ttle . '</h3>';
		}
		echo $txtArea;
		if ( $btn ) {
			$link = getLink($btn[0]["link"], $btn[0]["url"], $btn[0]["anc"] );
			$target = $btn[0]["target"];
			if ($link[0] != "") {
				echo '<p class="PageBodyBtn"><a href="' . $link[0] . '" target="' . $target[0] . '">' . $btn[0]["txt"] . '</a></p>';
			}
		}

		echo '</div>';
	}

	if ($imgArea) {
		if ( get_sub_field('Img_flex') ) {
			echo '<div class="PageBodyImgs flex">';
		} else {
			echo '<div class="PageBodyImgs">';
		}
		foreach($imgArea as $img) {
			$link = getLink(get_field('link', $img["id"]), get_field('url', $img["id"]), "" );
			$target = get_field('target', $img["id"]);
			echo '<p>';
			if ($link[0] != "") {
				echo '<a href="' . $link[0] . '" target="' . $target[0] . '">';
			}
			echo '<img src="' . $img["url"] . '" alt="' . $img["alt"] . '">';
			if ($link[0] != "") {
				echo '</a>';
			}
			echo '</p>';
		}
		echo '</div>';
	}

	if ($txt_type != "imgBottom") {
		echo '<div class="PageBodyTxts">';
		if ($ttle != "") {
			echo '<h3 class="PageBodyTitleB">' . $ttle . '</h3>';
		}
		echo $txtArea;
		if ( $btn ) {
			$link = getLink($btn[0]["link"], $btn[0]["url"], $btn[0]["anc"] );
			$target = $btn[0]["target"];
			if ($link[0] != "") {
				echo '<p class="PageBodyBtn"><a href="' . $link[0] . '" target="' . $target[0] . '">' . $btn[0]["txt"] . '</a></p>';
			}
		}

		echo '</div>';
	}


	echo '</div>';
}

function op_gallery($imgs, $count, $btn) {
	if ($imgs) {

	echo '<div class="PageBodyGallery';
	if ( is_mobile() ) {
		echo ' mobile';
	}
	echo '" id="Gallery' . $count . '">';
	foreach($imgs as $img) {
		$link = getLink(get_field('link', $img["id"]), get_field('url', $img["id"]), "" );
		echo '<div class="PageBodyGalleryInner">';
		if ($link[0] != "") {
			echo '<a href="' . $link[0] . '" target="' . $target[0] . '">';
		}
		echo '<p class="PageBodyGalleryImgs"><img src="' . $img["url"] . '" alt="' . $img["alt"] . '"></p>';
		// if( $img["title"] != "" ) {
		// 	echo '<p class="PageBodyGalleryTitle">' . $img["title"] . '</p>';
		// }
		if( $img["caption"] != "" ) {
			echo '<p class="PageBodyGalleryTxt">' . $img["caption"] . '</p>';
		}
		if ($link[0] != "") {
			echo '</a>';
		}
		echo '</div>';
	}
	echo '</div>';
if (! is_mobile() ) {
print <<< EOM
<script>
$(function() {
	$("#Gallery$count").slick({
		autoplay : false,
		autoplaySpeed: 5000,
		dots: false,
		arrows : true,
		prevArrow : '<button type="button" class="slick-prev">&#xf104;</button>',
		nextArrow : '<button type="button" class="slick-next">&#xf105;</button>',
		infinite: true,
		speed: 300,
		centerMode: true,
		centerPadding : '-60px',
		adaptiveHeight: false
	});
});
</script>
EOM;
} else {
print <<< EOM
<script>
$(function() {
	$("#Gallery$count").slick({
		autoplay : false,
		autoplaySpeed: 5000,
		dots: false,
		arrows : true,
		prevArrow : '<button type="button" class="slick-prev sp">&#xf104;</button>',
		nextArrow : '<button type="button" class="slick-next">&#xf105;</button>',
		infinite: true,
		speed: 300,
		slidesToShow: 1,
		centerMode: true,
		centerPadding : 0,
		adaptiveHeight: false
	});
});
</script>
EOM;
}

	}

	if ( $btn ) {
		$link = getLink($btn[0]["link"], $btn[0]["url"], $btn[0]["anc"] );
		$target = $btn[0]["target"];
		if ($link[0] != "") {
			echo '<p class="PageBodyBtn"><a href="' . $link[0] . '" target="' . $target[0] . '">' . $btn[0]["txt"] . '</a></p>';
		}
	}

}

function op_tbl($type_width, $type, $tbls, $btn) {
	if ($tbls) {
		echo '<div class="PageBodyTable ' . $type . ' ' . $type_width . '">';
		echo '<div class="PageBodyTableInner">';
		foreach($tbls as $tbl) {
			echo '<div class="PageBodyRow">';
			echo '<div class="PageBodyTh">' . $tbl["th"] . '</div>';
			echo '<div class="PageBodyTd">' . $tbl["td"] . '</div>';
			echo '</div>';
		}
		echo '</div>';
		echo '</div>';
	}

	if ( $btn ) {
		$link = getLink($btn[0]["link"], $btn[0]["url"], $btn[0]["anc"] );
		$target = $btn[0]["target"];
		if ($link[0] != "") {
			echo '<p class="PageBodyBtn"><a href="' . $link[0] . '" target="' . $target[0] . '">' . $btn[0]["txt"] . '</a></p>';
		}
	}

}

function op_map($type_width, $lat, $lng, $zoom, $count, $maptype, $btn) {
	if ($lat != "" && $lng != "") {
		echo '<div class="PageBodyMap ' . $type_width . '">';
		echo '<div class="PageBodyMapInner" id="map' . $count . '"></div>';
		echo '</div>';

if ($maptype == "白黒") {
print <<< EOMAP
<script>
	var map;
	var mapstyle = [
		{
			"stylers": [
				{ "saturation": -100 }
			]
		}
	];
	map = new GMaps({
		div: '#map$count',
		lat: $lat,
		lng: $lng,
		zoom:$zoom,
		disableDefaultUI: true,
		scrollwheel: false,
		styles : mapstyle
	});

	map.addMarker({
		lat: $lat,
		lng: $lng	});
</script>
EOMAP;
} else {
print <<< EOMAP
<script>
	var map;
	map = new GMaps({
		div: '#map$count',
		lat: $lat,
		lng: $lng,
		zoom:$zoom,
		disableDefaultUI: true,
		scrollwheel: false,
	});

	map.addMarker({
		lat: $lat,
		lng: $lng	});
</script>
EOMAP;
}
	}

	if ( $btn ) {
		$link = getLink($btn[0]["link"], $btn[0]["url"], $btn[0]["anc"] );
		$target = $btn[0]["target"];
		if ($link[0] != "") {
			echo '<p class="PageBodyBtn"><a href="' . $link[0] . '" target="' . $target[0] . '">' . $btn[0]["txt"] . '</a></p>';
		}
	}

}


function op_news($post_type, $disp_num, $btn) {

	if ($post_type != "") {
		$postlist = get_posts( array(
			'posts_per_page' => $disp_num,
			'offset' => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type' => $post_type
		));
	}

	//print_r($postlist);

	echo '<div class="NewsArea">';

	if($postlist) {
		echo '<ul class="NewsList">';
		foreach($postlist as $post) {
			$title = $post->post_title;
			$link = get_permalink($post->ID);
			$date = get_the_time('Y.m.d', $post->ID);
			$newmark = get_field("newmark", $post->ID);
			echo '<li>';
			if (! is_mobile()) {
				if ($newmark != "") {
					echo '<span class="NewsListNew">NEW</span>';
				}
				echo '<span class="NewsListDate">' . $date . '</span>';
			} else {
				echo '<div class="NewsList__sp_date">';
				if ($newmark != "") {
					echo '<span class="NewsListNew">NEW</span>';
					echo '<span class="NewsListDate">' . $date . '</span>';
				} else {
					echo '<span class="NewsListDate">' . $date . '</span>';
				}
				echo '</div>';
			}
			echo '<span class="NewsListTitle"><a href="' . $link . '">' . $title . '</a></p>';
			echo '</li>';
		}
		echo '</ul>';
	}


	if ( $btn ) {
		$link = getLink($btn[0]["link"], $btn[0]["url"], $btn[0]["anc"] );
		$target = $btn[0]["target"];
		if ($link[0] != "") {
			echo '<div class="NewsAreaMore"><a href="' . $link[0] . '" target="' . $target[0] . '"><span>' . $btn[0]["txt"] . '</span></a></div>';
		}
	}
	
	echo '</div>';

}


function op_blogs($post_type, $disp_num, $disp_type, $btn) {

	$no_img = get_field("no_img", "options");

	if ($post_type != "") {
		$postlist = get_posts( array(
			'posts_per_page' => $disp_num,
			'offset' => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type' => $post_type
		));
	}

	//print_r($postlist);


	if($postlist) {
		echo '<ul class="BlogList ' . $disp_type . '">';
		foreach($postlist as $post) {
			$title = $post->post_title;
			$link = get_permalink($post->ID);
			$thumb = get_field("thumb", $post->ID);
			if (!$thumb) { $thumb = $no_img; }

			echo '<li>';
			echo '<a href="' . $link . '">';
			echo '<p class="BlogListThumb"><img src="' . $thumb["url"] , '" alt="' . $title . '"></p>';
			echo '<p class="BlogListTxt">' . $title . '</p>';
			echo '</a>';
			echo '</li>';
		}
		echo '</ul>';
	}

	if ( $btn ) {
		$link = getLink($btn[0]["link"], $btn[0]["url"], $btn[0]["anc"] );
		$target = $btn[0]["target"];
		if ($link[0] != "") {
			echo '<p class="PageBodyBtn"><a href="' . $link[0] . '" target="' . $target[0] . '">' . $btn[0]["txt"] . '</a></p>';
		}
	}

}

function op_linkset($disp_type, $lset, $btn) {

	if($lset) {
		echo '<ul class="LinkList ' . $disp_type . '">';
		foreach($lset as $post) {
			$title = $post["txt"];
			$link = getLink($post["link"], $post["url"], $post["anc"] );
			$target = $post["target"];
			$thumb = $post["img"];

			echo '<li>';
			echo '<a href="' . $link[0] . '" target="' . $target[0] . '">';
			echo '<p class="LinkListThumb"><img src="' . $thumb["url"] , '" alt="' . $title . '"></p>';
			echo '<p class="LinkListTxt"><span>' . $title . '</span></p>';
			echo '</a>';
			echo '</li>';
		}
		echo '</ul>';
	}

	if ( $btn ) {
		$link = getLink($btn[0]["link"], $btn[0]["url"], $btn[0]["anc"] );
		$target = $btn[0]["target"];
		if ($link[0] != "") {
			echo '<p class="PageBodyBtn"><a href="' . $link[0] . '" target="' . $target[0] . '">' . $btn[0]["txt"] . '</a></p>';
		}
	}

}

function op_wysiwyg($wysiwyg) {
	if ($wysiwyg) {
		echo $wysiwyg;
	}
}

function op_frm($type_width, $wysiwyg) {
	if ($wysiwyg) {
		echo '<div class="PageBodyContact ' . $type_width . '">';
		echo $wysiwyg;
		echo '</div>';
	}
}

function op_product($menu_ttle, $menu_type, $product_set, $menu_txtArea) {
	if ($product_set || $menu_txtArea) {
		echo '<div class="menu_field">';
		if ($menu_ttle != "") {
			echo '<h3 class="MenuTitleB">' . $menu_ttle . '</h3>';
		}
		if($product_set) {
			echo '<ul class="product ' . $menu_type . '">';
			if ( $menu_type == "img_menu") {
				foreach($product_set as $set) {
					$name = $set["name"];
					$img = $set["img"];
					$txt = $set["txt"];
					$type = $set["type"];
					$price = $set["price"];

					echo '<li>';
					if ($img !="") {
						echo '<div class="product__img"><img src="'. $img .'"></div>';
					}
					if ($name !="") {
						echo '<p class="product__name">' . $name . '</p>';
					}
					if ($txt !="") {
						echo '<p class="product__txt">' . $txt . '</p>';
					}
					if ($type !="") {
						echo '<p class="product__type">' . $type . '</p>';
					}
					if ($price !="") {
						echo '<p class="product__price">&#xFFE5;' . $price . '<span>（税別）</span></p>';
					}
					echo '</li>';
				}
			} else if ( $menu_type == "txt_menu" ) {
				foreach($product_set as $set) {
					$name = $set["name"];
					$type = $set["type"];
					$price = $set["price"];

					echo '<li>';
					echo '<p class="product__name">' . $name . '</p>';
					if ($type !="") {
						echo '<p class="product__type">' . $type . '</p>';
					}
					echo '<p class="product__price">&#xFFE5;' . $price . '<span>（税別）</span></p>';
					echo '</li>';
				}
			}
			echo '</ul>';
		}
		if($menu_txtArea) {
			foreach($menu_txtArea as $menu_tA) {
				$edit = $menu_tA["menu_edi"];
				echo '<div class="menu_txtArea">' . $edit . '</div>';
			}
		}
		echo '</div>';
	}
}

?>