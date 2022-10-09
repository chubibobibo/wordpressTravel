<?php
/**
 * Theme functions and definitions
 *
 * @package magical_travel
 */

/**
 * After setup theme hook
 */
function magical_travel_theme_setup(){
    /*
     * Make chile theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'magical-travel', get_stylesheet_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'magical_travel_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function magical_travel_enqueue_styles(){
    wp_enqueue_style( 'travel-agency-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'magical-travel', get_stylesheet_directory_uri() . '/style.css', array( 'travel-agency-style' ), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'magical_travel_enqueue_styles' );

function magical_travel_customizer_options( $wp_customize ){

    if( defined( 'TRAVEL_AGENCY_COMPANION_PATH' )  ){
        $wp_customize->get_section( 'featured_section' )->priority = 45;
        $wp_customize->get_section( 'deal_section' )->priority     = 35;
    }

    /** Work Hour */
    $wp_customize->add_setting(
        'time',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'time',
        array(
            'label'       => __( 'Work Hour', 'magical-travel' ),
            'description' => __( 'Add working hour in header.', 'magical-travel' ),
            'section'     => 'header_misc_setting',
            'type'        => 'text',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'time', array(
        'selector'        => '.site-header .opening-time .time',
        'render_callback' => 'magical_travel_get_time',
    ) );

    /** Email */
    $wp_customize->add_setting(
        'email',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_email',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'email',
        array(
            'label'       => __( 'Email', 'magical-travel' ),
            'description' => __( 'Add email in header.', 'magical-travel' ),
            'section'     => 'header_misc_setting',
            'type'        => 'text',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'email', array(
        'selector'        => '.site-header .email-link .email',
        'render_callback' => 'magical_travel_get_email',
    ) );

}
add_action( 'customize_register', 'magical_travel_customizer_options',50 );

/**
 * Remove action from parent
*/
function magical_travel_remove_action(){
    remove_action( 'customize_register', 'travel_agency_customizer_theme_info' );
    remove_action( 'customize_register', 'travel_agency_customizer_demo_content' );    
}
add_action( 'init', 'magical_travel_remove_action' );

/**
 * Prints Time
*/
function magical_travel_get_time(){
    return esc_html( get_theme_mod( 'time' ) );
}
/**
 * Selective refresh for header email 
 */
function magical_travel_get_email(){
    return esc_html( get_theme_mod( 'email' ) );
}
/**
 * Selective refresh for header time
 */
function magical_travel_header_time(){
    $time = get_theme_mod( 'time' );
    if( $time ) echo '<div class="opening-time"><i class="fa fa-clock-o"></i><span class="time">' .  magical_travel_get_time() . '</span></div>';
}
/**
 * Header Phone
 *
 * @return void
 */
function magical_travel_header_phone(){
    $phone       = get_theme_mod( 'phone', __( '(888) 123-45678', 'magical-travel' ) );
    $phone_label = get_theme_mod( 'phone_label', __( 'Call us, we are open 24/7', 'magical-travel' ) );
    
    echo '<div class="right">';
    if( $phone_label ) echo '<span class="phone-label">' . travel_agency_get_phone_label() . '</span>';
    if( $phone ) echo '<a href="' . esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) ) . '" class="tel-link"><span class="phone">' .  travel_agency_get_header_phone() . '</span></a>';
    echo '</div>';
}

/**
 * Theme Info
 *
 * @param [type] $wp_customize
 * @return void
 */
function magical_travel_customizer_theme_info( $wp_customize ){
    $wp_customize->add_section( 'theme_info', array(
        'title'       => __( 'Information Links' , 'magical-travel' ),
        'priority'    => 6,
    ) );
    
    /** Important Links */
    $wp_customize->add_setting( 'theme_info_theme',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $theme_info = '<div class="customizer-custom">';
    $theme_info .= '<h3 class="sticky_title">' . __( 'Need help?', 'magical-travel' ) . '</h3>';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'View demo', 'magical-travel' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/previews/?theme=magical-travel/' ) . '" target="_blank">' . __( 'here', 'magical-travel' ) . '</a></span>';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'View documentation', 'magical-travel' ) . ': </label><a href="' . esc_url( 'https://docs.rarathemes.com/docs/magical-travel/' ) . '" target="_blank">' . __( 'here', 'magical-travel' ) . '</a></span>';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Support ticket', 'magical-travel' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/support-ticket/' ) . '" target="_blank">' . __( 'here', 'magical-travel' ) . '</a></span>';
    $theme_info .= '<span class="sticky_info_row"><label class="more-detail row-element">' . __( 'More Details', 'magical-travel' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/wordpress-themes/' ) . '" target="_blank">' . __( 'here', 'magical-travel' ) . '</a></span>';
    $theme_info .= '</div>';

    $wp_customize->add_control( new Travel_Agency_Info_Text( $wp_customize,
        'theme_info_theme', 
        array(
            'label' => __( 'About Magical Travel' , 'magical-travel' ),
            'section'     => 'theme_info',
            'description' => $theme_info
        )
        )
    );
    
    /** Demo Content Import */
    $wp_customize->add_section( 
        'theme_demo_content',
        array(
            'title'    => __( 'Demo Content Import', 'magical-travel' ),
            'priority' => 7,
        )
    );
    
    $wp_customize->add_setting(
        'demo_content_instruction',
        array(
            'sanitize_callback' => 'wp_kses_post'
        )
    );

    $demo_content_description = sprintf( __( 'Magical Travel comes with demo content import feature. You can import the demo content with just one click. For step-by-step video tutorial, %1$sClick here%2$s', 'magical-travel' ), '<a class="documentation" href="' . esc_url( 'https://rarathemes.com/blog/import-demo-content-rara-themes/' ) . '" target="_blank">', '</a>' );

    $wp_customize->add_control(
        new Travel_Agency_Info_Text( 
            $wp_customize,
            'demo_content_instruction',
            array(
                'label'       => __( 'About Demo Import' , 'magical-travel' ),
                'section'     => 'theme_demo_content',
                'description' => $demo_content_description,
            )
        )
    );
    
    $theme_demo_content_desc = '<div class="customizer-custom">';

    if( ! class_exists( 'RDDI_init' ) ){
        $theme_demo_content_desc .= '<span><label class="row-element">' . __( 'Plugin required', 'magical-travel' ) . ': </label><a href="' . esc_url( 'https://wordpress.org/plugins/rara-one-click-demo-import/' ) . '" target="_blank">' . __( 'Rara One Click Demo Import', 'magical-travel' ) . '</a></span><br />';
    }

    $theme_demo_content_desc .= '<span><label class="row-element">' . __( 'Download Demo Content', 'magical-travel' ) . ': </label><a href="' . esc_url( 'https://docs.rarathemes.com/docs/magical-travel/theme-activation-and-installation/how-to-import-demo-content/' ) . '" target="_blank" rel="nofollow noopener">' . __( 'Click here', 'magical-travel' ) . '</a></span><br />';

    $theme_demo_content_desc .= '</div>';
    $wp_customize->add_setting( 
        'theme_demo_content_info',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );

    // Demo content 
    $wp_customize->add_control( 
        new Travel_Agency_Info_Text( 
            $wp_customize,
            'theme_demo_content_info',
            array(
                'section'     => 'theme_demo_content',
                'description' => $theme_demo_content_desc,
            )
        )
    );

}
add_action( 'customize_register', 'magical_travel_customizer_theme_info' );

/**
 * Overides the fonts from the parent theme
 *
 * @return void
 */
function travel_agency_fonts_url() {
    $fonts_url = '';
    /*
    * translators: If there are characters in your language that are not supported
    * by Manrope, translate this to 'off'. Do not translate into your own language.
    */
    $manrope = _x( 'on', 'Manrope font: on or off', 'magical-travel' );

    if ( 'off' !== $manrope ) {
        $font_families = array();

        $font_families[] = 'Manrope:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i';

        $query_args = array(
            'family'  => urlencode( implode( '|', $font_families ) ),
            'display' => urlencode( 'fallback' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );
}
/**
 * Header Start
*/
function travel_agency_header(){
    $ed_social = get_theme_mod( 'ed_social_links', true );
    $time      = get_theme_mod( 'time' );
    $email     = get_theme_mod( 'email' );
    ?>
    <header class="site-header header-two" itemscope itemtype="https://schema.org/WPHeader">
        <div class="header-holder">   
            <?php if( $ed_social || $time || $email ){?>        
                <div class="header-t">
                    <div class="container">				
                        <div class="left">
                            <?php magical_travel_header_time(); ?>
                        </div><!-- .left -->				
                        <div class="right">
                            <?php
                                if( $email ) echo '<a href="' . esc_url( 'mailto:' . sanitize_email( $email ) ) . '" class="email-link"><i class="fa fa-envelope-open-o"></i><span class="email">' . magical_travel_get_email() . '</span></a>';
                                if( $ed_social ) travel_agency_social_links();
                            ?>
                        </div><!-- .right -->                
                    </div>
                </div><!-- .header-t -->   
            <?php } ?>    

            <div class="header-b">
                <div class="container">

                    <div class="site-branding" itemscope itemtype="https://schema.org/Organization">
                        <?php 
                            if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                                the_custom_logo();
                            } 
                        ?>
                        <div class="text-logo">
                            <?php if ( is_front_page() ) : ?>
                                <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                            <?php else : ?>
                                <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                            <?php endif; 
                            $description = get_bloginfo( 'description', 'display' );
                            if ( $description || is_customize_preview() ) : ?>
                                <p class="site-description" itemprop="description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
                            <?php
                            endif; ?>
                        </div>
                    </div><!-- .site-branding -->

                    <?php magical_travel_header_phone(); ?>
                </div>
            </div><!-- .header-b -->
        </div><!-- .header-holder -->    
        
        <div class="nav-holder">
            <div class="container">
                <div class="holder">

                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="home-link"><i class="fa fa-home"></i></a>
                    
                    <nav id="site-navigation" class="main-navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                        <?php
                            wp_nav_menu( array(
                                'theme_location' => 'primary',
                                'menu_id'        => 'primary-menu',
                                'fallback_cb'    => 'travel_agency_primary_menu_fallback',
                            ) );
                        ?>
                    </nav><!-- #site-navigation -->
                    <div class="tools desktop-search">
                        <?php travel_agency_get_header_search(); ?>
                    </div>
                    <div class="mobile-menu-wrapper">
                        <button id="primary-toggle-button" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle"><?php _e( 'MENU', 'magical-travel' );?><i class="fa fa-bars"></i></button>

                        <nav id="mobile-site-navigation" class="main-navigation mobile-navigation">        
                            <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
                                <button class="close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal">
                                    <?php _e( 'CLOSE', 'magical-travel'); ?>
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'magical-travel' ); ?>">
                                    <?php
                                        wp_nav_menu( array(
                                            'theme_location' => 'primary',
                                            'menu_id'        => 'mobile-primary-menu',
                                            'menu_class'     => 'nav-menu main-menu-modal',
                                            'fallback_cb'    => 'travel_agency_primary_menu_fallback',
                                        ) );
                                    ?>
                                </div>
                            </div>
                        </nav><!-- #mobile-site-navigation -->
                    </div>
                </div>
            </div>
        </div><!-- .nav-holder -->
    </header><!-- .site-header/.header-two -->
    <?php
}

/**
 * Return homepage sections
*/
function travel_agency_get_homepage_section(){
    $sections      = array();
    $ed_banner     = get_theme_mod( 'ed_banner', true );
    $ed_search_bar = get_theme_mod( 'ed_search_bar', true );
    $ed_about      = get_theme_mod( 'ed_about_section', true );
    $ed_activities = get_theme_mod( 'ed_activities_section', true );
    $ed_popular    = get_theme_mod( 'ed_popular_section', true );
    $ed_why_us     = get_theme_mod( 'ed_why_us_section', true );
    $ed_feature    = get_theme_mod( 'ed_feature_section', true );
    $ed_stat       = get_theme_mod( 'ed_stat_section', true );
    $ed_deal       = get_theme_mod( 'ed_deal_section', true );
    $ed_cta        = get_theme_mod( 'ed_cta_section', true );
    $ed_blog       = get_theme_mod( 'ed_blog_section', true );
    
    if( $ed_banner ) array_push( $sections, 'banner' );
    if( $ed_search_bar && travel_agency_is_wte_advanced_search_active() ) array_push( $sections, 'search' );

    // Sections from travel agency companion
    if( $ed_about ) array_push( $sections, 'about' );
    if( $ed_activities ) array_push( $sections, 'activities' );
    if( $ed_popular ) array_push( $sections, 'popular' );
    if( $ed_why_us ) array_push( $sections, 'our-feature' );
    if( $ed_deal ) array_push( $sections, 'deals' );
    if( $ed_stat ) array_push( $sections, 'stats' );
    if( $ed_feature ) array_push( $sections, 'featured-trip' );    
    if( $ed_cta ) array_push( $sections, 'cta' );
    if( $ed_blog ) array_push( $sections, 'blog' );
    
    return apply_filters( 'ta_home_sections', $sections );
}

/**
 * Footer Bottom
*/
function travel_agency_footer_bottom(){ ?>
    <div class="footer-b">
        <div class="site-info">
            <?php
                travel_agency_get_footer_copyright();
                echo esc_html__( 'Magical Travel | Developed By ', 'magical-travel' );
                echo '<a href="' . esc_url( 'https://rarathemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Rara Themes', 'magical-travel' ) . '</a>';
                
                printf( esc_html__( ' Powered by %s', 'magical-travel' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'magical-travel' ) ) .'" target="_blank">WordPress</a> .' );
            ?>                              
        </div>
        <?php 
        if ( function_exists( 'the_privacy_policy_link' ) ) {
            the_privacy_policy_link();
        }
        ?>
        <nav class="footer-navigation">
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'menu_id'        => 'footer-menu',
                    'fallback_cb'    => false,
                ) );
            ?>
        </nav><!-- .footer-navigation -->
    </div>
    <?php
}