<?php 
   global $compset; 
   $set_id = uniqid();
   $widget = $compset->source->original['widget'];
   $post_id = $compset->source->original['post_id'];
?>

<?php if ( $compset->meets_min_num_product_requirement() || dfrcs_can_manage_compset() ) : ?>

    <h2><?php echo dfrcs_title(); ?></h2>

    <ul class="dfrcs_compset <?php echo 'set-' . $set_id; ?>">
		<?php if ( $dfrcs_products = dfrcs_products() ) : global $dfrcs_product;

        foreach ( $dfrcs_products as $key => $value ) {
            if ( isset( $value['_removed'] ) && $value['_removed'] == '1' ) {
                unset( $dfrcs_products[$key] );
            }
        }

         $dfrcs_products = array_slice( $dfrcs_products, 0, 15 );
         foreach ( $dfrcs_products as $index => $product ) {
            if ( $dfrcs_products[$index]['finalprice'] < 90 ) {
               unset( $dfrcs_products[$index] );
            }
         }
         $dfrcs_products = array_slice( $dfrcs_products, 0, 5 );

			foreach ( $dfrcs_products as $dfrcs_product ) : ?>
                <li class="<?php echo dfrcs_row_class(); ?>">
                    <a target="_blank" href="<?php echo dfrcs_url(); ?>" rel="nofollow">
                        <div class="item">
							<?php if ( dfrcs_display_image() ) : ?>
                                <div class="dfrcs_image"><?php echo dfrcs_image(); ?></div>
							<?php endif; ?>
							<?php if ( dfrcs_display_logo() ) : ?>
                                <div class="dfrcs_logo"><?php echo dfrcs_logo(); ?></div>
							<?php endif; ?>
							<?php if ( dfrcs_display_price() ) : ?>
                                <div class="dfrcs_price"><?php echo dfrcs_price(); ?></div>
							<?php endif; ?>
							<?php if ( dfrcs_display_button() ) : ?>
                                <div class="dfrcs_link">
                                    <span class="dfrcs_action"><?php echo dfrcs_link_text(); ?></span>
                                </div>
							<?php endif; ?>
                        </div>
						<?php if ( dfrcs_display_promo() ) : ?>
							<?php echo dfrcs_promo(); ?>
						<?php endif; ?>
                    </a>
					<?php echo dfrcs_product_actions(); ?>
					<?php echo dfrcs_product_debug(); ?>
                </li>
			<?php endforeach; endif; ?>
    </ul>

<?php else : ?>

	<?php $no_results_message = dfrcs_no_results_message(); ?>
	<?php if ( ! empty( $no_results_message ) ) : ?>
        <div class="dfrcs_no_results_message"><?php echo $no_results_message; ?></div>
	<?php endif; ?>

<?php endif; ?>
<?php
    if ( ! $dfrcs_products ) return;
    $key = array_key_first( $dfrcs_products );
    $price = number_format( ( $dfrcs_products[$key]['finalprice'] / 100 ), 2, ',', '.' );
    $date = $compset->date_updated;
    foreach ( $widget as $item_id => $widget_id ) {
        update_post_meta( $post_id, 'dh-dfrcs-set-' . $widget_id . '-' . $item_id . '-cache', array( 'price' => $price, 'last_updated' => $date ), true );
    }
?>

<script>
    (function($){
        var productEl = $( '.<?php echo 'set-' . $set_id; ?>' ).closest( '.dh-product' );
        var priceEl = $( productEl ).find( '.dh-product-price' );
        $( productEl ).find( '.dh-product-last-updated-text' ).text( 'Laatste update: <?php echo $date; ?>' );

        if ( priceEl.length == 0 ) {
            $( productEl ).find( '.dh-product-score' ).before( '<div class="dh-product-price"><div>Prijs</div><div><?php echo $price; ?></div></div>' );
        }
    })(jQuery)
</script>
