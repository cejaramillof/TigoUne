<?php get_header(); ?>


<section class="ttr-productos">
	<h1>Productos Tigo Pospago</h1>
	<?php if ( have_posts() ) { ?>
		<ul>
			<?php while ( have_posts() ) { the_post();?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php } ?>
		</ul>
	<?php } ?>
</section>

<?php get_footer(); ?>
