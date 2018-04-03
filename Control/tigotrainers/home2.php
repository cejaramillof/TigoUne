<?php get_header(); ?>


<?php
$current_user = wp_get_current_user();

$user_channel = get_user_meta( $user_ID, 'ttr_channel', true );
$channel      = get_category_by_slug( $user_channel );
?>


<div id="ttr-content-wrap">
	<p class="welcome-msg">¡Hola <strong><?php echo $current_user->display_name; ?>!</strong></p>

	<div class="tabs">

		<ul class="tab-links">
			<li class="active"><a href="#tab1">Recursos</a></li>
		</ul>

		<div class="tab-content">
			<div id="tab1" class="tab active"">
				<?php

				$args = array(
					'cat' => array( 2),
					'post_type'     => array( 'post', 'page' )
				);

				$query1 = new WP_Query( $args ); ?>
				<?php if ( $query1->have_posts() ) { ?>
					<ul class="ttt-home-list-articles">
						<?php while ( $query1->have_posts() ) {
							$query1->the_post(); ?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
						<?php } ?>
					</ul>
				<?php } ?>

			</div>
			<?php wp_reset_query(); ?>
			
		</div>
	</div>

</div>

<?php get_footer(); ?>

