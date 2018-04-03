<?php get_header(); ?>


<?php
$current_user = wp_get_current_user();

$user_channel = get_user_meta( $user_ID, 'ttr_channel', true );
$channel      = get_category_by_slug( $user_channel );
?>

<div id="ttr-slider-wrap">
	<?php echo do_shortcode( '[metaslider id=85]' ); ?>
</div>

<div id="ttr-content-wrap">
	<p class="welcome-msg">Hola <strong><?php echo $current_user->display_name; ?></strong>, bienvenido al canal <?php echo $channel->name; ?>. Disfruta de la nueva y mejorada navegaci&oacute;n.</p>

	<div class="tabs">

		<ul class="tab-links">
			<li class="active"><a href="#tab2">Pospago</a></li>
			<li><a href="#tab1">Prepago</a></li>
			<li><a href="#tab3">Recursos</a></li>
		</ul>

		<div class="tab-content">
			<div id="tab1" class="tab">
				<?php

				$args = array(
					'category__and' => array( 5, $channel->term_id ),
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

			<div id="tab2" class="tab active">
				<?php

				$args = array(
					'category__and' => array( 4, $channel->term_id ),
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

			<div id="tab3" class="tab">
				<?php

				$args = array(
					'category__and' => array( 38, $channel->term_id ),
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

