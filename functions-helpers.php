<?php
/*
 * Helper functions used in template files
 */

/**
 * Displays <select> elements for all taxonomies of a given object
 */
function otm_taxonomies_select( $object ) {
	$taxonomies = get_object_taxonomies( $object, 'objects' );

	foreach ( $taxonomies as $taxonomy ) {
		$terms = get_terms( array( 'taxonomy' => $taxonomy->name, 'hide_empty' => true, 'number' => 1 ) );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			_otm_taxonomy_select( $taxonomy );
		}
	}
}

/**
 * Displays a <select> element for a given taxonomy
 */
function _otm_taxonomy_select( $taxonomy ) {
	$terms = get_terms( array( 'taxonomy' => $taxonomy->name, 'hide_empty' => true, ) );
	?>
	<select name="<?php print $taxonomy->name; ?>" class="filters-select ">
		<option value="">Filter by <?php print $taxonomy->labels->name; ?></option>
		<?php foreach ( $terms as $term ): ?>
			<option
				value="<?php print $term->slug; ?>" <?php if ( isset( $_GET[ $taxonomy->name ] ) && $_GET[ $taxonomy->name ] == $term->slug ) {
				print 'selected="selected"';
			} ?>><?php print $term->name; ?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

/**
 * Get all terms ids
 */
function otm_get_all_terms_ids( $post ) {
	$ids = array();

	$taxonomies = get_object_taxonomies( get_post_type( $post ), 'objects' );
	foreach ( $taxonomies as $taxonomy ) {
		$ids = array_merge( $ids, _otm_get_terms_ids( $post, $taxonomy->name ) );
	}

	return $ids;
}

/**
 * Get terms ids
 */
function _otm_get_terms_ids( $post, $taxonomy ) {
	$terms = get_the_terms( $post, $taxonomy );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return array();
	}

	return array_map( function ( $term ) {
		return $term->term_id;
	}, $terms );
}

/**
 * Get terms names
 */
function otm_get_terms_names( $post, $taxonomy ) {
	$terms = get_the_terms( $post, $taxonomy );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return array();
	}

	return array_map( function ( $term ) {
		return $term->name;
	}, $terms );
}
