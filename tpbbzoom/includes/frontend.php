<?php
$src    = $module->get_src();
$alt    = $module->get_alt();
$attrs  = $module->get_attributes();
?>

<div class="zoom">
	<img class="zoom-photo-img" src="<?php echo esc_attr( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" itemprop="image" <?php echo esc_attr( $attrs ); ?> />
</div>

<script>
	jQuery( document ).ready(function($) {

		$('.zoom').zoom({
			<?php if( $settings->touch == 1 ): ?>
				touch: true,
			<?php endif; ?>
			<?php if( $settings->magnify ): ?>
				magnify: <?php echo esc_js( $settings->magnify ); ?>,
			<?php endif; ?>
			url: '<?php echo esc_js(  wp_get_attachment_url( $settings->photo ) ); ?>'
		});

	});
</script>