<?php get_header(); ?>

<section class="ttr-productos">
	<h1>Dealer</h1>
<?php if ( have_posts() ) { ?>
	<?php while ( have_posts() ) { the_post();?>
		<?php the_content(); ?>
	<?php } ?>
<?php } ?>
</section>

<?php get_footer(); ?>
