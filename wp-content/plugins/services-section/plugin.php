<?php
/**
 * Plugin Name: Services Section
 * Description: Use Services Section Block to provide services of your business to clients with customizable settings.
 * Version: 1.2.3
 * Author: bPlugins LLC
 * Author URI: http://bplugins.com
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: services-section
 */

// ABS PATH
if ( !defined( 'ABSPATH' ) ) { exit; }

// Constant
define( 'SSB_PLUGIN_VERSION', 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '1.2.3' );
define( 'SSB_ASSETS_DIR', plugin_dir_url( __FILE__ ) . 'assets/' );

// Generate Styles
class SSBStyleGenerator {
    public static $styles = [];
    public static function addStyle( $selector, $styles ){
        if( array_key_exists( $selector, self::$styles ) ){
           self::$styles[$selector] = wp_parse_args( self::$styles[$selector], $styles );
        }else { self::$styles[$selector] = $styles; }
    }
    public static function renderStyle(){
        $output = '';
        foreach( self::$styles as $selector => $style ){
            $new = '';
            foreach( $style as $property => $value ){
                if( $value == '' ){ $new .= $property; }else { $new .= " $property: $value;"; }
            }
            $output .= "$selector { $new }";
        }
        return $output;
    }
}

// Services Section Block
class ServicesSectionBlock{
    protected static $_instance = null;

    function __construct(){
        add_action( 'enqueue_block_assets', [$this, 'enqueue_block_assets'] );
        add_action( 'init', [$this, 'register'] );
    }

    public static function instance(){
        if( self::$_instance === null ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function enqueue_block_assets(){ wp_enqueue_script( 'fontAwesomeKit', SSB_ASSETS_DIR . 'js/font-awesome-kit.js', [], SSB_PLUGIN_VERSION, true ); }

    function register_script( $block, $options = [] ){
        register_block_type( 'services-section/' . $block, array_merge( [
            'editor_script' => 'ssb_editor_script',
            'editor_style'  => 'ssb_editor_style',
            'script'        => 'ssb_script',
            'style'         => 'ssb_style',
        ], $options ) );
    } // Register Script

    function register(){
        wp_register_script( 'ssb_editor_script', plugins_url( 'dist/editor.js', __FILE__ ), [ 'wp-blob', 'wp-block-editor', 'wp-blocks', 'wp-components', 'wp-compose', 'wp-data', 'wp-element', 'wp-html-entities', 'wp-i18n', 'wp-rich-text', 'fontAwesomeKit' ], SSB_PLUGIN_VERSION, false ); // Backend Script
        wp_register_style( 'ssb_editor_style', plugins_url( 'dist/editor.css', __FILE__ ), [ 'wp-edit-blocks' ], SSB_PLUGIN_VERSION ); // Backend Style
        wp_register_script( 'ssb_script', plugins_url( 'dist/script.js', __FILE__ ), [ 'jquery', 'fontAwesomeKit' ], SSB_PLUGIN_VERSION, true ); // Frontend Script
        wp_register_style( 'ssb_style', plugins_url( 'dist/style.css', __FILE__ ), [ 'wp-editor' ], SSB_PLUGIN_VERSION ); // Frontend Style

        $this->register_script( 'services', [ 'render_callback' => [$this, 'render_services'] ] );
        $this->register_script( 'service', [ 'render_callback' => [$this, 'render_service'] ] );

        wp_set_script_translations( 'ssb_editor_script', 'services-section', plugin_dir_path( __FILE__ ) . 'languages' ); // Translate
    } // Register

    function render_services( $attributes, $content ){
        extract( $attributes );
        $align = $align ?? '';
        $cId = $cId ?? '';
        $layout = $layout ?? 'default';
        $columns = $columns ?? [ 'desktop' => 3, 'tablet' => 2, 'mobile' => 1 ];
        $columnGap = $columnGap ?? '30px';
        $rowGap = $rowGap ?? '30px';
        $background = $background ?? '#0000';
        $textAlign = $textAlign ?? 'left';
        $itemHeight = $itemHeight ?? '375px';
        $itemPadding = $itemPadding ?? [ 'top' => '50px', 'right' => '30px', 'bottom' => '50px', 'left' => '50px' ];
        $itemShadow = $itemShadow ?? [ 'blur' => '20px', 'color' => '#0000001a' ];
        $itemBorder = $itemBorder ?? [ 'radius' => '15px' ];
        $iconPadding = $iconPadding ?? [ 'bottom' => '10px' ];
        $iconMargin = $iconMargin ?? [ 'bottom' => '20px' ];
        $titleTypo = $titleTypo ?? [ 'fontSize' => 23 ];
        $titleMargin = $titleMargin ?? [ 'bottom' => '30px' ];
        $descTypo = $descTypo ?? [ 'fontSize' => 16 ];

        $servicesStyle = new SSBStyleGenerator(); // Generate Styles
        $servicesStyle::addStyle( "#ssbServices-$cId .ssbServices", [ 'grid-gap' => "$rowGap $columnGap", $background['styles'] ?? 'background-color: #0000;' => '' ] );
        $servicesStyle::addStyle( "#ssbServices-$cId .ssbServices .ssbService", [
            'text-align' => $textAlign,
            'min-height' => $itemHeight,
            'padding' => $itemPadding['styles'] ?? '50px 30px 50px 50px',
            'box-shadow' => $itemShadow['styles'] ?? '0 0 20px 0 #0000001a',
            $itemBorder['styles'] ?? 'border-radius: 15px;' => ''
        ] );
        $servicesStyle::addStyle( "#ssbServices-$cId .ssbServices .ssbService .bgLayer", [ 'border-radius' => $itemBorder['radius'] ?? '15px' ] );
        $servicesStyle::addStyle( "#ssbServices-$cId .ssbServices .ssbService .icon", [ 'padding' => $iconPadding['styles'] ?? '0 0 10px 0', 'margin' => $iconMargin['styles'] ?? '0 0 20px 0' ] );
        $servicesStyle::addStyle( "#ssbServices-$cId .ssbServices .ssbService .title", [ $titleTypo['styles'] ?? 'font-size: 23px' => '', 'margin' => $titleMargin['styles'] ?? '0 0 30px 0' ] );
        $servicesStyle::addStyle( "#ssbServices-$cId .ssbServices .ssbService .description", [ $descTypo['styles'] ?? 'font-size: 16px' => '' ] );

        $titleFontLink = $titleTypo['googleFontLink'] ?? '';
        $descFontLink = $descTypo['googleFontLink'] ?? '';

        return "<div class='wp-block-services-section-services ". 'align' . esc_attr( $align ) ."' id='ssbServices-$cId'>
            <style>@import url( $titleFontLink ); @import url( $descFontLink );". $servicesStyle::renderStyle() ."</style>

            <div class='ssbServices $layout columns-". $columns['desktop'] ." columns-tablet-". $columns['tablet'] ." columns-mobile-". $columns['mobile'] ."'> $content </div>
        </div>";
        $servicesStyle::$styles = []; // Empty styles
    } // Render Services

    function render_service( $attributes ){
        extract( $attributes );
        $cId = $cId ?? '';
        $background = $background ?? [ 'color' => '#0000' ];
        $hoverBG = $hoverBG ?? [ 'type' => 'image', 'image' => [ 'url' => plugins_url( 'dist/src/img/service-pattern.png', __FILE__ ) ], 'overlayColor' => '#0000', 'position' => 'bottom left', 'size' => 'auto' ];
        $isIcon = $isIcon ?? true;
        $isUpIcon = $isUpIcon ?? false;
        $icon = $icon ?? [ 'class' => 'fa fa-wordpress', 'fontSize' => 70 ];
        $upIcon = $upIcon ?? [ 'id' => NULL, 'url' => '', 'alt' => '', 'title' => '' ];
        $iconWidth = $iconWidth ?? '70px';
        $iconBorder = $iconBorder ?? [];
        $isTitle = $isTitle ?? true;
        $title = $title ?? 'Service title';
        $titleColor = $titleColor ?? '#222';
        $isDesc = $isDesc ?? true;
        $desc = $desc ?? 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus, fuga.';
        $descColor = $descColor ?? '#333';
        $isLink = $isLink ?? true;
        $link = $link ?? '#';
        $linkIn = $linkIn ?? 'button';
        $linkIconColor = $linkIconColor ?? '#fff';
        $linkBGColor = $linkBGColor ?? '#d2d2d2';
        $linkBGHovColor = $linkBGHovColor ?? '#4527a4';

        $serviceStyle = new SSBStyleGenerator(); // Generate Styles
        $serviceStyle::addStyle( "#ssbService-$cId .ssbService", [ $background['styles'] ?? 'background-color: #0000;' => '' ] );
        $serviceStyle::addStyle( "#ssbService-$cId .ssbService .bgLayer", [ $hoverBG['styles'] ?? 'background-image: url( '. plugins_url( 'dist/src/img/service-pattern.png', __FILE__ ) .' ); background-position: bottom left; background-size: auto; background-repeat: no-repeat; background-color: #0000;' => '' ] );
        $serviceStyle::addStyle( "#ssbService-$cId .ssbService .icon", [ $iconBorder['styles'] ?? '' => '' ] );
        $serviceStyle::addStyle( "#ssbService-$cId .ssbService .icon i", [ $icon['styles'] ?? 'font-size: 70px;' => '' ] );
        $serviceStyle::addStyle( "#ssbService-$cId .ssbService .icon img", [ 'width' => $iconWidth ] );
        $serviceStyle::addStyle( "#ssbService-$cId .ssbService .title", [ 'color' => $titleColor ] );
        $serviceStyle::addStyle( "#ssbService-$cId .ssbService .description", [ 'color' => $descColor ] );
        $serviceStyle::addStyle( "#ssbService-$cId .ssbService .link a", [ 'background-color' => $linkBGColor ] );
        $serviceStyle::addStyle( "#ssbService-$cId:hover .ssbService .link a", [ 'background-color' => $linkBGHovColor ] );
        $serviceStyle::addStyle( "#ssbService-$cId .ssbService .link a svg", [ 'fill' => $linkIconColor ] );

        ob_start(); ?>
        <div class='wp-block-services-section-service' id='ssbService-<?php echo esc_attr( $cId ); ?>'>
            <style><?php echo wp_kses( $serviceStyle::renderStyle(), [] ); ?></style>
            <div class='ssbService'>
                <?php echo 'service' === $linkIn ? "<a class='serviceLink' href='". esc_url( $link ) ."'></a>" : ''; ?>
                <div class='bgLayer'></div>
                <div class='icon'><?php echo $isUpIcon ? ( isset( $upIcon['url'] ) ? "<img src='". esc_url( $upIcon['url'] ) ."' alt='". esc_attr( $upIcon['alt'] ) ."' />" : '' ) : ( isset( $icon['class'] ) ? "<i class='". esc_attr( $icon['class'] ) ."'></i>" : '' ); ?></div>

                <?php echo $isTitle ? ( 'title' === $linkIn ? "<a href='". esc_url( $link ) ."'><h3 class='title'>". wp_kses_post( $title ) ."</h3></a>" : "<h3 class='title'>". wp_kses_post( $title ) ."</h3>" ) : ''; ?>

                <?php echo $isDesc ? "<p class='description'>". wp_kses_post( $desc ) ."</p>" : ''; ?>

                <?php echo $isLink && 'button' === $linkIn ? "<div class='link'><a href='". esc_url( $link ) ."'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 493.356 493.356'><path d='M490.498,239.278l-109.632-99.929c-3.046-2.474-6.376-2.95-9.993-1.427c-3.613,1.525-5.427,4.283-5.427,8.282v63.954H9.136   c-2.666,0-4.856,0.855-6.567,2.568C0.859,214.438,0,216.628,0,219.292v54.816c0,2.663,0.855,4.853,2.568,6.563   c1.715,1.712,3.905,2.567,6.567,2.567h356.313v63.953c0,3.812,1.817,6.57,5.428,8.278c3.62,1.529,6.95,0.951,9.996-1.708   l109.632-101.077c1.903-1.902,2.852-4.182,2.852-6.849C493.356,243.367,492.401,241.181,490.498,239.278z' /></svg>
                </a></div>" : ''; ?>
            </div>
        </div>
        <?php $serviceStyle::$styles = []; // Empty styles
        return ob_get_clean();
    } // Render Service
}
ServicesSectionBlock::instance();