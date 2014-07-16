<?php
/*-------------------------------------------*/
/*	パンくずリスト
/*-------------------------------------------*/
global $wp_query;
// カスタム投稿タイプの種類を取得
$postType = get_post_type();
// カスタム投稿タイプ名を取得
if(isset($postType->labels->name)){
	$postTypeName = esc_html(get_post_type_object($postType->labels->name));
}

// 標準のpost のラベル名
$postLabelName = bizVektorOptions('postLabelName');
if ( !is_front_page() ):
	echo '<ul>';
	echo '<li id="panHome"><a href="'. home_url() .'">HOME</a> &raquo; </li>';
endif;

// ▼
if ( is_404() ){
	echo "<li>".__('Not found', 'biz-vektor')."</li>";
} else if ( is_search() ) {
	echo "<li>".sprintf(__('Search Results for : %s', 'biz-vektor'),get_search_query())."</li>";
// ▼▼ 投稿ページをブログに指定された場合
} else if ( is_home() ){
	echo '<li>'.$postLabelName.'</li>';
// ▼▼ 固定ページ
} elseif ( is_page() ) {
	$post = $wp_query->get_queried_object();
	if ( $post->post_parent == 0 ){
		echo "<li>".the_title('','', FALSE)."</li>";
	} else {
		$title = the_title('','', FALSE);
		$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
		array_push($ancestors, $post->ID);
		foreach ( $ancestors as $ancestor ){
			if( $ancestor != end($ancestors) ){
				echo '<li><a href="'. get_permalink($ancestor) .'">'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</a> &raquo; </li>';
			} else {
				echo '<li>'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</li>';
			}
		}
	}

// ▼▼ 投稿者ページ
} else if (is_author()) {
	$userObj = get_queried_object();
	echo '<li>'.esc_html($userObj->display_name).'</li>';

// ▼▼ 投稿記事ページ
} elseif ( is_single() ) {
	// 投稿の場合
	if ($postType == 'post') {
		echo '<li>'.$postLabelName.' &raquo; </li>';
		$category = get_the_category();
		$category_id = get_cat_ID( $category[0]->cat_name );
		if ($category_id) :  // カスタム投稿タイプを追加した場合にカテゴリー指定が無い場合の為
			echo '<li>'. get_category_parents( $category_id, TRUE, ' &raquo; ' ).'</li>';
		endif;
	// カスタム投稿タイプのsingleページの場合
	} else {
		echo '<li><a href="'.home_url().'/'.$postType.'">'.$postTypeName.'</a> &raquo; </li>';
		$taxonomies = get_the_taxonomies();
		// 複数のタクソノミーを跨ぐ事が無い前提なので、forechじゃなくても良いはず...
		foreach ( $taxonomies as $taxonomySlug => $taxonomy ) {}
		if ($taxonomies):
			$taxo_catelist = get_the_term_list( $post->ID, $taxonomySlug, '', ' , ', '' );
			echo '<li>'.$taxo_catelist.' &raquo; </li>';
		endif;
	}
	echo '<li>'.get_the_title()."</li>";

// ▼▼ タクソノミー
} else if (is_tax()) { // 階層構造を反映しないので要検討
	// 標準の投稿タイプ(post)の場合は、管理画面で設定した名前を取得
	if ( $postType == 'post') {
		$postTypeName = esc_html(bizVektorOptions('postLabelName'));
		echo '<li>'.$postTypeName.' &raquo; </li>';
	// 標準の投稿タイプでない場合は、カスタム投稿タイプ名を取得
	} else {
		if (get_post_type()) {
			$postTypeSlug = get_post_type();
		} else {
			// カテゴリーに記事が一件も無いとget_post_typeで投稿タイプが取得出来ないため
			$taxonomy = get_queried_object()->taxonomy;
			$postTypeSlug = get_taxonomy( $taxonomy )->object_type[0];
		}
		$postTypeName = get_post_type_object($postTypeSlug)->labels->name;
		echo '<li><a href="'.home_url().'/'.$postType.'">'.$postTypeName.'</a> &raquo; </li>';
	}
	echo '<li>'.single_cat_title('','', FALSE).'</li>';
// ▼▼ カテゴリー
} else if ( is_category() ) {
	echo '<li>'.$postLabelName.' &raquo; </li>';
	// カテゴリー情報を取得して$catに格納
	$cat = get_queried_object();
	// parent が 0 の場合 = 親カテゴリーが存在する場合
	if($cat -> parent != 0):
		// 祖先のカテゴリー情報を逆順で取得
		$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
		// 祖先階層の配列回数分ループ
		foreach($ancestors as $ancestor):
			echo '<li><a href="'.get_category_link($ancestor).'">'.get_cat_name($ancestor).'</a> &raquo; </li>';
		endforeach;
	endif;
	echo '<li>'. $cat -> cat_name. '</li>';	
// ▼▼ タグ
} elseif ( is_tag() ) {
	// 投稿の場合
	if ($postType == 'post') {
		echo '<li>'.$postLabelName.' &raquo; </li>';
	// カスタム投稿タイプの場合
	} else {
		echo '<li>'.$postTypeName.' &raquo; </li>';
	}
	$tagTitle = single_tag_title( "", false );
	echo "<li>". $tagTitle ."</li>";
// ▼▼ アーカイブ
} elseif ( is_archive() && (!is_category() || !is_tax()) ) {

	if (is_year() || is_month()){
		// 投稿の場合
		if ($postType == 'post') {
			echo '<li>'.$postLabelName.' &raquo; </li>';
		// カスタム投稿タイプの場合
		} else {
			echo '<li><a href="'.home_url().'/'.$postType.'">'.$postTypeName.'</a> &raquo; </li>';
		}
		if (is_year()){
			echo "<li>".sprintf( __( 'Yearly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'Y', 'yearly archives date format', 'biz-vektor' ) ) )."</li>";
		} else if (is_month()){
			echo "<li>".sprintf( __( 'Monthly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'biz-vektor' ) ) )."</li>";
		}
	} else {
		echo '<li>'.$postTypeName.'</li>';
	}

} elseif ( is_attachment() ) {
	echo '<li>'.the_title('','', FALSE).'</li>';
}
if ( !is_front_page() ):
	echo "</ul>";
endif;
wp_reset_query();
