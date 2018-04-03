<?php get_header(); ?>
<div class="accesory-wrapper">
	<div class="accesory-single">
<?php
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		?>
		<h1><?php the_title(); ?></h1>
		<div class="accesory-image">
			<?php the_post_thumbnail(); ?>
		</div>
		<div class="accesory-content">
			<?php the_content(); ?>
		</div>
		<?php
		//
		// Post Content here
		//
	} // end while
} // end if
?>
	</div>
</div>
<?php get_footer() ?>