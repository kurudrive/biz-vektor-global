<?php
/*
 * Template Name: Post top
 */
get_header(); ?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
	<!-- [ #content ] -->
	<div id="content">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>' ) ); ?>
	<?php
	if ( is_user_logged_in() == TRUE ) { ?>
	<div class="adminEdit">
	<span class="linkBtn linkBtnS linkBtnAdmin"><?php edit_post_link(__('Edit', 'biz-vektor')); ?></span>
	</div>
	<?php } ?>
<?php endwhile; ?>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$wp_query = new WP_Query( array( 
	'post_type' => 'post',
	'paged' => $paged
) ); ?>
<?php if(have_posts()): ?>
	<div class="infoList">
	<?php $options = biz_vektor_get_theme_options();
	if ( $options['listBlogArchive'] == 'listType_set' ) { ?>
		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
			<?php get_template_part('module_loop_post2'); ?>
		<?php endwhile; ?>
	<?php } else { ?>
		<ul class="entryList">
		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
			<?php get_template_part('module_loop_post'); ?>
		<?php endwhile; ?>
		</ul>
	<?php } ?>
	</div><!-- [ /.infoList ] -->
	<?php pagination($wp_query->max_num_pages); ?>
	<?php wp_reset_query();?>
<?php endif; // hove_post() ?>

	</div>
	<!-- [ /#content ] -->

<!-- [ #sideTower ] -->
<div id="sideTower">
	<?php get_template_part('module_side_post'); ?>
</div>
<!-- [ /#sideTower ] -->

</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>