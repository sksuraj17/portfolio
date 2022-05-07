<?php
/**
 * Class to build up query args.
 */

if ( ! class_exists( 'TSSQueryArgs' ) ) :

	/**
	 * Query Args Class
	 */
	class TSSQueryArgs {
		/**
		 * Query Args.
		 *
		 * @var array
		 */
		private $args = array();

		/**
		 * Meta values.
		 *
		 * @var array
		 */
		private $meta = array();

		/**
		 * Method to build args
		 *
		 * @param array $meta Meta values.
		 * @param bool  $type condition type.
		 * @return array
		 */
		public function buildArgs( array $meta, bool $isCarousel ) {
			$this->meta = $meta;

			// Post Type.
			$this->getPostType();

			// Building Args.
			$this->postParams()->orderParams()->paginationParams( $isCarousel )->taxParams();

			return $this->args;
		}

		/**
		 * Post type.
		 *
		 * @return void
		 */
		private function getPostType() {
			$this->args['post_type'] = array( TSSPro()->post_type );
		}

		/**
		 * Post parameters.
		 *
		 * @return class
		 */
		private function postParams() {
			$post_in     = ( isset( $this->meta['postIn'] ) ? sanitize_text_field( $this->meta['postIn'] ) : null );
			$post_not_in = ( isset( $this->meta['postNotIn'] ) ? sanitize_text_field( $this->meta['postNotIn'] ) : null );
			$limit       = ( ( empty( $this->meta['postLimit'] ) || $this->meta['postLimit'] === '-1' ) ? 10000000 : (int) $this->meta['postLimit'] );

			if ( $post_in ) {
				$post_in                = explode( ',', $post_in );
				$this->args['post__in'] = $post_in;
			}

			if ( $post_not_in ) {
				$post_not_in                = explode( ',', $post_not_in );
				$this->args['post__not_in'] = $post_not_in;
			}

			$this->args['posts_per_page'] = $limit;

			return $this;
		}

		/**
		 * Order & Orderby parameters.
		 *
		 * @return class
		 */
		private function orderParams() {
			$order_by = ( isset( $this->meta['postOrderBy'] ) ? esc_attr( $this->meta['postOrderBy'] ) : null );
			$order    = ( isset( $this->meta['postOrder'] ) ? esc_attr( $this->meta['postOrder'] ) : null );

			if ( $order ) {
				$this->args['order'] = $order;
			}
			if ( $order_by ) {
				$this->args['orderby'] = $order_by;
			}

			return $this;
		}

		/**
		 * Pagination parameters.
		 *
		 * @param array $type Condition type.
		 * @return array
		 */
		private function paginationParams( $isCarousel ) {
			$pagination = ( ! empty( $this->meta['postPagination'] ) ? true : false );
			$limit      = ( ( empty( $this->meta['postLimit'] ) || $this->meta['postLimit'] === '-1' ) ? 10000000 : (int) $this->meta['postLimit'] );

			if ( $pagination ) {
				$posts_per_page = ( ! empty( $this->meta['postsPerPage'] ) ? intval( $this->meta['postsPerPage'] ) : $limit );

				if ( $posts_per_page > $limit ) {
					$posts_per_page = $limit;
				}

				$this->args['posts_per_page'] = $posts_per_page;

				if ( is_front_page() ) {
					$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
				} else {
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				}

				$offset              = $posts_per_page * ( (int) $paged - 1 );
				$this->args['paged'] = $paged;

				if ( intval( $this->args['posts_per_page'] ) > $limit - $offset ) {
					$this->args['posts_per_page'] = $limit - $offset;
					$this->args['offset']         = $offset;
				}
			}

			if ( $isCarousel ) {
				$this->args['posts_per_page'] = $limit;
			}

			return $this;
		}

		/**
		 * Taxonomy parameters.
		 *
		 * @return class
		 */
		private function taxParams() {
			$cats = ( isset( $this->meta['postCategories'] ) ? array_filter( $this->meta['postCategories'] ) : array() );
			$tags = ( isset( $this->meta['postTags'] ) ? array_filter( $this->meta['postTags'] ) : array() );
			$taxQ = array();

			if ( is_array( $cats ) && ! empty( $cats ) ) {
				$taxQ[] = array(
					'taxonomy' => TSSPro()->taxonomies['category'],
					'field'    => 'term_id',
					'terms'    => $cats,
				);
			}

			if ( is_array( $tags ) && ! empty( $tags ) ) {
				$taxQ[] = array(
					'taxonomy' => TSSPro()->taxonomies['tag'],
					'field'    => 'term_id',
					'terms'    => $tags,
				);
			}

			if ( ! empty( $taxQ ) ) {
				$this->args['tax_query'] = $taxQ;

				if ( count( $taxQ ) > 1 ) {
					$this->args['tax_query']['relation'] = ! empty( $this->meta['taxonomyRelation'] ) ? esc_attr( $this->meta['taxonomyRelation'] ) : 'AND';
				}
			}

			return $this;
		}

	}

endif;
