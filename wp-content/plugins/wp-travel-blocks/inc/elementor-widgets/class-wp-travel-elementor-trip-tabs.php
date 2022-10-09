<?php
/**
 * Trips Tabs Widget File.
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

if ( ! class_exists( 'WP_Travel_Elementor_Trip_Tabs' ) ) {
	/**
	 * Class Declaration which extends Widget_Base.
	 */
	class WP_Travel_Elementor_Trip_Tabs extends Widget_Base {

		/**
		 * Trip ID.
		 *
		 * @var string $trip_id.
		 */
		private $trip_id = '';
		/**
		 * Widget Name.
		 */
		public function get_name() {
			return 'wp-travel-trip-tabs';
		}
		/**
		 * Widget Title.
		 */
		public function get_title() {
			return 'WP Travel Trip Tabs';
		}
		/**
		 * Widget Icon.
		 */
		public function get_icon() {
			return 'fas fa-layer-group';
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
					'default' => '<h2>Trip Tabs</h2>',
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
						'{{WRAPPER}} .trip_tabs_title' => 'text-align: {{VALUE}};',
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
						'{{WRAPPER}} .trip_tabs_title h1' => 'color: {{VALUE}}',
						'{{WRAPPER}} .trip_tabs_title h2' => 'color: {{VALUE}}',
						'{{WRAPPER}} .trip_tabs_title h3' => 'color: {{VALUE}}',
						'{{WRAPPER}} .trip_tabs_title h4' => 'color: {{VALUE}}',
						'{{WRAPPER}} .trip_tabs_title h5' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'important_note',
				array(
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw'  => __( '<strong><i>*Works Only On Trip Pages.</i></strong>', 'wp-travel-blocks' ),
				)
			);

			$this->end_controls_section();
		}
		/**
		 * PHP Render for Widget.
		 */
		protected function render() {
			wp_enqueue_script( 'wp-travel-elementor-booking-view' );
			wp_dequeue_script( 'wp-travel-maps' );
			$settings = $this->get_settings_for_display();
			$this->add_inline_editing_attributes( 'main_title', 'advanced' );
			$this->add_render_attribute(
				'main_title',
				array(
					'class' => array( 'trip_tabs_title' ),
				)
			);
			?>
			<div <?php echo $this->get_render_attribute_string( 'main_title' ); //phpcs:ignore ?> >
			<?php echo $settings['main_title']; //phpcs:ignore ?>
			</div>
			<?php
			$trip_id        = get_the_ID();
			$trip_tabs_data = \WPC\WP_Travel_Elementor_Blocks_Init::wp_travel_elementor_trip_tabs_contents( $trip_id );
			$trip_tabs_html = ! empty( $trip_tabs_data[ $trip_id ] ) ? ( $trip_tabs_data[ $trip_id ] ) : '';
			echo $trip_tabs_html;// phpcs:ignore WordPress.Security.EscapeOutput
		}
		/**
		 * JS Render for widget.
		 */
		protected function content_template() {
			?>
			<#
			var tripID = ElementorConfig.initial_document.id;
			view.addInlineEditingAttributes( 'main_title', 'advanced' );
			view.addRenderAttribute(
				'main_title',
				{
					'class': ['trip_tabs_title'],
				}
			);
			#>
			<div {{{ view.getRenderAttributeString( 'main_title' ) }}} >
				{{{ settings.main_title }}}
			</div>
			{{{ ElementorConfig.tripTabs[tripID] }}}
			<?php
		}
	}
}
