<?php
/**
 * Trip Search Form Widget File.
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

if ( ! class_exists( 'WP_Travel_Elementor_Trip_Search_Form' ) ) {
	/**
	 * Class Declaration which extends Widget_Base.
	 */
	class WP_Travel_Elementor_Trip_Search_Form extends Widget_Base {
		/**
		 * Widget Name.
		 */
		public function get_name() {
			return 'wp-travel-trip-search-form';
		}
		/**
		 * Widget Title.
		 */
		public function get_title() {
			return 'WP Travel Trip Search Form';
		}
		/**
		 * Widget Icon.
		 */
		public function get_icon() {
			return 'fas fa-search';
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
				'section_content',
				array(
					'label' => __( 'WP Travel Settings', 'wp-travel-blocks' ),
				)
			);

			$this->add_control(
				'main_title',
				array(
					'label'   => __( 'Title', 'wp-travel-blocks' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '<h2>WP Travel Trip Search</h2>',
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
						'{{WRAPPER}} .trip_search_form_title' => 'text-align: {{VALUE}};',
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
						'{{WRAPPER}} .trip_search_form_title h1' => 'color: {{VALUE}}',
						'{{WRAPPER}} .trip_search_form_title h2' => 'color: {{VALUE}}',
						'{{WRAPPER}} .trip_search_form_title h3' => 'color: {{VALUE}}',
						'{{WRAPPER}} .trip_search_form_title h4' => 'color: {{VALUE}}',
						'{{WRAPPER}} .trip_search_form_title h5' => 'color: {{VALUE}}',
					),
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
					'class' => array( 'trip_search_form_title' ),
				)
			);
			?>
				<div class="widget_wp_travel_filter_search_widget">
					<div <?php echo $this->get_render_attribute_string( 'main_title' ); //phpcs:ignore ?> >
						<?php echo $settings['main_title']; //phpcs:ignore ?>
					</div>
					<?php
					if ( function_exists( 'wptravel_search_form' ) ) {
						wptravel_search_form();
					} else {
						wp_travel_search_form();
					}
					?>
				</div>
			<?php
		}
		/**
		 * JS Render for widget.
		 */
		protected function content_template() {
			?>
			<#
			view.addInlineEditingAttributes( 'main_title', 'advanced' );
			view.addRenderAttribute(
				'main_title',
				{
					'class': ['trip_search_form_title'],
				}
			);
			#>
			<div class="widget_wp_travel_filter_search_widget">
				<div {{{ view.getRenderAttributeString( 'main_title' ) }}} >
					{{{ settings.main_title }}}
				</div>
				<div class="wp-travel-search">
					<form method="get" name="wp-travel_search" action="">
					<p>
						<label>Search:</label>
						<input type="text" name="s" id="s" value="" placeholder="Ex: Trekking" />
					</p>
					<p>
						<label>Trip Type:</label>
						<select name="itinerary_types" id="itinerary_types" class="wp-travel-taxonomy">
						<option value="0" selected="selected">All</option>
						</select>
					</p>
					<p>
						<label>Location:</label>
						<select name="travel_locations" id="travel_locations" class="wp-travel-taxonomy">
						<option value="0" selected="selected">All</option>
						</select>
					</p>
					<p class="wp-travel-search"><input type="submit" name="wp-travel_search" id="wp-travel-search" class="button button-primary" value="Search" /></p>
					</form>
				</div>
			</div>
			<?php
		}
	}
}
