<?php

/*-------------------------------------------*/
/*	Judge calmly
/*-------------------------------------------*/
/*
/*-------------------------------------------*/
/*	Get 'calmly' options
/*-------------------------------------------*/
/*	Variable settings
/*-------------------------------------------*/
/*	Setting customizer
/*-------------------------------------------*/
/*	Admin page _ Add link bottom of pulldown
/*-------------------------------------------*/
/*	Print head
/*-------------------------------------------*/


/*-------------------------------------------*/
/*	Judge calmly
/*-------------------------------------------*/
function is_calmly(){
	if (function_exists('biz_vektor_theme_styleSetting')) {
		$options = biz_vektor_get_theme_options();
		$calmlyLabels = array('calmly','calmlyBrace','calmlyFlat','calmlyBraceFlat');
		$calmlyLabels = apply_filters( 'addCalmlyLabels',$calmlyLabels );
		foreach ($calmlyLabels as $themeLabel) {
			if ($options['theme_style'] == $themeLabel):
				return true;
				break;
			endif;
		}
	}
}

/*-------------------------------------------*/
/*
/*-------------------------------------------*/
add_action( 'admin_init', 'biz_vektor_theme_options_calmly_init' );
function biz_vektor_theme_options_calmly_init() {
	if (is_calmly()){
		if ( false === biz_vektor_get_theme_options_calmly() )
			add_option( 'biz_vektor_theme_options_calmly' );
			register_setting(
				'biz_vektor_options_calmly',
				'biz_vektor_theme_options_calmly',
				'biz_vektor_theme_options_calmly_validate'
			);
		}
}
/*-------------------------------------------*/
/*	Get 'calmly' options
/*-------------------------------------------*/
function biz_vektor_get_theme_options_calmly() {
	return get_option( 'biz_vektor_theme_options_calmly' );
}

/*-------------------------------------------*/
/*	Variable settings
/*-------------------------------------------*/
function biz_vektor_theme_options_calmly_validate( $input ) {
	$output = $defaults;
	$output['theme_plusKeyColor'] = $input['theme_plusKeyColor'];
	$output['theme_plusKeyColorLight'] = $input['theme_plusKeyColorLight'];
	$output['theme_plusKeyColorVeryLight'] = $input['theme_plusKeyColorVeryLight'];
	$output['theme_plusKeyColorDark'] = $input['theme_plusKeyColorDark'];
	return apply_filters( 'biz_vektor_theme_options_calmly_validate', $output, $input, $defaults );
}

/*-------------------------------------------*/
/*	Setting customizer
/*-------------------------------------------*/
add_action( 'customize_register', 'bizvektor_calmly_customize_register' );
function bizvektor_calmly_customize_register($wp_customize) {
	if (is_calmly()){
    // Add section
    $wp_customize->add_section( 'biz_vektor_calmly', array(
        'title'          => __('Calmly Setting', 'biz-vektor'),
        'priority'       => 110,
    ) );

	$wp_customize->add_setting( 'biz_vektor_theme_options_calmly[theme_plusKeyColor]',	array(
		'default'			=> '',
		'type'				=> 'option',
		'capability'		=> 'edit_theme_options',
		'capability'		=> 'edit_theme_options',
		'sanitize_callback'	=> 'bizvektor_customize_sanitize_color',
		) );
	// Create section UI
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'keyColor', array(
		'label'    => _x('Keycolor', 'Calmly color settings', 'biz-vektor'),
		'section'  => 'biz_vektor_calmly',
		'settings' => 'biz_vektor_theme_options_calmly[theme_plusKeyColor]',
	)));
	}
}

/*-------------------------------------------*/
/*	Admin page _ Add link bottom of pulldown
/*-------------------------------------------*/
add_filter('themePlusSettingNavi','themePlusSettingNaviCalmly');
function themePlusSettingNaviCalmly(){
	global $themePlusSettingNavi;
	if (is_calmly()){
		$themePlusSettingNavi = '<p>[ <a href="'.get_admin_url().'customize.php">&raquo; '.__('Set the color from theme customizer', 'biz-vektor').'</a> ]</p>';
	}
	return $themePlusSettingNavi;
}


/*-------------------------------------------*/
/*	Print head
/*-------------------------------------------*/
add_action( 'wp_head','calmlyWpHead', 150);
function calmlyWpHead(){
	if (is_calmly()){
	$calmlyOptions = biz_vektor_get_theme_options_calmly();
		if ( $calmlyOptions ) : ?>
		<style type="text/css">
/* FontNormal */
a,
a:hover,
a:active,
#header #headContact #headContactTel,
#gMenu .menu li a span,
#content h4,
#content h5,
#content dt,
#content .child_page_block h4 a:hover,
#content .child_page_block p a:hover,
.paging span,
.paging a,
#content .infoList ul li .infoTxt a:hover,
#content .infoList .infoListBox div.entryTxtBox h4.entryTitle a,
#footerSiteMap .menu a:hover,
#topPr h3 a:hover,
#topPr .topPrDescription a:hover,
#content ul.linkList li a:hover,
#content .childPageBox ul li.current_page_item a,
#content .childPageBox ul li.current_page_item ul li a:hover,
#content .childPageBox ul li a:hover,
#content .childPageBox ul li.current_page_item a	{ color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>;}

/* bg */
::selection			{ background-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>;}
::-moz-selection	{ background-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>;}
/* bg */
#gMenu .assistive-text,
#content .mainFootContact .mainFootBt a,
.paging span.current,
.paging a:hover,
#content .infoList .infoCate a:hover,
#sideTower li.sideBnr#sideContact a,
form#searchform input#searchsubmit,
#pagetop a:hover,
a.btn,
.linkBtn a,
input[type=button],
input[type=submit]	{ background-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>;}

/* border */
#searchform input[type=submit],
p.form-submit input[type=submit],
form#searchform input#searchsubmit,
#content form input.wpcf7-submit,
#confirm-button input,
a.btn,
.linkBtn a,
input[type=button],
input[type=submit],
.moreLink a,
#headerTop,
#content h3,
#content .child_page_block h4 a,
.paging span,
.paging a,
form#searchform input#searchsubmit	{ border-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>;}

#gMenu	{ border-top-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>;}
#content h2,
#content h1.contentTitle,
#content h1.entryPostTitle,
#sideTower .localHead,
#topPr h3 a	{ border-bottom-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>; }

@media (min-width: 770px) {
#gMenu { border-top-color:#eeeeee;}
#gMenu	{ border-bottom-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>; }
#footMenu .menu li a:hover	{ color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>; }
}
		</style>
<!--[if lte IE 8]>
<style type="text/css">
#gMenu	{ border-bottom-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>; }
#footMenu .menu li a:hover	{ color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>; }
</style>
<![endif]-->
<?php endif; // if ( $calmlyOptions )
	}
}