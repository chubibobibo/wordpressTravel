<?php
/**
 * Rest API functions.
 *
 * @package WP Travel Blocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WPTravel_Blocks_Rest
 */
class WPTravel_Blocks_Rest extends WP_REST_Controller {
	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'http://demo.wensolutions.com/travel-one/';

	/**
	 * Namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'wptravel/v';

	/**
	 * Version.
	 *
	 * @var string
	 */
	protected $version = '1';

	/**
	 * WPTravel_Blocks_Rest constructor.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
		$this->api_url = defined( 'WPTRAVEL_BLOCKS_API_URL') ? WPTRAVEL_BLOCKS_API_URL : $this->api_url;
	}

	/**
	 * Register rest routes.
	 */
	public function register_routes() {
		$namespace = $this->namespace . $this->version;

		// Get Templates.
		register_rest_route(
			$namespace,
			'/get_templates/',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_templates' ),
				'permission_callback' => '__return_true',
			)
		);

		// Get template data.
		register_rest_route(
			$namespace,
			'/get_template_data/',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_template_data' ),
				'permission_callback' => '__return_true',
			)
		);

		// Get settings data.
		register_rest_route(
			$namespace,
			'/get_settings/',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_settings' ),
				'permission_callback' => '__return_true',
			)
		);

		// Update Settings.
		register_rest_route(
			$namespace,
			'/update_settings/',
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'update_settings' ),
				'permission_callback' => array( $this, 'update_settings_permission' ),
			)
		);
	}

	/**
	 * Get templates.
	 *
	 * @return mixed
	 */
	public function get_templates() {
		$api_site  = $this->api_url;
		$url       = $api_site . 'wp-json/wptravel-library/v1/get_library/';
		$templates = get_transient( 'wptravel_blocks_remote_templates', false );

		/*
		 * Get remote templates.
		 */
		if ( ! $templates ) {
			$requested_templates = wp_remote_get(
				add_query_arg(
					array(
						'wptravel_blocks_version'     => '2.19.3',
						'wptravel_blocks_pro'         => false,
						'wptravel_blocks_pro_version' => null,
					),
					$url
				)
			);

			if ( ! is_wp_error( $requested_templates ) ) {
				$new_templates = wp_remote_retrieve_body( $requested_templates );
				$new_templates = json_decode( $new_templates, true );

				if ( $new_templates && isset( $new_templates['response'] ) && is_array( $new_templates['response'] ) ) {
					$templates = $new_templates['response'];
					set_transient( 'wptravel_blocks_remote_templates', $templates, DAY_IN_SECONDS );
				}
			}
		}

		// Remove Pro templates from array, cause for now there is no way to check if pro addon is activated.
		if ( $templates ) {
			foreach ( $templates as $k => $template ) {
				$is_pro = false;

				if ( isset( $template['types'] ) && is_array( $template['types'] ) ) {
					foreach ( $template['types'] as $type ) {
						$is_pro = $is_pro || 'pro' === $type['slug'];
					}
				}

				if ( $is_pro ) {
					unset( $templates[ $k ] );
				}
			}
		}

		/*
		 * Get user templates from db.
		 */

		// Stupid hack.
		// https://core.trac.wordpress.org/ticket/18408.
		global $post;
		$backup_global_post = $post;
		$local_templates    = array();

		$local_templates_query = new WP_Query(
			array(
				'post_type'      => 'wptravel_template',
				'posts_per_page' => -1,
				'showposts'      => -1,
				'paged'          => -1,
			)
		);

		while ( $local_templates_query->have_posts() ) {
			$local_templates_query->the_post();
			$db_template = get_post();

			$categories     = array();
			$category_terms = get_the_terms( $db_template->ID, 'wptravel_template_category' );

			if ( $category_terms ) {
				foreach ( $category_terms as $cat ) {
					$categories[] = array(
						'slug' => $cat->slug,
						'name' => $cat->name,
					);
				}
			}

			$image_id   = get_post_thumbnail_id( $db_template->ID );
			$image_data = wp_get_attachment_image_src( $image_id, 'large' );

			$local_templates[] = array(
				'id'               => $db_template->ID,
				'title'            => $db_template->post_title,
				'types'            => array(
					array(
						'slug' => 'local',
					),
				),
				'categories'       => empty( $categories ) ? false : $categories,
				'url'              => get_post_permalink( $db_template->ID ),
				'thumbnail'        => isset( $image_data[0] ) ? $image_data[0] : false,
				'thumbnail_width'  => isset( $image_data[1] ) ? $image_data[1] : false,
				'thumbnail_height' => isset( $image_data[2] ) ? $image_data[2] : false,
			);
		}

		// Restore the global $post as it was before custom WP_Query.
		// phpcs:ignore
		$post = $backup_global_post;

		/*
		 * Get theme templates.
		 */
		$theme_templates      = array();
		$theme_templates_data = array();

		foreach ( glob( get_template_directory() . '/wptravel/templates/*/content.php' ) as $template ) {
			$template_path = dirname( $template );
			$template_url  = get_template_directory_uri() . str_replace( get_template_directory(), '', $template_path );
			$slug          = basename( $template_path );

			$theme_templates_data[ $slug ] = array(
				'slug' => $slug,
				'path' => $template_path,
				'url'  => $template_url,
			);
		}

		// get child theme templates.
		if ( get_stylesheet_directory() !== get_template_directory() ) {
			foreach ( glob( get_stylesheet_directory() . '/wptravel/templates/*/content.php' ) as $template ) {
				$template_path = dirname( $template );
				$template_url  = get_stylesheet_directory_uri() . str_replace( get_stylesheet_directory(), '', $template_path );
				$slug          = basename( $template_path );

				$theme_templates_data[ $slug ] = array(
					'slug' => $slug,
					'path' => $template_path,
					'url'  => $template_url,
				);
			}
		}

		// natural sort.
		array_multisort( array_keys( $theme_templates_data ), SORT_NATURAL, $theme_templates_data );

		foreach ( $theme_templates_data as $template_data ) {
			$file_data = get_file_data(
				$template_data['path'] . '/content.php',
				array(
					'name'     => 'Name',
					'category' => 'Category',
					'source'   => 'Source',
				)
			);

			$thumbnail        = false;
			$thumbnail_width  = false;
			$thumbnail_height = false;

			if ( file_exists( $template_data['path'] . '/thumbnail.png' ) ) {
				$thumbnail = $template_data['url'] . '/thumbnail.png';

				list($thumbnail_width, $thumbnail_height) = getimagesize( $thumbnail );
			}

			if ( file_exists( $template_data['path'] . '/thumbnail.jpg' ) ) {
				$thumbnail = $template_data['url'] . '/thumbnail.jpg';
			}

			$theme_templates[] = array(
				'id'               => basename( $template_data['path'] ),
				'title'            => $file_data['name'],
				'types'            => array(
					array(
						'slug' => 'theme',
					),
				),
				'categories'       => isset( $file_data['category'] ) && $file_data['category'] ? array(
					array(
						'slug' => $file_data['category'],
						'name' => $file_data['category'],
					),
				) : false,
				'url'              => false,
				'thumbnail'        => $thumbnail,
				'thumbnail_width'  => $thumbnail_width,
				'thumbnail_height' => $thumbnail_height,
			);
		}

		// merge all available templates.
		$templates = array_merge( $templates, $local_templates, $theme_templates );

		if ( is_array( $templates ) ) {
			return $this->success( $templates );
		} else {
			return $this->error( 'no_templates', __( 'Templates not found.', '@@text_domain' ) );
		}
	}

	/**
	 * Get templates.
	 *
	 * @param WP_REST_Request $request  request object.
	 *
	 * @return mixed
	 */
	public function get_template_data( WP_REST_Request $request ) {
		$api_site      = $this->api_url;
		$url           = $api_site . 'wp-json/wptravel-library/v1/get_library_data/';
		$id            = $request->get_param( 'id' );
		$type          = $request->get_param( 'type' );
		$template_data = false;

		switch ( $type ) {
			case 'remote':
				$template_data = get_transient( 'wptravel_blocks_template_' . $type . '_' . $id, false );

				if ( ! $template_data ) {
					$requested_template_data = wp_remote_get(
						add_query_arg(
							apply_filters(
								'wptravel_blocks_rest_template_data_url_args',
								array(
									'id'               => $id,
									'wptravel_blocks_version' => wptravel_blocks_VERSION,
									'wptravel_blocks_site'    => site_url( '/' ),
								)
							),
							$url
						)
					);

					if ( ! is_wp_error( $requested_template_data ) ) {
						$new_template_data = wp_remote_retrieve_body( $requested_template_data );
						$new_template_data = json_decode( $new_template_data, true );

						if ( $new_template_data && isset( $new_template_data['response'] ) && is_array( $new_template_data['response'] ) ) {
							$template_data = $new_template_data['response'];
							set_transient( 'wptravel_blocks_template_' . $type . '_' . $id, $template_data, DAY_IN_SECONDS );
						}
					}
				}
				break;
			case 'local':
				$post = get_post( $id );

				if ( $post && 'wptravel_template' === $post->post_type ) {
					$template_data = array(
						'id'      => $post->ID,
						'title'   => $post->post_title,
						'content' => $post->post_content,
					);
				}

				break;
			case 'theme':
				$template_content_file = get_stylesheet_directory() . '/wptravel/templates/' . $id . '/content.php';

				if ( ! file_exists( $template_content_file ) ) {
					$template_content_file = get_template_directory() . '/wptravel/templates/' . $id . '/content.php';
				}

				if ( file_exists( $template_content_file ) ) {
					ob_start();
					include $template_content_file;
					$template_content = ob_get_clean();

					if ( $template_content ) {
						$template_data = get_file_data(
							$template_content_file,
							array(
								'name' => 'Name',
							)
						);

						$template_data = array(
							'id'      => $id,
							'title'   => $template_data['name'],
							'content' => $template_content,
						);
					}
				}
				break;
		}

		if ( is_array( $template_data ) ) {
			return $this->success( $template_data );
		} else {
			return $this->error( 'no_template_data', __( 'Template data not found.', '@@text_domain' ) );
		}
	}

	/**
	 * Get settings.
	 *
	 * @return mixed
	 */
	public function get_settings() {
		$settings = wptravel_blocks_settings();

		if ( is_array( $settings ) ) {
			return $this->success( $settings );
		} else {
			return $this->error( 'no_settings', __( 'Settings data not found.', '@@text_domain' ) );
		}
	}

	/**
	 * Get edit options permissions.
	 *
	 * @return bool
	 */
	public function update_settings_permission() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return $this->error( 'user_dont_have_permission', __( 'User don\'t have permissions to change options.', '@@text_domain' ) );
		}
		return true;
	}

	/**
	 * Update Settings.
	 *
	 * @param WP_REST_Request $request  request object.
	 *
	 * @return mixed
	 */
	public function update_settings( WP_REST_Request $request ) {
		$new_settings = $request->get_param( 'settings' );

		if ( is_array( $new_settings ) ) {
			$current_settings = get_option( 'wptravel_blocks_settings', array() );
			update_option( 'wptravel_blocks_settings', array_merge( $current_settings, $new_settings ) );
		}

		return $this->success( true );
	}

	/**
	 * Success rest.
	 *
	 * @param mixed $response response data.
	 * @return mixed
	 */
	public function success( $response ) {
		return new WP_REST_Response(
			array(
				'success'  => true,
				'response' => $response,
			),
			200
		);
	}

	/**
	 * Error rest.
	 *
	 * @param mixed $code     error code.
	 * @param mixed $response response data.
	 * @return mixed
	 */
	public function error( $code, $response ) {
		return new WP_REST_Response(
			array(
				'error'      => true,
				'success'    => false,
				'error_code' => $code,
				'response'   => $response,
			),
			401
		);
	}
}
new WPTravel_Blocks_Rest();
