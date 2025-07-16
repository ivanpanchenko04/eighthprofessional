<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$rating = $product->get_average_rating();
$full   = floor( $rating );
$half   = ( $rating - $full ) >= 0.5 ? 1 : 0;
$empty  = 5 - $full - $half;

// Базова адреса сайту
$img_base_url = site_url( '/img/' );

echo '<div class="custom-star-rating">';

for ( $i = 0; $i < $full; $i++ ) {
	echo '<img src="' . $img_base_url . 'star-empty.svg" alt="star" class="star">';
}
if ( $half ) {
	echo '<img src="' . $img_base_url . 'star-empty.svg" alt="half-star" class="star">';
}
for ( $i = 0; $i < $empty; $i++ ) {
	echo '<img src="' . $img_base_url . 'star-empty.svg" alt="star" class="star">';
}

echo '</div>';
