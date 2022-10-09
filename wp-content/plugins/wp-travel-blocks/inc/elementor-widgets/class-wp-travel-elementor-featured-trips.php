<?php
/**
 * Featured Trips Widget File.
 *
 * @package wp-travel-blocks.
 */

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Exit if access directly.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_Travel_Elementor_Featured_Trips' ) ) {
	/**
	 * Class Declaration which extends Widget_Base.
	 */
	class WP_Travel_Elementor_Featured_Trips extends Widget_Base {
		/**
		 * Widget Name.
		 */
		public function get_name() {
			return 'wp-travel-featured-trips';
		}
		/**
		 * Widget Title.
		 */
		public function get_title() {
			return 'WP Travel Featured Trips';
		}
		/**
		 * Widget Icon.
		 */
		public function get_icon() {
			return 'fas fa-star';
		}
		/**
		 * Widget Categories.
		 */
		public function get_categories() {
			return array( 'wp-travel' );
		}
		/**
		 * Settings for widget.
		 */
		protected function _register_controls() { //phpcs:ignore

			$this->start_controls_section(
				'section_content_1',
				array(
					'label' => __( 'WP Travel Settings', 'wp-travel-blocks' ),
				)
			);

			$this->add_control(
				'main_title',
				array(
					'label'   => __( 'Title', 'wp-travel-blocks' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '<h2>Featured Trips</h2>',
				)
			);

			$this->add_control(
				'main_title_alignment',
				array(
					'label'     => __( 'Alignment', 'wp-travel-blocks' ),
					'type'      => \Elementor\Controls_Manager::CHOOSE,
					'options'   => array(
						'left'   => array(
							'title' => __( 'Left', 'wp-travel-blocks' ),
							'icon'  => 'fa fa-align-left',
						),
						'center' => array(
							'title' => __( 'Center', 'wp-travel-blocks' ),
							'icon'  => 'fa fa-align-center',
						),
						'right'  => array(
							'title' => __( 'Right', 'wp-travel-blocks' ),
							'icon'  => 'fa fa-align-right',
						),
					),
					'default'   => 'center',
					'selectors' => array(
						'{{WRAPPER}} .featured_trips_title' => 'text-align: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'main_title_color',
				array(
					'label'     => __( 'Color', 'wp-travel-blocks' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'default'   => '#000',
					'selectors' => array(
						'{{WRAPPER}} .featured_trips_title h1' => 'color: {{VALUE}}',
						'{{WRAPPER}} .featured_trips_title h2' => 'color: {{VALUE}}',
						'{{WRAPPER}} .featured_trips_title h3' => 'color: {{VALUE}}',
						'{{WRAPPER}} .featured_trips_title h4' => 'color: {{VALUE}}',
						'{{WRAPPER}} .featured_trips_title h5' => 'color: {{VALUE}}',
					),
				)
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'section_content_2',
				array(
					'label' => __( 'Trip Settings', 'wp-travel-blocks' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'trip_layout',
				array(
					'label'   => __( 'Trip Layout', 'wp-travel-blocks' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'grid-view',
					'options' => array(
						'grid-view' => __( 'Grid View', 'wp-travel-blocks' ),
						'list-view' => __( 'List View', 'wp-travel-blocks' ),
					),
				)
			);

			$this->add_control(
				'trip_numbers',
				array(
					'label'   => __( 'Number of Trips to Display', 'wp-travel-blocks' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => '2',
					'min'     => '1',
				)
			);

			$this->end_controls_section();
		}
		/**
		 * PHP Render For Widget.
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();
			$this->add_inline_editing_attributes( 'main_title', 'advanced' );
			$this->add_render_attribute(
				'main_title',
				array(
					'class' => array( 'featured_trips_title' ),
				)
			);
			?>
				<div <?php echo $this->get_render_attribute_string( 'main_title' ); //phpcs:ignore ?> >
					<?php echo $settings['main_title']; //phpcs:ignore ?>
				</div>
			<?php
			$index               = 0;
			$display_type        = $settings['trip_layout'];
			$max_post            = $settings['trip_numbers'];
			$featured_trips      = \WPC\WP_Travel_Elementor_Blocks_Init::wp_travel_elementor_featured_trip();
			$featured_trips_html = ! empty( $featured_trips[ $display_type ] ) ? ( $featured_trips[ $display_type ] ) : array();
			if ( array() === $featured_trips ) {
				echo esc_html__( '*Featured Trip Not Available', 'wp-travel-blocks' );
			} else {
				?>
				<div class="wp-travel-itinerary-items">
				<?php if ( 'grid-view' === $display_type ) { ?>
					<ul class="wp-travel-itinerary-list">
				<?php } else { ?>
					<div class="wp-travel-itinerary-list">
				<?php } ?>
					<?php
					if ( is_array( $featured_trips_html ) && count( $featured_trips_html ) > 0 ) {
						foreach ( $featured_trips_html as $featured_trip_html ) {
							if ( $index < $max_post ) {
								echo $featured_trip_html; // phpcs:ignore WordPress.Security.EscapeOutput
							}
							$index++;
						}
					}
					if ( 'grid-view' === $display_type ) {
						?>
					</ul>
						<?php
					} else {
						?>
					</div>
						<?php
					}
					?>
					</div>
					<?php
			}
		}
		/**
		 * JS Render for widget.
		 */
		protected function content_template() {
			?>
			<#
			var index             = 0;
			var displayType       = settings.trip_layout;
			var featuredTripsHtml = ElementorConfig.featuredTrips[displayType];
			var maxPosts          = settings.trip_numbers;
			view.addInlineEditingAttributes( 'main_title', 'advanced' );
			view.addRenderAttribute(
				'main_title',
				{
					'class': ['featured_trips_title'],
				}
			);
			#>
			<div {{{ view.getRenderAttributeString( 'main_title' ) }}} >
				{{{ settings.main_title }}}
			</div>
			<#
			if ( '' == ElementorConfig.featuredTrips ) { #>
				{{{ ElementorConfig.i18n.noFeaturedTrip }}}
			<# } else { #>
				<div class="wp-travel-itinerary-items">
				<#
				if ( 'grid-view' == displayType ) {
					#>
						<ul class="wp-travel-itinerary-list">
					<#
				} else {
					#>
						<div class="wp-travel-itinerary-list">
					<#
				}
					_(featuredTripsHtml).each(function(htmls, tripId){
						if ( index < maxPosts ) {
							#>
							{{{ htmls }}}
							<#
						}
						index++;
					});
				if ( 'grid-view' == displayType ) {
					#>
					</ul>
					<#
				} else {
					#>
					</div>
					<#
				}
			} #>
			</div> <!-- .wp-travel-itinerary-items -->
			<?php
		}
	}
}
