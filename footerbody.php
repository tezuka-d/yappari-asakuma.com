<?php

global $colnum;
global $blonum;
$pid = "footer";


if( have_rows("param", $pid ) ) {
	while ( have_rows("param", $pid ) ) : the_row();
		$bgcls = get_sub_field("bg");
		$bgimg = get_sub_field("bgimg");
		$bg = "";
		if ( $bgimg != "" ) {
			$bg = ' style="background-image : url(' . $bgimg["url"] . ');"';
		}
		echo '<section class="footerbody PageBody ' . $bgcls . '';
		if ( get_sub_field('bgparallax') ) {
			echo ' bgparallax';
		}
		if ( get_sub_field('bgpattern') ) {
			echo ' bgpattern';
		}
		if(get_sub_field('half_pad')){
			echo ' half_pad';
		}
		$itemtype = get_sub_field("type");
		if ( $itemtype == "アクセス" ) {
			echo ' footer_access';
		}
		echo '"' . $bg . '>';
		if ( get_sub_field('font_color') ) {
			echo '<div class="Inner fclr_white" id="col' . $colnum . '">';
		} else {
			echo '<div class="Inner " id="col' . $colnum . '">';
		}
		$itemtype = get_sub_field("type");
		if ( $itemtype == "アクセス" ) {
			$atype = get_sub_field("atype");
			$title = get_sub_field("title");
			$title2 = get_sub_field("title2");
			$txtArea = get_sub_field("txtArea");
			$tbltype = get_sub_field("tbltype");
			$tbl = get_sub_field("tbl");
			$lat = get_sub_field("lat");
			$lng = get_sub_field("lng");
			$maptype = get_sub_field("maptype");
			$zoom = get_sub_field("zoom");
			op_access($bgcls, $atype, $title, $title2, $txtArea, $tbltype, $tbl, $lat, $lng, $zoom, $colnum, $maptype );
		} else if ( $itemtype == "お問い合わせ" ) {
			$ctype = get_sub_field("ctype");
			$title = get_sub_field("title");
			$title2 = get_sub_field("title2");
			$txtArea = get_sub_field("txtArea");
			$btxt = get_sub_field("btxt");
			$link = getLink( get_sub_field("link"), get_sub_field("url"), get_sub_field("anc") );
			$target = get_sub_field("target");
			if ($ctype == "type1") {
				op_contact1($bgcls, $ctype, $title, $title2, $txtArea, $btxt, $link, $target);
			} else if ($ctype == "type2") {
				op_contact2($bgcls, $ctype, $title, $title2, $txtArea, $btxt, $link, $target);
			}

		} else if ( $itemtype == "フッターバナー" ) {
			$title = get_sub_field("title");
			$title2 = get_sub_field("title2");
			$fbnr = get_sub_field("fbnr");
			op_fbnr($bgcls, $title, $title2, $fbnr);

		} else if ( $itemtype == "グルメサイト" ) {
			$gournavi = get_sub_field("gournavi");
			$tabelog = get_sub_field("tabelog");
			$hotpepper = get_sub_field("hotpepper");
			$hitosara = get_sub_field("hitosara");
			op_gourmet($gournavi, $tabelog, $hotpepper, $hitosara);
		}
		echo '</div>';
		echo '</section>';
		$colnum++;
	endwhile;
}

function op_access($bgcls, $atype, $title, $title2, $txtArea, $tbltype, $tbl, $lat, $lng, $zoom, $colnum, $maptype ) {

	if ($lat != "" && $lng != "") {
		echo '<section class="FooterAccess ' . $atype . '">';

		if ($atype == "type1") {
			op_access_txt($bgcls, $title, $title2, $txtArea, $tbl);
		}

	if ($lat != "" && $lng != "") {
	
		if ($maptype == "白黒") {
			echo '<div class="FooterMap" id="fmap' . $colnum . '"></div>';

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
		div: '#fmap$colnum',
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
			echo '<div class="FooterMap" id="fmap' . $colnum . '"></div>';

print <<< EOMAP
<script>
	var map;
	map = new GMaps({
		div: '#fmap$colnum',
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

		if ($atype == "type2") {
			op_access_txt($bgcls, $title, $title2, $txtArea, $tbl);
		}

		echo '</section>';
	}


}

function op_access_txt($bgcls, $title, $title2, $txtArea, $tbls) {
	// echo '<div class="FooterAccessTxt ' . $bgcls . '">';
	echo '<div class="FooterAccessTxt">';
	echo '<div class="Inner">';
	if ( $title != "" || $title2 != "" ) {
		echo '<h2 class="FooterAccessTitle">';
		if ( $title != "" ) { echo '<span class="large">' . $title . '</span>'; }
		if ( $title2 != "" ) { echo '<span class="small">' . $title2 . '</span>'; }
		echo '</h2>';
	}
	if ($txtArea != "") {
		echo '<div class="FooterAccessBodyTxts">';
		echo $txtArea;
		echo '</div>';
	}
	if ($tbls) {
		echo '<div class="FooterAccessTbl">';
		foreach($tbls as $tbl) {
			echo '<div class="FooterAccessRow">';
			echo '<div class="FooterAccessTh">' . $tbl["th"] . '</div>';
			echo '<div class="FooterAccessTd">' . $tbl["td"] . '</div>';
			echo '</div>';
		}
		echo '</div>';
	}
	echo '</div>';
	echo '</div>';

}

function op_contact1($bgcls, $ctype, $title, $title2, $txtArea, $btxt, $link, $target) {
	echo '<section class="FooterContactA PageBody ' . $bgcls . '">';
	echo '<div class="Inner">';

	if ( $title != "" || $title2 != "" ) {
		echo '<h2 class="PageBodyTitleA">';
		if ( $title != "" ) { echo '<span class="large">' . $title . '</span>'; }
		if ( $title2 != "" ) { echo '<span class="small">' . $title2 . '</span>'; }
		echo '</h2>';
	}
	echo '<div class="PageBodyParam max800">';
	echo '<div class="PageBodyTxts">';
	echo $txtArea;
	if ( $link ) {
		echo '<p class="PageBodyBtn"><a href="' . $link[0] . '" target="' . $target[0] . '">' . $btxt . '</a></p>';
	}
	echo '</div>';
	echo '</div>';

	echo '</div>';
	echo '</section>';
}

function op_contact2($bgcls, $ctype, $title, $title2, $txtArea, $btxt, $link, $target) {
	echo '<section class="FooterContactB PageBody ' . $bgcls . '">';
	echo '<a href="' . $link[0] . '" target="' . $target[0] . '">';
	echo '<div class="Inner">';

	if ( $title != "" || $title2 != "" ) {
		echo '<h2 class="PageBodyTitleA">';
		if ( $title != "" ) { echo '<span class="large">' . $title . '</span>'; }
		if ( $title2 != "" ) { echo '<span class="small">' . $title2 . '</span>'; }
		echo '</h2>';
	}
	echo '<div class="PageBodyParam max800">';
	echo '<div class="PageBodyTxts">';
	echo $txtArea;

	echo '</div>';
	echo '</div>';
	echo '</div>';

	echo '</a>';
	echo '</section>';
}

function op_fbnr($bgcls, $title, $title2, $fbnr) {
	echo '<section class="FooterLink ' . $bgcls . '">';
	echo '<div class="Inner">';
	if ( $title != "" || $title2 != "" ) {
		echo '<h2 class="PageBodyTitleA">';
		if ( $title != "" ) { echo '<span class="large">' . $title . '</span>'; }
		if ( $title2 != "" ) { echo '<span class="small">' . $title2 . '</span>'; }
		echo '</h2>';
	}
	if ($fbnr) {
		echo '<ul class="FooterLinks">';
		foreach($fbnr as $value) {
			if($value["img"]) {
				$link = getLink( $value["link"], $value["url"], $value["anc"] );
				$target = $value["target"];
				echo '<li><a href="' . $link[0] . '" target="' . $target[0] . '"><img src="' . $value["img"]["url"] . '" alt="' . $value["img"]["alt"] . '"></a></li>';
			}
		}
		echo '</ul>';
	}
	echo '</div>';
	echo '</section>';
}

function op_gourmet($gournavi, $tabelog, $hotpepper, $hitosara) {
	echo '<div class="Footergourmet">';
	echo '<ul class="Footergourmet__bnr">';
	if ( $gournavi != "" ) {
		$oc_gnv = "onclick=\"ga('send','pageview','/gnavi');\"";
		echo '<li><a href="' . $gournavi . '" target="_blank" class="gournavi" '.$oc_gnv.'></a></li>';
	} else {}
	if ( $tabelog != "" ) {
		$oc_tblg = "onclick=\"ga('send','pageview','/tabelog');\"";
		echo '<li><a href="' . $tabelog . '" target="_blank" class="tabelog" '.$oc_tblg.'></a></li>';
	} else {}
	if ( $hotpepper != "" ) {
		$on_htpp = "onclick=\"ga('send','pageview','/hotpepper');\"";
		echo '<li><a href="' . $hotpepper . '" target="_blank" class="hotpepper" '.$on_htpp.'></a></li>';
	} else {}
	if ( $hitosara != "" ) {
		$on_htsr = "onclick=\"ga('send','pageview','/hitosara');\"";
		echo '<li><a href="' . $hitosara . '" target="_blank" class="hitosara" '.$on_htsr.'></a></li>';
	} else {}
	echo '</ul>';
	echo '</div>';
}

?>