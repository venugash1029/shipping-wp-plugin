<?php
 
/**
 * Plugin Name: TutsPlus Shipping
 * Plugin URI: http://code.tutsplus.com/tutorials/create-a-custom-shipping-method-for-woocommerce--cms-26098
 * Description: Custom Shipping Method for WooCommerce
 * Version: 1.0.0
 * Author: Igor Benić
 * Author URI: http://www.ibenic.com
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path: /lang
 * Text Domain: tutsplus
 */
 
if ( ! defined( 'WPINC' ) ) {
 
    die;
 
}
 
/*
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
    function tutsplus_shipping_method() {
        if ( ! class_exists( 'TutsPlus_Shipping_Method' ) ) {
            class TutsPlus_Shipping_Method extends WC_Shipping_Method {
                /**
                 * Constructor for your shipping class
                 *
                 * @access public
                 * @return void
                 */
                public function __construct() {
                    $this->id                 = 'tutsplus'; 
                    $this->method_title       = __( 'Courier', 'tutsplus' );  
                    $this->method_description = __( 'Custom Shipping Method for TutsPlus', 'tutsplus' ); 
 
                    // Availability & Countries
                    $this->availability = 'including';
                    $this->countries = array(
                        'AF',
                        'DZ',
                        'AO',
                        'BH',
                        'BD',
                        'BT',
                        'BW',
                        'BN',
                        'BI',
                        'KH',
                        'CF',
                        'TD',
                        'CN',
                        'CG',
                        'CI',
                        'EG',
                        'ET',
                        'FJ',
                        'GM',
                        'GH',
                        'GN',
                        'HK',
                        'IN',
                        'ID',
                        'IQ',
                        'IL',
                        'JO',
                        'KZ',
                        'KE',
                        'KW',
                        'KG',
                        'LA',
                        'LB',
                        'LS',
                        'LR',
                        'LY',
                        'MO',
                        'MG',
                        'MW',
                        'MY',
                        'MV',
                        'MU',
                        'MN',
                        'MA',
                        'MZ',
                        'MM',
                        'NA',
                        'NP',
                        'NZ',
                        'NE',
                        'NG',
                        'OM',
                        'PK',
                        'PW',
                        'PS',
                        'PG',
                        'PH',
                        'QA',
                        'RW',
                        'WS',
                        'SA',
                        'SN',
                        'SC',
                        'SL',
                        'SG',
                        'SB',
                        'SO',
                        'ZA',
                        'KR',
                        'SD',
                        'SY',
                        'TW',
                        'TJ',
                        'TZ',
                        'TH',
                        'TG',
                        'TN',
                        'TR',
                        'UG',
                        'AE',
                        'UZ',
                        'VU',
                        'VN',
                        'YE',
                        'ZM',
                        'ZW'
                        );
 
                    $this->init();
 
                    $this->enabled = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';
                    $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : __( 'Courier', 'tutsplus' );
                }
 
                /**
                 * Init your settings
                 *
                 * @access public
                 * @return void
                 */
                function init() {
                    // Load the settings API
                    $this->init_form_fields(); 
                    $this->init_settings(); 
 
                    // Save settings in admin if you have any defined
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }
 
                /**
                 * Define settings field for this shipping
                 * @return void 
                 */
                function init_form_fields() { 
 
                    $this->form_fields = array(
 
                     'enabled' => array(
                          'title' => __( 'Enable', 'tutsplus' ),
                          'type' => 'checkbox',
                          'description' => __( 'Enable this shipping.', 'tutsplus' ),
                          'default' => 'yes'
                          ),
 
                     'title' => array(
                        'title' => __( 'Title', 'tutsplus' ),
                          'type' => 'text',
                          'description' => __( 'Title to be display on site', 'tutsplus' ),
                          'default' => __( 'Courier', 'tutsplus' )
                          ),
 
                     'weight' => array(
                        'title' => __( 'Weight (kg)', 'tutsplus' ),
                          'type' => 'number',
                          'description' => __( 'Maximum allowed weight', 'tutsplus' ),
                          'default' => 100
                          ),
 
                     );
 
                }
 
                /**
                 * This function is used to calculate the shipping cost. Within this function we can check for weights, dimensions and other parameters.
                 *
                 * @access public
                 * @param mixed $package
                 * @return void
                 */
                public function calculate_shipping( $package ) {
                
                  
                    $weight = 0;
                    $tot_cost = 0;
                    $cost = 0;
                    $country = $package["destination"]["country"];
 
                    foreach ( $package['contents'] as $item_id => $values ) 
                    { 
                        $_product = $values['data']; 
                        $weight = $weight + $_product->get_weight() * $values['quantity']; 
                       
                    }
 
                    $weight = wc_get_weight( $weight, 'kg' );
                    if($country=="AF"){
                        if( $weight <=0.5) {
    
                            $cost =   10295.23 ;
    
                        } else if( $weight > 0.5 &&  $weight <=1) {
    
                            $cost =     10640.52   ;
    
                        } else if( $weight > 1 &&  $weight <=1.5 ) {
    
                            $cost =     11950.25  ;
    
                        }
                        else if( $weight > 1.5 &&  $weight <=2 ) {
    
                            $cost =     13257.99  ;
    
                        }
                        else if( $weight > 2 &&  $weight <=2.5 ) {
    
                            $cost =   15161.06  ;
    
                        }
                        else if( $weight > 2.5 &&  $weight <=3 ) {
    
                            $cost =   16448.96  ;
    
                        }
                        else if( $weight > 3 &&  $weight <=3.5 ) {
    
                            $cost =   17738.84 ;
    
                        }
                        else if( $weight > 3.5 &&  $weight <=4 ) {
    
                            $cost =   19068.60  ;
    
                        }
                        else if( $weight > 4 &&  $weight <=4.5 ) {
    
                            $cost =  20359.34   ;
    
                        }
                        else if( $weight > 4.5 &&  $weight <=5 ) {
    
                            $cost =  21652.05  ;
    
                        }
                        else if( $weight > 5 &&  $weight <=5.5 ) {
    
                            $cost =  22942.79   ;
    
                        }
                        else if( $weight > 5.5 &&  $weight <=6 ) {
    
                            $cost =     24233.52   ;
    
                        }
                        else if( $weight > 6 &&  $weight <=6.5) {
    
                            $cost =    25524.25  ;
    
                        }
                        else if( $weight > 6.5 &&  $weight <=7 ) {
    
                            $cost =     26816.97   ;
    
                        }
                        else if( $weight > 7 &&  $weight <=7.5) {
    
                            $cost =     28107.70   ;
    
                        }
                        else if( $weight > 7.5 &&  $weight <=8 ) {
    
                            $cost =     29398.43   ;
    
                        }
                        else if( $weight > 8 &&  $weight <=8.5 ) {
    
                            $cost =     30691.15   ;
    
                        }
                        else if( $weight > 8.5 &&  $weight <=9 ) {
    
                            $cost =     31981.88   ;
    
                        }
                        else if( $weight > 9 &&  $weight <=9.5) {
    
                            $cost =     33276.58   ;
    
                        }
                        else if( $weight > 9.5 &&  $weight <=10 ) {
    
                            $cost =    37093.09  ;
    
                        }
                        else if( $weight > 10 &&  $weight <=10.5 ) {
    
                            $cost =     38443.48   ;
    
                        }
                        else if( $weight > 10.5 &&  $weight <=11 ) {
    
                            $cost =     39793.88  ;
    
                        }
                        else if( $weight > 11 &&  $weight <=11.5) {
    
                            $cost =     41142.28   ;
    
                        }
                        else if( $weight > 11.5 &&  $weight <=12 ) {
    
                            $cost =     42492.68   ;
    
                        }
                        else if( $weight > 12 &&  $weight <=12.5) {
    
                            $cost =    43843.07   ;
    
                        }
                        else if( $weight > 12.5 &&  $weight <=13 ) {
    
                            $cost =     45193.47   ;
    
                        }
                        else if( $weight > 13 &&  $weight <=13.5 ) {
    
                            $cost =    46541.87   ;
    
                        }
                        else if( $weight > 13.5 &&  $weight <=14 ) {
    
                            $cost =      47892.27   ;
    
                        }
                        else if( $weight > 14 &&  $weight <=14.5 ) {
    
                            $cost =    49242.66   ;
    
                        }
                        else if( $weight > 14.5 &&  $weight <=15 ) {
    
                            $cost =     50591.07  ;
    
                        }

                    }

                    else if($country=="DZ"){
                        if( $weight <=0.5) {
        
                            $cost = 8940.75 ;
        
                        } else if( $weight > 0.5 &&  $weight <=1) {
        
                            $cost = 9756.60  ;
        
                        } else if( $weight > 1 &&  $weight <=1.5 ) {
        
                            $cost = 10558.60  ;
        
                        }
                        else if( $weight > 1.5 &&  $weight <=2 ) {
        
                            $cost = 11358.61  ;
        
                        }
                        else if( $weight > 2 &&  $weight <=2.5 ) {
        
                            $cost = 12897.25  ;
        
                        }
                        else if( $weight > 2.5 &&  $weight <=3 ) {
        
                            $cost =   13532.91  ;
        
                        }
                        else if( $weight > 3 &&  $weight <=3.5 ) {
        
                            $cost = 14182.42 ;
        
                        }
                        else if( $weight > 3.5 &&  $weight <=4 ) {
        
                            $cost = 14829.96 ;
        
                        }
                        else if( $weight > 4 &&  $weight <=4.5 ) {
        
                            $cost = 15473.53 ;
        
                        }
                        else if( $weight > 4.5 &&  $weight <=5 ) {
        
                            $cost = 20267.67 ;
        
                        }
                        else if( $weight > 5 &&  $weight <=5.5 ) {
        
                            $cost = 21121.15 ;
        
                        }
                        else if( $weight > 5.5 &&  $weight <=6 ) {
        
                            $cost = 21863.74 ;
        
                        }
                        else if( $weight > 6 &&  $weight <=6.5) {
        
                            $cost = 22600.39 ;
        
                        }
                        else if( $weight > 6.5 &&  $weight <=7 ) {
        
                            $cost = 23350.90 ;
        
                        }
                        else if( $weight > 7 &&  $weight <=7.5) {
         
                            $cost = 24093.48 ;
        
                        }
                        else if( $weight > 7.5 &&  $weight <=8 ) {
        
                            $cost = 24832.11 ;
        
                        }
                        else if( $weight > 8 &&  $weight <=8.5 ) {
        
                            $cost = 25574.70 ;
        
                        }
                        else if( $weight > 8.5 &&  $weight <=9 ) {
        
                            $cost = 26313.32 ;
        
                        }
                        else if( $weight > 9 &&  $weight <=9.5) {
        
                            $cost = 27063.83 ;
        
                        }
                        else if( $weight > 9.5 &&  $weight <=10 ) {
        
                            $cost = 35606.55 ;
        
                        }
                        else if( $weight > 10 &&  $weight <=10.5 ) {
        
                            $cost = 36450.13 ;
        
                        }
                        else if( $weight > 10.5 &&  $weight <=11 ) {
        
                            $cost = 37299.65 ;
        
                        }
                        else if( $weight > 11 &&  $weight <=11.5) {
        
                            $cost = 38000.65 ;
        
                        }
                        else if( $weight > 11.5 &&  $weight <=12 ) {
        
                            $cost = 38687.79 ;
        
                        }
                        else if( $weight > 12 &&  $weight <=12.5) {
        
                            $cost = 39541.27 ;
        
                        }
                        else if( $weight > 12.5 &&  $weight <=13 ) {
        
                            $cost = 40369.01 ;
        
                        }
                        else if( $weight > 13 &&  $weight <=13.5 ) {
        
                            $cost = 41218.53 ;
        
                        }
                        else if( $weight > 13.5 &&  $weight <=14 ) {
        
                            $cost = 42046.27;
        
                        }
                        else if( $weight > 14 &&  $weight <=14.5 ) {
        
                            $cost = 42885.88 ;
        
                        }
                        else if( $weight > 14.5 &&  $weight <=15 ) {
        
                            $cost = 43733.42 ;
        
                        }
        
                    }
                    else if($country=="AO"){
                        if( $weight <=0.5) {
        
                            $cost = 7194.18 ;
        
                        } else if( $weight > 0.5 &&  $weight <=1) {
        
                            $cost = 7845.68  ;
        
                        } else if( $weight > 1 &&  $weight <=1.5 ) {
        
                            $cost = 8499.16  ;
        
                        }
                        else if( $weight > 1.5 &&  $weight <=2 ) {
        
                            $cost = 9150.65  ;
        
                        }
                        else if( $weight > 2 &&  $weight <=2.5 ) {
        
                            $cost = 10455.62  ;
        
                        }
                        else if( $weight > 2.5 &&  $weight <=3 ) {
        
                            $cost =   11107.12  ;
        
                        }
                        else if( $weight > 3 &&  $weight <=3.5 ) {
        
                            $cost = 11760.60 ;
        
                        }
                        else if( $weight > 3.5 &&  $weight <=4 ) {
        
                            $cost = 12412.09 ;
        
                        }
                        else if( $weight > 4 &&  $weight <=4.5 ) {
        
                            $cost = 13065.57 ;
        
                        }
                        else if( $weight > 4.5 &&  $weight <=5 ) {
        
                            $cost = 17186.43 ;
        
                        }
                        else if( $weight > 5 &&  $weight <=5.5 ) {
        
                            $cost = 17984.47 ;
        
                        }
                        else if( $weight > 5.5 &&  $weight <=6 ) {
        
                            $cost = 18639.92 ;
        
                        }
                        else if( $weight > 6 &&  $weight <=6.5) {
        
                            $cost = 19293.40 ;
        
                        }
                        else if( $weight > 6.5 &&  $weight <=7 ) {
        
                            $cost = 19952.82 ;
        
                        }
                        else if( $weight > 7 &&  $weight <=7.5) {
        
                            $cost = 20475.60 ;
        
                        }
                        else if( $weight > 7.5 &&  $weight <=8 ) {
        
                            $cost = 21012.24 ;
        
                        }
                        else if( $weight > 8 &&  $weight <=8.5 ) {
        
                            $cost = 21665.72 ;
        
                        }
                        else if( $weight > 8.5 &&  $weight <=9 ) {
        
                            $cost = 22321.18 ;
        
                        }
                        else if( $weight > 9 &&  $weight <=9.5) {
        
                            $cost = 22970.69 ;
        
                        }
                        else if( $weight > 9.5 &&  $weight <=10 ) {
        
                            $cost = 30125.27 ;
        
                        }
                        else if( $weight > 10 &&  $weight <=10.5 ) {
        
                            $cost = 30816.37 ;
        
                        }
                        else if( $weight > 10.5 &&  $weight <=11 ) {
        
                            $cost = 31337.17 ;
        
                        }
                        else if( $weight > 11 &&  $weight <=11.5) {
        
                            $cost = 31863.91 ;
        
                        }
                        else if( $weight > 11.5 &&  $weight <=12 ) {
        
                            $cost = 32404.52 ;
        
                        }
                        else if( $weight > 12 &&  $weight <=12.5) {
        
                            $cost = 33087.70 ;
        
                        }
                        else if( $weight > 12.5 &&  $weight <=13 ) {
        
                            $cost = 33772.86 ;
        
                        }
                        else if( $weight > 13 &&  $weight <=13.5 ) {
        
                            $cost = 34311.48 ;
        
                        }
                        else if( $weight > 13.5 &&  $weight <=14 ) {
        
                            $cost = 34826.34;
        
                        }
                        else if( $weight > 14 &&  $weight <=14.5 ) {
        
                            $cost = 35347.14 ;
        
                        }
                        else if( $weight > 14.5 &&  $weight <=15 ) {
        
                            $cost = 36030.32 ;
        
                        }
        
                    }
                    else if($country=="BH"){
                        if( $weight <=0.5) {
        
                            $cost = 7172.31;
        
                        } else if( $weight > 0.5 &&  $weight <=1) {
        
                            $cost = 7821.83;
        
                        } else if( $weight > 1 &&  $weight <=1.5 ) {
        
                            $cost =8473.32 ;
        
                        }
                        else if( $weight > 1.5 &&  $weight <=2 ) {
        
                            $cost = 9122.83;
        
                        }
                        else if( $weight > 2 &&  $weight <=2.5 ) {
        
                            $cost =10423.84 ;
        
                        }
                        else if( $weight > 2.5 &&  $weight <=3 ) {
        
                            $cost = 11073.36 ;
        
                        }
                        else if( $weight > 3 &&  $weight <=3.5 ) {
        
                            $cost = 11724.85;
        
                        }
                        else if( $weight > 3.5 &&  $weight <=4 ) {
        
                            $cost = 12374.36;
        
                        }
                        else if( $weight > 4 &&  $weight <=4.5 ) {
        
                            $cost =13025.85;
        
                        }
                        else if( $weight > 4.5 &&  $weight <=5 ) {
        
                            $cost = 17134.19;
        
                        }
                        else if( $weight > 5 &&  $weight <=5.5 ) {
        
                            $cost = 17929.79;
        
                        }
                        else if( $weight > 5.5 &&  $weight <=6 ) {
        
                            $cost = 18583.26;
        
                        }
                        else if( $weight > 6 &&  $weight <=6.5) {
        
                            $cost = 19234.75;
        
                        }
                        else if( $weight > 6.5 &&  $weight <=7 ) {
        
                            $cost = 19892.16 ;
        
                        }
                        else if( $weight > 7 &&  $weight <=7.5) {
        
                            $cost = 20413.35;
        
                        }
                        else if( $weight > 7.5 &&  $weight <=8 ) {
        
                            $cost =20948.36 ;
        
                        }
                        else if( $weight > 8 &&  $weight <=8.5 ) {
        
                            $cost = 21599.85;
        
                        }
                        else if( $weight > 8.5 &&  $weight <=9 ) {
        
                            $cost = 22253.32;
        
                        }
                        else if( $weight > 9 &&  $weight <=9.5) {
        
                            $cost =22900.86;
        
                        }
                        else if( $weight > 9.5 &&  $weight <=10 ) {
        
                            $cost = 30033.69;
        
                        }
                        else if( $weight > 10 &&  $weight <=10.5 ) {
        
                            $cost = 30722.69;
        
                        }
                        else if( $weight > 10.5 &&  $weight <=11 ) {
        
                            $cost = 31241.90;
        
                        }
                        else if( $weight > 11 &&  $weight <=11.5) {
        
                            $cost =31767.05 ;
        
                        }
                        else if( $weight > 11.5 &&  $weight <=12 ) {
        
                            $cost = 32306.01;
        
                        }
                        else if( $weight > 12 &&  $weight <=12.5) {
        
                            $cost = 32987.11;
        
                        }
                        else if( $weight > 12.5 &&  $weight <=13 ) {
        
                            $cost = 33670.19;
        
                        }
                        else if( $weight > 13 &&  $weight <=13.5 ) {
        
                            $cost = 34207.17;
        
                        }
                        else if( $weight > 13.5 &&  $weight <=14 ) {
        
                            $cost = 34720.47;
        
                        }
                        else if( $weight > 14 &&  $weight <=14.5 ) {
        
                            $cost =35239.68;
        
                        }
                        else if( $weight > 14.5 &&  $weight <=15 ) {
        
                            $cost =35920.79;
        
                        }
        
                    }
                    else if($country=="BD"){
                        if( $weight <=0.5) {
        
                            $cost =6266.15;
        
                        } else if( $weight > 0.5 &&  $weight <=1) {
        
                            $cost = 6799.19 ;
        
                        } else if( $weight > 1 &&  $weight <=1.5 ) {
        
                            $cost = 7332.22;
        
                        }
                        else if( $weight > 1.5 &&  $weight <=2 ) {
        
                            $cost = 7865.26;
        
                        }
                        else if( $weight > 2 &&  $weight <=2.5 ) {
        
                            $cost = 8931.34;
        
                        }
                        else if( $weight > 2.5 &&  $weight <=3 ) {
        
                            $cost =9464.37;
        
                        }
                        else if( $weight > 3 &&  $weight <=3.5 ) {
        
                            $cost = 9997.41;
        
                        }
                        else if( $weight > 3.5 &&  $weight <=4 ) {
        
                            $cost = 10530.45 ;
        
                        }
                        else if( $weight > 4 &&  $weight <=4.5 ) {
        
                            $cost =  11063.48;
        
                        }
                        else if( $weight > 4.5 &&  $weight <=5 ) {
        
                            $cost = 14508.48;
        
                        }
                        else if( $weight > 5 &&  $weight <=5.5 ) {
        
                            $cost = 15122.46;
        
                        }
                        else if( $weight > 5.5 &&  $weight <=6 ) {
        
                            $cost = 15489.67;
        
                        }
                        else if( $weight > 6 &&  $weight <=6.5) {
        
                            $cost = 15856.87;
        
                        }
                        else if( $weight > 6.5 &&  $weight <=7 ) {
        
                            $cost =16220.13;
        
                        }
                        else if( $weight > 7 &&  $weight <=7.5) {
        
                            $cost = 16587.33;
        
                        }
                        else if( $weight > 7.5 &&  $weight <=8 ) {
        
                            $cost = 16964.40;
        
                        }
                        else if( $weight > 8 &&  $weight <=8.5 ) {
        
                            $cost = 17321.74 ;
        
                        }
                        else if( $weight > 8.5 &&  $weight <=9 ) {
        
                            $cost =17688.94;
        
                        }
                        else if( $weight > 9 &&  $weight <=9.5) {
        
                            $cost =18066.01;
        
                        }
                        else if( $weight > 9.5 &&  $weight <=10 ) {
        
                            $cost =22174.35;
        
                        }
                        else if( $weight > 10 &&  $weight <=10.5 ) {
        
                            $cost = 22624.47 ;
        
                        }
                        else if( $weight > 10.5 &&  $weight <=11 ) {
        
                            $cost = 23080.51 ;
        
                        }
                        else if( $weight > 11 &&  $weight <=11.5) {
        
                            $cost = 23530.63;
        
                        }
                        else if( $weight > 11.5 &&  $weight <=12 ) {
        
                            $cost =23990.62;
        
                        }
                        else if( $weight > 12 &&  $weight <=12.5) {
        
                            $cost = 24452.59 ;
        
                        }
                        else if( $weight > 12.5 &&  $weight <=13 ) {
        
                            $cost = 24902.71 ;
        
                        }
                        else if( $weight > 13 &&  $weight <=13.5 ) {
        
                            $cost = 25364.68;
        
                        }
                        else if( $weight > 13.5 &&  $weight <=14 ) {
        
                            $cost = 25832.56 ;
        
                        }
                        else if( $weight > 14 &&  $weight <=14.5 ) {
        
                            $cost =26276.76;
        
                        }
                        else if( $weight > 14.5 &&  $weight <=15 ) {
        
                            $cost = 26732.80;
        
                        }
        
                    }
                    else if($country=="BT"){
                        if( $weight <=0.5) {
        
                            $cost = 7369.73 ;
        
                        } else if( $weight > 0.5 &&  $weight <=1) {
        
                            $cost = 7865.26 ;
        
                        } else if( $weight > 1 &&  $weight <=1.5 ) {
        
                            $cost =8605.59;
        
                        }
                        else if( $weight > 1.5 &&  $weight <=2 ) {
        
                            $cost = 9557.16;
        
                        }
                        else if( $weight > 2 &&  $weight <=2.5 ) {
        
                            $cost = 11458.33;
        
                        }
                        else if( $weight > 2.5 &&  $weight <=3 ) {
        
                            $cost = 12407.92 ;
        
                        }
                        else if( $weight > 3 &&  $weight <=3.5 ) {
        
                            $cost = 13359.49;
        
                        }
                        else if( $weight > 3.5 &&  $weight <=4 ) {
        
                            $cost =14309.09;
        
                        }
                        else if( $weight > 4 &&  $weight <=4.5 ) {
        
                            $cost = 15260.66;
        
                        }
                        else if( $weight > 4.5 &&  $weight <=5 ) {
        
                            $cost =16064.16;
        
                        }
                        else if( $weight > 5 &&  $weight <=5.5 ) {
        
                            $cost = 16869.64 ;
        
                        }
                        else if( $weight > 5.5 &&  $weight <=6 ) {
        
                            $cost = 17673.15 ;
        
                        }
                        else if( $weight > 6 &&  $weight <=6.5) {
        
                            $cost = 18476.65;
        
                        }
                        else if( $weight > 6.5 &&  $weight <=7 ) {
        
                            $cost = 19282.13;
        
                        }
                        else if( $weight > 7 &&  $weight <=7.5) {
        
                            $cost = 20085.63;
        
                        }
                        else if( $weight > 7.5 &&  $weight <=8 ) {
        
                            $cost = 20891.11;
        
                        }
                        else if( $weight > 8 &&  $weight <=8.5 ) {
        
                            $cost = 21694.62;
        
                        }
                        else if( $weight > 8.5 &&  $weight <=9 ) {
        
                            $cost = 22500.09;
        
                        }
                        else if( $weight > 9 &&  $weight <=9.5) {
        
                            $cost = 23307.55;
        
                        }
                        else if( $weight > 9.5 &&  $weight <=10 ) {
        
                            $cost = 25117.90;
        
                        }
                        else if( $weight > 10 &&  $weight <=10.5 ) {
        
                            $cost = 25958.91;
        
                        }
                        else if( $weight > 10.5 &&  $weight <=11 ) {
        
                            $cost =  26797.95;
        
                        }
                        else if( $weight > 11 &&  $weight <=11.5) {
        
                            $cost = 27638.97;
        
                        }
                        else if( $weight > 11.5 &&  $weight <=12 ) {
        
                            $cost =28479.98;
        
                        }
                        else if( $weight > 12 &&  $weight <=12.5) {
        
                            $cost = 29321.00;
        
                        }
                        else if( $weight > 12.5 &&  $weight <=13 ) {
        
                            $cost = 30160.04;
        
                        }
                        else if( $weight > 13 &&  $weight <=13.5 ) {
        
                            $cost = 31001.05;
        
                        }
                        else if( $weight > 13.5 &&  $weight <=14 ) {
        
                            $cost = 31842.07;
        
                        }
                        else if( $weight > 14 &&  $weight <=14.5 ) {
        
                            $cost = 32683.08;
        
                        }
                        else if( $weight > 14.5 &&  $weight <=15 ) {
        
                            $cost = 33522.12 ;
        
                        }
        
                    }
        
                    else if($country=="BW"){
                        if( $weight <=0.5) {
        
                            $cost = 10242.21;
        
                        } else if( $weight > 0.5 &&  $weight <=1) {
        
                            $cost =  10585.72;
        
                        } else if( $weight > 1 &&  $weight <=1.5 ) {
        
                            $cost = 11888.70;
        
                        }
                        else if( $weight > 1.5 &&  $weight <=2 ) {
        
                            $cost = 13189.71;
        
                        }
                        else if( $weight > 2 &&  $weight <=2.5 ) {
        
                            $cost = 15082.98;
        
                        }
                        else if( $weight > 2.5 &&  $weight <=3 ) {
        
                            $cost = 16364.24;
        
                        }
                        else if( $weight > 3 &&  $weight <=3.5 ) {
        
                            $cost =17647.48;
        
                        }
                        else if( $weight > 3.5 &&  $weight <=4 ) {
        
                            $cost = 18928.74;
        
                        }
                        else if( $weight > 4 &&  $weight <=4.5 ) {
        
                            $cost = 20210.01;
        
                        }
                        else if( $weight > 4.5 &&  $weight <=5 ) {
        
                            $cost = 21493.25;
        
                        }
                        else if( $weight > 5 &&  $weight <=5.5 ) {
        
                            $cost = 22774.51;
        
                        }
                        else if( $weight > 5.5 &&  $weight <=6 ) {
        
                            $cost =  24055.77;
        
                        }
                        else if( $weight > 6 &&  $weight <=6.5) {
        
                            $cost = 25337.04;
        
                        }
                        else if( $weight > 6.5 &&  $weight <=7 ) {
        
                            $cost = 26620.27;
        
                        }
                        else if( $weight > 7 &&  $weight <=7.5) {
        
                            $cost = 27901.54;
        
                        }
                        else if( $weight > 7.5 &&  $weight <=8 ) {
        
                            $cost =29182.80;
        
                        }
                        else if( $weight > 8 &&  $weight <=8.5 ) {
        
                            $cost = 30466.04;
        
                        }
                        else if( $weight > 8.5 &&  $weight <=9 ) {
        
                            $cost = 31747.30;
        
                        }
                        else if( $weight > 9 &&  $weight <=9.5) {
        
                            $cost = 33032.52;
        
                        }
                        else if( $weight > 9.5 &&  $weight <=10 ) {
        
                            $cost =36821.03;
        
                        }
                        else if( $weight > 10 &&  $weight <=10.5 ) {
        
                            $cost = 38161.52;
        
                        }
                        else if( $weight > 10.5 &&  $weight <=11 ) {
        
                            $cost = 39502.01;
        
                        }
                        else if( $weight > 11 &&  $weight <=11.5) {
        
                            $cost = 40840.52 ;
        
                        }
                        else if( $weight > 11.5 &&  $weight <=12 ) {
        
                            $cost = 42181.01 ;
        
                        }
                        else if( $weight > 12 &&  $weight <=12.5) {
        
                            $cost =43521.50 ;
        
                        }
                        else if( $weight > 12.5 &&  $weight <=13 ) {
        
                            $cost = 44861.99;
        
                        }
                        else if( $weight > 13 &&  $weight <=13.5 ) {
        
                            $cost = 46200.51;
        
                        }
                        else if( $weight > 13.5 &&  $weight <=14 ) {
        
                            $cost = 47541.00;
        
                        }
                        else if( $weight > 14 &&  $weight <=14.5 ) {
        
                            $cost =  48881.49;
        
                        }
                        else if( $weight > 14.5 &&  $weight <=15 ) {
        
                            $cost = 50220.00;
        
                        }
        
                    }
                    else if($country=="BN"){
                        if( $weight <=0.5) {
        
                            $cost = 6266.15;
        
                        } else if( $weight > 0.5 &&  $weight <=1) {
        
                            $cost = 6799.19 ;
        
                        } else if( $weight > 1 &&  $weight <=1.5 ) {
        
                            $cost =7332.22;
        
                        }
                        else if( $weight > 1.5 &&  $weight <=2 ) {
        
                            $cost =  7865.26;
        
                        }
                        else if( $weight > 2 &&  $weight <=2.5 ) {
        
                            $cost =  8931.34;
        
                        }
                        else if( $weight > 2.5 &&  $weight <=3 ) {
        
                            $cost = 9464.37;
        
                        }
                        else if( $weight > 3 &&  $weight <=3.5 ) {
        
                            $cost =9997.41;
        
                        }
                        else if( $weight > 3.5 &&  $weight <=4 ) {
        
                            $cost =10530.45;
        
                        }
                        else if( $weight > 4 &&  $weight <=4.5 ) {
        
                            $cost =11063.48;
        
                        }
                        else if( $weight > 4.5 &&  $weight <=5 ) {
        
                            $cost = 14508.48;
        
                        }
                        else if( $weight > 5 &&  $weight <=5.5 ) {
        
                            $cost =15122.46;
        
                        }
                        else if( $weight > 5.5 &&  $weight <=6 ) {
        
                            $cost = 15489.67;
        
                        }
                        else if( $weight > 6 &&  $weight <=6.5) {
        
                            $cost = 15856.87;
        
                        }
                        else if( $weight > 6.5 &&  $weight <=7 ) {
        
                            $cost =16220.13;
        
                        }
                        else if( $weight > 7 &&  $weight <=7.5) {
        
                            $cost = 16587.33 ;
        
                        }
                        else if( $weight > 7.5 &&  $weight <=8 ) {
        
                            $cost = 16964.40;
        
                        }
                        else if( $weight > 8 &&  $weight <=8.5 ) {
        
                            $cost =17321.74;
        
                        }
                        else if( $weight > 8.5 &&  $weight <=9 ) {
        
                            $cost =17688.94;
        
                        }
                        else if( $weight > 9 &&  $weight <=9.5) {
        
                            $cost = 18066.01;
        
                        }
                        else if( $weight > 9.5 &&  $weight <=10 ) {
        
                            $cost = 22174.35;
        
                        }
                        else if( $weight > 10 &&  $weight <=10.5 ) {
        
                            $cost = 22624.47;
        
                        }
                        else if( $weight > 10.5 &&  $weight <=11 ) {
        
                            $cost = 23080.51;
        
                        }
                        else if( $weight > 11 &&  $weight <=11.5) {
        
                            $cost = 23530.63;
        
                        }
                        else if( $weight > 11.5 &&  $weight <=12 ) {
        
                            $cost = 23990.62;
        
                        }
                        else if( $weight > 12 &&  $weight <=12.5) {
        
                            $cost =24452.59;
        
                        }
                        else if( $weight > 12.5 &&  $weight <=13 ) {
        
                            $cost =24902.71;
        
                        }
                        else if( $weight > 13 &&  $weight <=13.5 ) {
        
                            $cost = 25364.68 ;
        
                        }
                        else if( $weight > 13.5 &&  $weight <=14 ) {
        
                            $cost = 25832.56;
        
                        }
                        else if( $weight > 14 &&  $weight <=14.5 ) {
        
                            $cost = 26276.76;
        
                        }
                        else if( $weight > 14.5 &&  $weight <=15 ) {
        
                            $cost = 26732.80;
        
                        }
        
                    }
                    else if($country=="BI"){
                        if( $weight <=0.5) {
        
                            $cost =7172.31;
        
                        } else if( $weight > 0.5 &&  $weight <=1) {
        
                            $cost = 7821.83;
        
                        } else if( $weight > 1 &&  $weight <=1.5 ) {
        
                            $cost = 8473.32;
        
                        }
                        else if( $weight > 1.5 &&  $weight <=2 ) {
        
                            $cost =9122.83;
        
                        }
                        else if( $weight > 2 &&  $weight <=2.5 ) {
        
                            $cost =10423.84;
        
                        }
                        else if( $weight > 2.5 &&  $weight <=3 ) {
        
                            $cost = 11073.36;
        
                        }
                        else if( $weight > 3 &&  $weight <=3.5 ) {
        
                            $cost = 11724.85;
        
                        }
                        else if( $weight > 3.5 &&  $weight <=4 ) {
        
                            $cost = 12374.36;
        
                        }
                        else if( $weight > 4 &&  $weight <=4.5 ) {
        
                            $cost = 13025.85;
        
                        }
                        else if( $weight > 4.5 &&  $weight <=5 ) {
        
                            $cost = 17134.19;
        
                        }
                        else if( $weight > 5 &&  $weight <=5.5 ) {
        
                            $cost = 17929.79;
        
                        }
                        else if( $weight > 5.5 &&  $weight <=6 ) {
        
                            $cost = 18583.26;
        
                        }
                        else if( $weight > 6 &&  $weight <=6.5) {
        
                            $cost = 19234.75;
        
                        }
                        else if( $weight > 6.5 &&  $weight <=7 ) {
        
                            $cost =19892.16;
        
                        }
                        else if( $weight > 7 &&  $weight <=7.5) {
        
                            $cost =  20413.35 ;
        
                        }
                        else if( $weight > 7.5 &&  $weight <=8 ) {
        
                            $cost = 20948.36 ;
        
                        }
                        else if( $weight > 8 &&  $weight <=8.5 ) {
        
                            $cost =21599.85;
        
                        }
                        else if( $weight > 8.5 &&  $weight <=9 ) {
        
                            $cost = 22253.32 ;
        
                        }
                        else if( $weight > 9 &&  $weight <=9.5) {
        
                            $cost = 22900.86;
        
                        }
                        else if( $weight > 9.5 &&  $weight <=10 ) {
        
                            $cost = 30033.69;
        
                        }
                        else if( $weight > 10 &&  $weight <=10.5 ) {
        
                            $cost =30722.69;
        
                        }
                        else if( $weight > 10.5 &&  $weight <=11 ) {
        
                            $cost = 31241.90;
        
                        }
                        else if( $weight > 11 &&  $weight <=11.5) {
        
                            $cost = 31767.05;
        
                        } 
                        else if( $weight > 11.5 &&  $weight <=12 ) {
        
                            $cost = 32306.01 ;
        
                        }
                        else if( $weight > 12 &&  $weight <=12.5) {
        
                            $cost = 32987.11;
        
                        }
                        else if( $weight > 12.5 &&  $weight <=13 ) {
        
                            $cost =  33670.19;
        
                        }
                        else if( $weight > 13 &&  $weight <=13.5 ) {
        
                            $cost = 34207.17;
        
                        }
                        else if( $weight > 13.5 &&  $weight <=14 ) {
        
                            $cost =34720.47;
        
                        }
                        else if( $weight > 14 &&  $weight <=14.5 ) {
        
                            $cost =35239.68;
        
                        }
                        else if( $weight > 14.5 &&  $weight <=15 ) {
        
                            $cost =35920.79;
        
                        }
        
                    }

                    
    else if($country=="KH"){
        if( $weight <=0.5) {

            $cost = 6814.98;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7405.27;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost = 8242.34;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost = 9079.40;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost = 10753.53 ;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =  11590.60;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =12427.66;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =13264.73;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =14101.80;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost = 14802.64;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =15503.49;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost = 16204.33;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =16905.18;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost = 17606.02;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =18306.87;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost = 19007.71;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =19708.56;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =20411.38;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost = 21114.20;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost = 27966.69;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =28853.11;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =29739.53;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost = 30623.98;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =31510.40;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost = 32396.82;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =33283.24;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 34167.69;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost = 35054.11;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost = 35940.53;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost = 36824.98;

        }

    }
    else if($country=="CF"){
        if( $weight <=0.5) {

            $cost =11482.02;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =12885.68;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =14297.24 ;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost = 15724.60;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =18531.93;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost = 19641.44;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost = 20739.10;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =21832.81;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost = 22942.32;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost = 25159.36;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost = 26320.19;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost = 27299.40;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost = 28286.51;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =29299.28;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost = 30100.81 ;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost = 30920.11;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =31913.14;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =32925.91;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost = 33899.19;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =43118.76;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =44141.41;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost = 45142.33;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =46172.87;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost = 47187.62;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost = 48218.15;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost = 49242.77;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 50265.41;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost = 51280.16;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost = 52288.98;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost = 53319.52;

        }

    }
    else if($country=="TD"){
        if( $weight <=0.5) {

            $cost = 6968.97;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7620.46;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8269.97 ;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost = 8921.46 ;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =10220.50;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =10871.99 ;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =11521.50;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =  12172.99;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =12822.51;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost = 14954.66;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost = 15604.17;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =16255.66;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost = 16905.18;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost = 17556.67;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost = 18206.18;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =18855.70;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost = 19507.19;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost = 20156.70;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =20808.19 ;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost = 26659.76;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =27263.87;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost = 27702.14;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =28156.21;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost = 28594.49;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost = 29174.90;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost = 29773.09;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =30361.41;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost = 30809.55;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =31269.54;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost = 31846.01;

        }

    }
    else if($country=="CN"){  
        if( $weight <=0.5) {

            $cost =6814.98;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost = 7405.27;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8242.34;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost = 9079.40;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost = 10753.53;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11590.60;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =12427.66 ;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =13264.73;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =14101.80;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost = 14802.64;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost = 15503.49;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =16204.33;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost = 16905.18;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost = 17606.02;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =18306.87;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost = 19007.71;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost = 19708.56;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost = 20411.38;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =21114.20;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =27966.69;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost = 28853.11;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost = 29739.53;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost = 30623.98;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost = 31510.40;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost = 32396.82;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost = 33283.24;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 34167.69 ;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =35054.11 ;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost = 35940.53;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost = 36824.98;

        }

    }

    else if($country=="CG"){  
        if( $weight <=0.5) {

            $cost =8913.57;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost = 9726.94;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =10526.50;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =11324.08;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =12858.04;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =13491.76;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =14139.31;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =14784.87;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =15426.49;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =20206.06;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =21056.95;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =21797.27;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =22531.68;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =23279.91;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =24020.24;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =24756.62;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =25496.95;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =26233.33;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =26981.56;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =35498.31;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =36339.32;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =37186.26;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =37885.13;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =38570.18;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =39421.07;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =40246.29;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 41093.22 ;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =41918.44;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =42755.51;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost = 43600.47;

        }

    }

    else if($country=="CI"){  
        if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }

    else if($country=="EG"){  
        if( $weight <=0.5) {

            $cost =7172.31;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7821.83;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8473.32;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =9122.83;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =10423.84;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11073.36;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =11724.85;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =12374.36;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =13025.85;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =17134.19;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =17929.79;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =18583.26;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =19234.75;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =19892.16;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =20413.35;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =20948.36;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =21599.85;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =22253.32;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =22900.86;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =30033.69;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =30722.69;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =31241.90;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =31767.05;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =32306.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =32987.11;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =33670.19;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 34207.17;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =34720.47;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =35239.68;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =35920.79;

        }

    }

    else if($country=="ET"){  
        if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }

    else if($country=="FJ"){  
        if( $weight <=0.5) {

            $cost =6814.98;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7405.27;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8242.34;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =9079.40;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =10753.53;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11590.60;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =12427.66;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =13264.73;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =14101.80;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =14802.64;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =15503.49;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =16204.33;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =16905.18;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =17606.02;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =18306.87;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =19007.71;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =19708.56;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =20411.38;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =21114.20;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =27966.69;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =28853.11;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =29739.53;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =30623.98;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =31510.40;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =32396.82;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =33283.24;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =34167.69;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =35054.11;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =35940.53;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =36824.98;

        }

    }

    else if($country=="GM"){  
        if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }

    else if($country=="GH"){  
        if( $weight <=0.5) {

            $cost =8913.57;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =9726.94;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =10526.50;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =11324.08;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =12858.04;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =13491.76;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =14139.31;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =14784.87;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =15426.49;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =20206.06;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =21056.95;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =21797.27;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =22531.68;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =23279.91;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =24020.24;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =24756.62;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =25496.95;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =26233.33;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =26981.56;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =35498.31;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =36339.32;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =37186.26;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =37885.13;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =38570.18;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =39421.07;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =40246.29;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =41093.22;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =41918.44;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =42755.51;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =43600.47;

        }

    }

    else if($country=="GN"){  
        if( $weight <=0.5) {

            $cost =10258.97;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10603.05;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11908.16;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13211.30;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15107.66;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16391.03;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17676.36;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18959.72;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20243.08;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21528.42;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22811.78;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24095.14;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25378.50;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26663.84;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27947.20;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29230.56;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30515.90;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31799.26;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33086.58;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36881.29;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38223.97;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39566.66;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40907.36;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42250.05;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43592.73;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44935.41;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46276.12;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47618.80;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48961.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50302.20;

        }

    }


    else if($country=="HK"){  
        if( $weight <=0.5) {

            $cost =6276.40;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =6810.31;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =7344.22;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =7878.13;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =8945.95;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =9479.86;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =10013.77;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =10547.68;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =11081.59;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =14532.23;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =15147.21;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =15515.02;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =15882.82;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =16246.67;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =16614.48;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =16992.17;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =17350.08;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =17717.89;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =18095.58;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =22210.64;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =22661.50;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =23118.29;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =23569.14;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =24029.89;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =24492.61;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =24943.47;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =25406.19;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =25874.84;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =26319.77;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =26776.56;

        }

    }


    else if($country=="IN"){  
        if( $weight <=0.5) {

            $cost =6276.40;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =6810.31;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =7344.22;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =7878.13;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =8945.95;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =9479.86;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =10013.77;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =10547.68;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =11081.59;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =14532.23;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =15147.21;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =15515.02;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =15882.82;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =16246.67;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =16614.48;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =16992.17;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =17350.08;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =17717.89;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =18095.58;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =22210.64;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =22661.50;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =23118.29;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =23569.14;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =24029.89;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =24492.61;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =24943.47;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =25406.19;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =25874.84;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =26319.77;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =26776.56;

        }

    }
    else if($country=="ID"){  
        if( $weight <=0.5) {

            $cost =6276.40;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =6810.31;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =7344.22;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =7878.13;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =8945.95;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =9479.86;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =10013.77;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =10547.68;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =11081.59;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =14532.23;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =15147.21;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =15515.02;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =15882.82;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =16246.67;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =16614.48;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =16992.17;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =17350.08;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =17717.89;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =18095.58;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =22210.64;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =22661.50;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =23118.29;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =23569.14;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =24029.89;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =24492.61;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =24943.47;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =25406.19;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =25874.84;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =26319.77;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =26776.56;

        }

    }

    else if($country=="IQ"){  
        if( $weight <=0.5) {

            $cost =7381.79;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7878.13;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8619.67;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =9572.80;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =11477.08;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =12428.23;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =13381.36;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =14332.51;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =15285.63;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =16090.45;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =16897.25;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =17702.07;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =18506.89;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =19313.69;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =20118.51;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =20925.30;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =21730.12;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =22536.92;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =23345.69;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =25159.01;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =26001.40;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =26841.81;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =27684.20;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =28526.59;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =29368.98;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =30209.40;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =31051.79;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =31894.18;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =32736.57;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =33576.98;

        }

    }
    else if($country=="IL"){  
        if( $weight <=0.5) {

            $cost =7184.05;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7834.63;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8487.19;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =9137.76;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =10440.90;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11091.48;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =11744.03;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =12394.61;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =13047.17;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =17162.23;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =17959.14;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =18613.67;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =19266.23;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =19924.72;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =20446.76;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =20982.65;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =21635.20;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =22289.74;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =22938.34;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =30082.84;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =30772.97;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =31293.04;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =31819.04;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =32358.88;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =33041.10;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =33725.29;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =34263.15;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =34777.29;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =35297.36;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =35979.58;

        }

    }


    else if($country=="JO"){  
        if( $weight <=0.5) {

            $cost =6276.40;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =6810.31;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =7344.22;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =7878.13;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =8945.95;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =9479.86;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =10013.77;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =10547.68;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =11081.59;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =14532.23;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =15147.21;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =15515.02;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =15882.82;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =16246.67;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =16614.48;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =16992.17;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =17350.08;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =17717.89;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =18095.58;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =22210.64;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =22661.50;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =23118.29;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =23569.14;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =24029.89;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =24492.61;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =24943.47;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =25406.19;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =25874.84;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =26319.77;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =26776.56;

        }

    }






else if($country=="KZ"){  
        if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }






else if($country=="KE"){  
        if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }





else if($country=="KW"){  
        if( $weight <=0.5) {

            $cost =7381.79;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7878.13;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8619.67;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =9572.80;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =11477.08;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =12428.23;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =13381.36;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =14332.51;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =15285.63;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =16090.45;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =16897.25;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =17702.07;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =18506.89;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =19313.69;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =20118.51;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =20925.30;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =21730.12;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =22536.92;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =23345.69;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =25159.01;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =26001.40;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =26841.81;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =27684.20;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =28526.59;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =29368.98;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =30209.40;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =31051.79;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =31894.18;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =32736.57;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =33576.98;

        }

    }





else if($country=="KG"){  
        if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }





else if($country=="LA"){  
        if( $weight <=0.5) {

            $cost =6814.98;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost = 7405.27;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8242.34;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost = 9079.40;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost = 10753.53;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11590.60;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =12427.66 ;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =13264.73;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =14101.80;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost = 14802.64;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost = 15503.49;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =16204.33;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost = 16905.18;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost = 17606.02;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =18306.87;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost = 19007.71;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost = 19708.56;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost = 20411.38;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =21114.20;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =27966.69;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost = 28853.11;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost = 29739.53;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost = 30623.98;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost = 31510.40;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost = 32396.82;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost = 33283.24;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 34167.69 ;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =35054.11 ;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost = 35940.53;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost = 36824.98;

        }

    }

    else if($country=="LB"){  
        if( $weight <=0.5) {

            $cost =7381.79;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7878.13;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8619.67;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =9572.80;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =11477.08;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =12428.23;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =13381.36;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =14332.51;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =15285.63;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =16090.45;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =16897.25;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =17702.07;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =18506.89;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =19313.69;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =20118.51;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =20925.30;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =21730.12;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =22536.92;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =23345.69;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =25159.01;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =26001.40;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =26841.81;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =27684.20;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =28526.59;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =29368.98;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =30209.40;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =31051.79;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =31894.18;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =32736.57;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =33576.98;

        }

    }






else if($country=="LS"){  
        if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }





else if($country=="LR"){  
        if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }





else if($country=="LY"){  
        if( $weight <=0.5) {

            $cost =8913.57;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =9726.94;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =10526.50;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =11324.08;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =12858.04;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =13491.76;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =14139.31;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =14784.87;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =15426.49;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =20206.06;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =21056.95;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =21797.27;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =22531.68;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =23279.91;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =24020.24;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =24756.62;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =25496.95;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =26233.33;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =26981.56;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =35498.31;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =36339.32;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =37186.26;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =37885.13;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =38570.18;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =39421.07;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =40246.29;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =41093.22;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =41918.44;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =42755.51;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =43600.47;

        }

    }

    else if($country=="MG"){  
        if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }





else if($country=="MW"){
        if( $weight <=0.5) {

            $cost =11482.02;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =12885.68;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =14297.24 ;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost = 15724.60;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =18531.93;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost = 19641.44;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost = 20739.10;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =21832.81;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost = 22942.32;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost = 25159.36;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost = 26320.19;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost = 27299.40;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost = 28286.51;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =29299.28;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost = 30100.81 ;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost = 30920.11;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =31913.14;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =32925.91;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost = 33899.19;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =43118.76;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =44141.41;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost = 45142.33;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =46172.87;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost = 47187.62;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost = 48218.15;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost = 49242.77;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 50265.41;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost = 51280.16;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost = 52288.98;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost = 53319.52;

        }

    }






else if($country=="MY"){  
        if( $weight <=0.5) {

            $cost =6814.98;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost = 7405.27;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8242.34;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost = 9079.40;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost = 10753.53;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11590.60;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =12427.66 ;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =13264.73;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =14101.80;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost = 14802.64;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost = 15503.49;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =16204.33;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost = 16905.18;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost = 17606.02;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =18306.87;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost = 19007.71;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost = 19708.56;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost = 20411.38;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =21114.20;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =27966.69;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost = 28853.11;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost = 29739.53;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost = 30623.98;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost = 31510.40;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost = 32396.82;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost = 33283.24;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 34167.69 ;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =35054.11 ;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost = 35940.53;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost = 36824.98;

        }

    }





else if($country=="MV"){  
        if( $weight <=0.5) {

            $cost =4730.04;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =4921.86;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =5362.83;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =5803.80;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =6683.76;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =7124.73;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =7565.70;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =8006.67;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =8445.66;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =8886.63;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =9327.60;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =9768.57;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =10207.56;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =10648.53;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =11089.50;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =11530.47;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =11969.46;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =12412.41;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =12855.36;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =13300.28;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =13743.23;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =14188.15;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =14631.10;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =15076.03;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =15518.97;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =16005.60;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =16449.71;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =16895.79;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =17339.90;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =17784.00;

        }

    }





else if($country=="MU"){  
        if( $weight <=0.5) {

            $cost =8951.48;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =9768.31;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =10571.27;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =11372.25;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =12912.73;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =13549.15;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =14199.45;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =14847.76;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =15492.11;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =20292.00;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =21146.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =21889.99;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =22627.52;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =23378.93;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =24122.40;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =24861.92;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =11969.46;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =26344.91;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =27096.32;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =35649.29;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =36493.88;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =37344.42;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =38046.27;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =38734.23;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =39588.74;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =40417.47;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =41268.01;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =42096.74;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =42937.36;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =43785.92;

        }

    }






else if($country=="MN"){  
        if( $weight <=0.5) {

            $cost =6721.04;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7363.41;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8005.78;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =8648.14;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =9932.87;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =10575.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =11217.60;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =11859.97;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =12502.33;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =15139.20;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =15801.39;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =16354.54;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =16907.69;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =17444.98;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =18004.07;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =18561.19;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =19108.39;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =19665.50;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =20214.68;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =26773.15;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =27379.83;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =27819.97;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =28275.97;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =28716.11;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =29299.00;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =29899.73;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =30490.54;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =30940.60;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =31402.54;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =31981.47;

        }

    }





else if($country=="MA"){  
        if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }





else if($country=="MZ"){  
        if( $weight <=0.5) {

            $cost =11909.53;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =12276.31;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =13681.98;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =15085.67;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =17105.95;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =18489.81;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =19873.67;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }






else if($country=="MM"){  
        if( $weight <=0.5) {

            $cost =6814.98;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost = 7405.27;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8242.34;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost = 9079.40;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost = 10753.53;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11590.60;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =12427.66 ;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =13264.73;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =14101.80;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost = 14802.64;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost = 15503.49;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =16204.33;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost = 16905.18;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost = 17606.02;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =18306.87;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost = 19007.71;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost = 19708.56;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost = 20411.38;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =21114.20;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =27966.69;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost = 28853.11;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost = 29739.53;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost = 30623.98;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost = 31510.40;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost = 32396.82;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost = 33283.24;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 34167.69 ;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =35054.11 ;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost = 35940.53;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost = 36824.98;

        }

    }





else if($country=="NA"){  
        if( $weight <=0.5) {

            $cost =6276.40;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =6810.31;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =7344.22;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =7878.13;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =8945.95;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =9479.86;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =10013.77;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =10547.68;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =11081.59;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =14532.23;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =15147.21;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =15515.02;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =15882.82;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =16246.67;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =16614.48;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =16992.17;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =17350.08;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =17717.89;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =18095.58;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =22210.64;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =22661.50;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =23118.29;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =23569.14;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =24029.89;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =24492.61;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =24943.47;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =25406.19;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =25874.84;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =26319.77;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =26776.56;

        }

    }





else if($country=="NP"){  
        if( $weight <=0.5) {

            $cost =6721.04;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7363.41;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8005.78;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =8648.14;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =9932.87;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =10575.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =11217.60;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =11859.97;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =12502.33;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =15139.20;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =15801.39;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =16354.54;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =16907.69;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =17444.98;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =18004.07;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =18561.19;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =19108.39;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =19665.50;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =20214.68;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =26773.15;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =27379.83;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =27819.97;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =28275.97;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =28716.11;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =29299.00;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =29899.73;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =30490.54;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =30940.60;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =31402.54;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =31981.47;

        }

    }





else if($country=="NZ"){  
        if( $weight <=0.5) {

            $cost =6721.04;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7363.41;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8005.78;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =8648.14;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =9932.87;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =10575.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =11217.60;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =11859.97;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =12502.33;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =15139.20;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =15801.39;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =16354.54;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =16907.69;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =17444.98;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =18004.07;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =18561.19;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =19108.39;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =19665.50;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =20214.68;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =26773.15;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =27379.83;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =27819.97;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =28275.97;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =28716.11;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =29299.00;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =29899.73;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =30490.54;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =30940.60;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =31402.54;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =31981.47;

        }

    }





else if($country=="NE"){
        if( $weight <=0.5) {

            $cost =11482.02;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =12885.68;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =14297.24 ;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost = 15724.60;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =18531.93;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost = 19641.44;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost = 20739.10;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =21832.81;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost = 22942.32;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost = 25159.36;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost = 26320.19;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost = 27299.40;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost = 28286.51;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =29299.28;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost = 30100.81 ;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost = 30920.11;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =31913.14;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =32925.91;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost = 33899.19;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =43118.76;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =44141.41;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost = 45142.33;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =46172.87;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost = 47187.62;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost = 48218.15;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost = 49242.77;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 50265.41;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost = 51280.16;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost = 52288.98;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost = 53319.52;

        }

    }





else if($country=="NG"){  
        if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }





    else if($country=="OM"){  
        if( $weight <=0.5) {

            $cost =7184.05;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7834.63;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8487.19;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =9137.76;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =10440.90;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11091.48;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =11744.03;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =12394.61;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =13047.17;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =17162.23;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =17959.14;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =18613.67;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =19266.23;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =19924.72;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =20446.76;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =20982.65;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =21635.20;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =22289.74;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =22938.34;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =30082.84;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =30772.97;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =31293.04;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =31819.04;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =32358.88;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =33041.10;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =33725.29;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =34263.15;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =34777.29;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =35297.36;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =35979.58;

        }

    }





else if($country=="PK"){  
        if( $weight <=0.5) {

            $cost =7184.05;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7834.63;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8487.19;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =9137.76;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =10440.90;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11091.48;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =11744.03;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =12394.61;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =13047.17;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =17162.23;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =17959.14;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =18613.67;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =19266.23;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =19924.72;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =20446.76;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =20982.65;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =21635.20;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =22289.74;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =22938.34;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =30082.84;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =30772.97;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =31293.04;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =31819.04;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =32358.88;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =33041.10;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =33725.29;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =34263.15;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =34777.29;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =35297.36;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =35979.58;

        }

    }






else if($country=="PS"){  
        if( $weight <=0.5) {

            $cost =6276.40;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =6810.31;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =7344.22;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =7878.13;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =8945.95;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =9479.86;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =10013.77;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =10547.68;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =11081.59;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =14532.23;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =15147.21;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =15515.02;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =15882.82;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =16246.67;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =16614.48;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =16992.17;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =17350.08;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =17717.89;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =18095.58;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =22210.64;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =22661.50;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =23118.29;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =23569.14;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =24029.89;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =24492.61;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =24943.47;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =25406.19;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =25874.84;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =26319.77;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =26776.56;

        }

    }





else if($country=="PG"){  
        if( $weight <=0.5) {

            $cost =6814.98;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost = 7405.27;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8242.34;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost = 9079.40;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost = 10753.53;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11590.60;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =12427.66 ;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =13264.73;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =14101.80;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost = 14802.64;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost = 15503.49;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =16204.33;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost = 16905.18;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost = 17606.02;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =18306.87;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost = 19007.71;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost = 19708.56;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost = 20411.38;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =21114.20;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =27966.69;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost = 28853.11;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost = 29739.53;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost = 30623.98;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost = 31510.40;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost = 32396.82;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost = 33283.24;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 34167.69 ;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =35054.11 ;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost = 35940.53;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost = 36824.98;

        }

    }





else if($country=="PH"){  
        if( $weight <=0.5) {

            $cost =6814.98;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost = 7405.27;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8242.34;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost = 9079.40;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost = 10753.53;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11590.60;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =12427.66 ;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =13264.73;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =14101.80;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost = 14802.64;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost = 15503.49;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =16204.33;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost = 16905.18;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost = 17606.02;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =18306.87;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost = 19007.71;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost = 19708.56;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost = 20411.38;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =21114.20;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =27966.69;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost = 28853.11;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost = 29739.53;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost = 30623.98;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost = 31510.40;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost = 32396.82;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost = 33283.24;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost = 34167.69 ;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =35054.11 ;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost = 35940.53;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost = 36824.98;

        }

    }





else if($country=="QA"){  
        if( $weight <=0.5) {

            $cost =7184.05;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7834.63;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8487.19;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =9137.76;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =10440.90;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11091.48;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =11744.03;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =12394.61;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =13047.17;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =17162.23;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =17959.14;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =18613.67;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =19266.23;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =19924.72;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =20446.76;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =20982.65;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =21635.20;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =22289.74;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =22938.34;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =30082.84;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =30772.97;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =31293.04;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =31819.04;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =32358.88;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =33041.10;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =33725.29;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =34263.15;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =34777.29;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =35297.36;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =35979.58;

        }

    }





else if($country=="RW"){
       if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }





else if($country=="SA"){  
        if( $weight <=0.5) {

            $cost =7184.05;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7834.63;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8487.19;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =9137.76;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =10440.90;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11091.48;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =11744.03;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =12394.61;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =13047.17;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =17162.23;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =17959.14;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =18613.67;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =19266.23;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =19924.72;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =20446.76;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =20982.65;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =21635.20;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =22289.74;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =22938.34;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =30082.84;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =30772.97;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =31293.04;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =31819.04;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =32358.88;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =33041.10;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =33725.29;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =34263.15;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =34777.29;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =35297.36;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =35979.58;

        }

    }





else if($country=="SN"){  
        if( $weight <=0.5) {

            $cost =11909.53;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =12276.31;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =13681.98;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =15085.67;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =17105.95;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =18489.81;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =19873.67;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }





else if($country=="SC"){
          if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }






else if($country=="SL"){
           if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }




else if($country=="SG"){
        if( $weight <=0.5) {

            $cost =6485.11;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =6919.31;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =14297.24 ;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =7599.34;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =8281.36;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =10277.85;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost = 10936.07;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =11594.30;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =12252.52;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =12910.75;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =13568.98;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =14227.20;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =14885.43;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =15543.65;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =16201.88;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =16860.11;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =17518.33;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =18178.54;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =18840.73;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =19445.43;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =20050.12;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =20654.82;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =21259.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =21864.21;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =22468.91;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =23073.60;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =23678.30;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =24283.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost = 24887;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =25490.40;

        }

    }





else if($country=="SB"){  
        if( $weight <=0.5) {

            $cost =7184.05;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =7834.63;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =8487.19;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =9137.76;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =10440.90;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =11091.48;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =11744.03;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =12394.61;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =13047.17;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =17162.23;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =17959.14;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =18613.67;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =19266.23;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =19924.72;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =20446.76;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =20982.65;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =21635.20;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =22289.74;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =22938.34;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =30082.84;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =30772.97;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =31293.04;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =31819.04;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =32358.88;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =33041.10;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =33725.29;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =34263.15;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =34777.29;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =35297.36;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =35979.58;

        }

    }





else if($country=="SO"){
           if( $weight <=0.5) {

            $cost =10242.21;

        } else if( $weight > 0.5 &&  $weight <=1) {

            $cost =10585.72;

        } else if( $weight > 1 &&  $weight <=1.5 ) {

            $cost =11888.70;

        }
        else if( $weight > 1.5 &&  $weight <=2 ) {

            $cost =13189.71;

        }
        else if( $weight > 2 &&  $weight <=2.5 ) {

            $cost =15082.98;

        }
        else if( $weight > 2.5 &&  $weight <=3 ) {

            $cost =16364.24;

        }
        else if( $weight > 3 &&  $weight <=3.5 ) {

            $cost =17647.48;

        }
        else if( $weight > 3.5 &&  $weight <=4 ) {

            $cost =18928.74;

        }
        else if( $weight > 4 &&  $weight <=4.5 ) {

            $cost =20210.01;

        }
        else if( $weight > 4.5 &&  $weight <=5 ) {

            $cost =21493.25;

        }
        else if( $weight > 5 &&  $weight <=5.5 ) {

            $cost =22774.51;

        }
        else if( $weight > 5.5 &&  $weight <=6 ) {

            $cost =24055.77;

        }
        else if( $weight > 6 &&  $weight <=6.5) {

            $cost =25337.04;

        }
        else if( $weight > 6.5 &&  $weight <=7 ) {

            $cost =26620.27;

        }
        else if( $weight > 7 &&  $weight <=7.5) {

            $cost =27901.54;

        }
        else if( $weight > 7.5 &&  $weight <=8 ) {

            $cost =29182.80;

        }
        else if( $weight > 8 &&  $weight <=8.5 ) {

            $cost =30466.04;

        }
        else if( $weight > 8.5 &&  $weight <=9 ) {

            $cost =31747.30;

        }
        else if( $weight > 9 &&  $weight <=9.5) {

            $cost =33032.52;

        }
        else if( $weight > 9.5 &&  $weight <=10 ) {

            $cost =36821.03;

        }
        else if( $weight > 10 &&  $weight <=10.5 ) {

            $cost =38161.52;

        }
        else if( $weight > 10.5 &&  $weight <=11 ) {

            $cost =39502.01;

        }
        else if( $weight > 11 &&  $weight <=11.5) {

            $cost =40840.52;

        }
        else if( $weight > 11.5 &&  $weight <=12 ) {

            $cost =42181.01;

        }
        else if( $weight > 12 &&  $weight <=12.5) {

            $cost =43521.50;

        }
        else if( $weight > 12.5 &&  $weight <=13 ) {

            $cost =44861.99;

        }
        else if( $weight > 13 &&  $weight <=13.5 ) {

            $cost =46200.51;

        }
        else if( $weight > 13.5 &&  $weight <=14 ) {

            $cost =47541.00;

        }
        else if( $weight > 14 &&  $weight <=14.5 ) {

            $cost =48881.49;

        }
        else if( $weight > 14.5 &&  $weight <=15 ) {

            $cost =50220.00;

        }

    }

    else if($country=="ZA"){
        if( $weight <=0.5) {

        $cost =10242.21;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =10585.72;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =11888.70;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =13189.71;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =15082.98;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =16364.24;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =17647.48;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =18928.74;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =20210.01;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =21493.25;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =22774.51;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =24055.77;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =25337.04;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =26620.27;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =27901.54;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =29182.80;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =30466.04;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =31747.30;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =33032.52;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =36821.03;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =38161.52;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =39502.01;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =40840.52;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost =42181.01;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =43521.50;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =44861.99;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =46200.51;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =47541.00;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =48881.49;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =50220.00;

    }

}

else if($country=="KR"){  
    if( $weight <=0.5) {

        $cost =6276.40;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =6810.31;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =7344.22;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =7878.13;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =8945.95;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =9479.86;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =10013.77;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =10547.68;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =11081.59;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =14532.23;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =15147.21;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =15515.02;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =15882.82;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =16246.67;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =16614.48;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =16992.17;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =17350.08;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =17717.89;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =18095.58;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =22210.64;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =22661.50;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =23118.29;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =23569.14;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost =24029.89;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =24492.61;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =24943.47;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =25406.19;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =25874.84;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =26319.77;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =26776.56;

    }

}



else if($country=="SD"){
    if( $weight <=0.5) {

      $cost =10242.21;

  } else if( $weight > 0.5 &&  $weight <=1) {

      $cost =10585.72;

  } else if( $weight > 1 &&  $weight <=1.5 ) {

      $cost =11888.70;

  }
  else if( $weight > 1.5 &&  $weight <=2 ) {

      $cost =13189.71;

  }
  else if( $weight > 2 &&  $weight <=2.5 ) {

      $cost =15082.98;

  }
  else if( $weight > 2.5 &&  $weight <=3 ) {

      $cost =16364.24;

  }
  else if( $weight > 3 &&  $weight <=3.5 ) {

      $cost =17647.48;

  }
  else if( $weight > 3.5 &&  $weight <=4 ) {

      $cost =18928.74;

  }
  else if( $weight > 4 &&  $weight <=4.5 ) {

      $cost =20210.01;

  }
  else if( $weight > 4.5 &&  $weight <=5 ) {

      $cost =21493.25;

  }
  else if( $weight > 5 &&  $weight <=5.5 ) {

      $cost =22774.51;

  }
  else if( $weight > 5.5 &&  $weight <=6 ) {

      $cost =24055.77;

  }
  else if( $weight > 6 &&  $weight <=6.5) {

      $cost =25337.04;

  }
  else if( $weight > 6.5 &&  $weight <=7 ) {

      $cost =26620.27;

  }
  else if( $weight > 7 &&  $weight <=7.5) {

      $cost =27901.54;

  }
  else if( $weight > 7.5 &&  $weight <=8 ) {

      $cost =29182.80;

  }
  else if( $weight > 8 &&  $weight <=8.5 ) {

      $cost =30466.04;

  }
  else if( $weight > 8.5 &&  $weight <=9 ) {

      $cost =31747.30;

  }
  else if( $weight > 9 &&  $weight <=9.5) {

      $cost =33032.52;

  }
  else if( $weight > 9.5 &&  $weight <=10 ) {

      $cost =36821.03;

  }
  else if( $weight > 10 &&  $weight <=10.5 ) {

      $cost =38161.52;

  }
  else if( $weight > 10.5 &&  $weight <=11 ) {

      $cost =39502.01;

  }
  else if( $weight > 11 &&  $weight <=11.5) {

      $cost =40840.52;

  }
  else if( $weight > 11.5 &&  $weight <=12 ) {

      $cost =42181.01;

  }
  else if( $weight > 12 &&  $weight <=12.5) {

      $cost =43521.50;

  }
  else if( $weight > 12.5 &&  $weight <=13 ) {

      $cost =44861.99;

  }
  else if( $weight > 13 &&  $weight <=13.5 ) {

      $cost =46200.51;

  }
  else if( $weight > 13.5 &&  $weight <=14 ) {

      $cost =47541.00;

  }
  else if( $weight > 14 &&  $weight <=14.5 ) {

      $cost =48881.49;

  }
  else if( $weight > 14.5 &&  $weight <=15 ) {

      $cost =50220.00;

  }

}


else if($country=="SY"){  
    if( $weight <=0.5) {

        $cost =7381.79;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =7878.13;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =8619.67;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =9572.80;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =11477.08;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =12428.23;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =13381.36;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =14332.51;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =15285.63;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =16090.45;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =16897.25;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =17702.07;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =18506.89;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =19313.69;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =20118.51;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =20925.30;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =21730.12;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =22536.92;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =23345.69;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =25159.01;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =26001.40;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =26841.81;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =27684.20;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost =28526.59;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =29368.98;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =30209.40;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =31051.79;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =31894.18;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =32736.57;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =33576.98;

    }

}


else if($country=="TW"){  
    if( $weight <=0.5) {

        $cost =6324.38;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =6634.63;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =7187.52;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =7778.19;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =8961.53;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =9554.19;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =10144.86;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =10737.53;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =11328.20;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =12636.83;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =13243.41;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =13848.01;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =14454.59;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =15059.19;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =15665.77;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =16270.36;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =16874.96;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =17483.53;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =18092.10;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =19780.59;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =20397.12;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =21015.64;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =21634.16;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost =22252.67;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =22869.20;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =23487.72;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =24106.23;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =24724.75;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =25341.28;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =25959.79;

    }

}

else if($country=="TJ"){  
    if( $weight <=0.5) {

        $cost =6276.40;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =6810.31;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =7344.22;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =7878.13;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =8945.95;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =9479.86;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =10013.77;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =10547.68;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =11081.59;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =14532.23;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =15147.21;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =15515.02;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =15882.82;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =16246.67;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =16614.48;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =16992.17;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =17350.08;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =17717.89;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =18095.58;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =22210.64;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =22661.50;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =23118.29;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =23569.14;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost =24029.89;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =24492.61;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =24943.47;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =25406.19;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =25874.84;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =26319.77;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =26776.56;

    }

}




else if($country=="TZ"){
     if( $weight <=0.5) {

        $cost =10242.21;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =10585.72;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =11888.70;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =13189.71;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =15082.98;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =16364.24;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =17647.48;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =18928.74;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =20210.01;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =21493.25;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =22774.51;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =24055.77;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =25337.04;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =26620.27;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =27901.54;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =29182.80;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =30466.04;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =31747.30;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =33032.52;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =36821.03;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =38161.52;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =39502.01;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =40840.52;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost =42181.01;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =43521.50;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =44861.99;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =46200.51;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =47541.00;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =48881.49;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =50220.00;

    }

}

else if($country=="TH"){  
    if( $weight <=0.5) {

        $cost =6304.70;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =6613.98;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =7165.15;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =7753.98;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =8933.64;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =9524.45;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =10113.29;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =10704.11;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =11292.94;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =12597.50;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =13202.19;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =13804.91;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =14409.60;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =15012.32;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =15617.01;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =16219.72;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =16822.44;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =17429.12;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =18035.79;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =19719.03;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =20333.64;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =20950.23;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =21566.82;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost =22183.41;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =22798.02;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =23414.61;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =24031.20;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =24647.80;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =25262.40;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =25879.00;

    }

}

else if($country=="TG"){
    if( $weight <=0.5) {

        $cost =11482.02;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =12885.68;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =14297.24 ;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost = 15724.60;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =18531.93;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost = 19641.44;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost = 20739.10;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =21832.81;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost = 22942.32;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost = 25159.36;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost = 26320.19;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost = 27299.40;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost = 28286.51;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =29299.28;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost = 30100.81 ;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost = 30920.11;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =31913.14;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =32925.91;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost = 33899.19;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =43118.76;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =44141.41;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost = 45142.33;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =46172.87;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost = 47187.62;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost = 48218.15;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost = 49242.77;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost = 50265.41;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost = 51280.16;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost = 52288.98;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost = 53319.52;

    }

}

else if($country=="TN"){
    if( $weight <=0.5) {

        $cost =11482.02;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =12885.68;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =14297.24 ;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost = 15724.60;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =18531.93;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost = 19641.44;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost = 20739.10;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =21832.81;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost = 22942.32;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost = 25159.36;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost = 26320.19;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost = 27299.40;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost = 28286.51;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =29299.28;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost = 30100.81 ;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost = 30920.11;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =31913.14;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =32925.91;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost = 33899.19;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =43118.76;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =44141.41;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost = 45142.33;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =46172.87;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost = 47187.62;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost = 48218.15;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost = 49242.77;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost = 50265.41;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost = 51280.16;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost = 52288.98;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost = 53319.52;

    }

}

else if($country=="TR"){
    if( $weight <=0.5) {

        $cost =7863.03;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =8154.47;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =8693.74;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =9562.12;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =10969.78;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =11509.05;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =12377.43;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =13245.81;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =14114.19;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =14653.46;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =15192.73;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =15732.00;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =16463.59;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =17195.17;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =17926.75;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =18658.33;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =19387.93;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =20121.50;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =20855.06;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =27231.13;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =27847.73;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =28599.13;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =29352.53;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost =30105.92;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =30859.31;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =31610.72;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =32364.11;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =33117.50;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =33870.89;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =34622.30;

    }

}

else if($country=="UG"){
     if( $weight <=0.5) {

        $cost =10242.21;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =10585.72;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =11888.70;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =13189.71;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =15082.98;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =16364.24;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =17647.48;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =18928.74;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =20210.01;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =21493.25;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =22774.51;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =24055.77;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =25337.04;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =26620.27;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =27901.54;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =29182.80;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =30466.04;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =31747.30;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =33032.52;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =36821.03;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =38161.52;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =39502.01;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =40840.52;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost =42181.01;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =43521.50;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =44861.99;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =46200.51;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =47541.00;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =48881.49;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =50220.00;

    }

}
else if($country=="UG"){
    if( $weight <=0.5) {

        $cost =6265.04;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =6673.46;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =7329.71;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =7985.95;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =9276.63;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =9913.05;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =10547.48;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =11183.90;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =11818.33;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =12454.75;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =13089.18;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =13725.60;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =14360.04;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =14996.45;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =15630.89;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =16267.31;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =16901.74;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =17538.16;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =18178.54;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =19445.43;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =20050.12;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost = 20654.82;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =21259.52;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost = 21864.21;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =22468.91;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =23073.60;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =23678.30;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =24283.00;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =24887.69;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =25490.40;

    }

}

else if($country=="UZ"){  
    if( $weight <=0.5) {

        $cost =8913.57;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =9726.94;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =10526.50;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =11324.08;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =12858.04;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =13491.76;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =14139.31;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =14784.87;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =15426.49;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =20206.06;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =21056.95;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =21797.27;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =22531.68;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =23279.91;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =24020.24;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =24756.62;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =25496.95;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =26233.33;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =26981.56;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =35498.31;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =36339.32;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =37186.26;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =37885.13;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost =38570.18;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =39421.07;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =40246.29;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =41093.22;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =41918.44;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =42755.51;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =43600.47;

    }

}

else if($country=="VU"){  
    if( $weight <=0.5) {

        $cost =6276.40;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =6810.31;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =7344.22;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =7878.13;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =8945.95;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =9479.86;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =10013.77;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =10547.68;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =11081.59;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =14532.23;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =15147.21;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =15515.02;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =15882.82;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =16246.67;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =16614.48;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =16992.17;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =17350.08;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =17717.89;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =18095.58;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =22210.64;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =22661.50;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =23118.29;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =23569.14;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost =24029.89;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =24492.61;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =24943.47;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =25406.19;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =25874.84;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =26319.77;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =26776.56;

    }

}

else if($country=="AE"){  
    if( $weight <=0.5) {

        $cost =6284.60;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost = 6694.30;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =7352.59;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost = 8010.88;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost = 9305.59;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =9944.00;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =10580.41 ;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =11218.82;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =11855.23;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost = 12493.64;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost = 13130.05;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =13768.46;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost = 14404.87;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost = 15043.28;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =15679.69;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost = 16318.10;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost = 16954.51;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =17592.92;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =18235.30;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =19506.14;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =20112.72;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =20719.31;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost = 21325.89;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost = 21932.48;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost = 22539.06;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost = 23145.64;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost = 23752.23 ;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =24358.81 ;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost = 24965.39;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost = 25569.99;

    }

}

else if($country=="VN"){  
    if( $weight <=0.5) {

        $cost =6814.98;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost = 7405.27;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =8242.34;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost = 9079.40;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost = 10753.53;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =11590.60;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =12427.66 ;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =13264.73;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =14101.80;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost = 14802.64;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost = 15503.49;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =16204.33;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost = 16905.18;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost = 17606.02;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =18306.87;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost = 19007.71;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost = 19708.56;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost = 20411.38;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =21114.20;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =27966.69;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost = 28853.11;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost = 29739.53;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost = 30623.98;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost = 31510.40;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost = 32396.82;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost = 33283.24;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost = 34167.69 ;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =35054.11 ;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost = 35940.53;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost = 36824.98;

    }

}
else if($country=="YE"){
    if( $weight <=0.5) {

        $cost = 6968.97;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =7620.46;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =8269.97 ;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost = 8921.46 ;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =10220.50;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =10871.99 ;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =11521.50;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =  12172.99;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =12822.51;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost = 14954.66;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost = 15604.17;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =16255.66;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost = 16905.18;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost = 17556.67;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost = 18206.18;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =18855.70;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost = 19507.19;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost = 20156.70;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =20808.19 ;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost = 26659.76;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =27263.87;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost = 27702.14;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =28156.21;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost = 28594.49;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost = 29174.90;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost = 29773.09;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =30361.41;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost = 30809.55;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =31269.54;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost = 31846.01;

    }

}





else if($country=="ZM"){
   if( $weight <=0.5) {

        $cost =10242.21;

    } else if( $weight > 0.5 &&  $weight <=1) {

        $cost =10585.72;

    } else if( $weight > 1 &&  $weight <=1.5 ) {

        $cost =11888.70;

    }
    else if( $weight > 1.5 &&  $weight <=2 ) {

        $cost =13189.71;

    }
    else if( $weight > 2 &&  $weight <=2.5 ) {

        $cost =15082.98;

    }
    else if( $weight > 2.5 &&  $weight <=3 ) {

        $cost =16364.24;

    }
    else if( $weight > 3 &&  $weight <=3.5 ) {

        $cost =17647.48;

    }
    else if( $weight > 3.5 &&  $weight <=4 ) {

        $cost =18928.74;

    }
    else if( $weight > 4 &&  $weight <=4.5 ) {

        $cost =20210.01;

    }
    else if( $weight > 4.5 &&  $weight <=5 ) {

        $cost =21493.25;

    }
    else if( $weight > 5 &&  $weight <=5.5 ) {

        $cost =22774.51;

    }
    else if( $weight > 5.5 &&  $weight <=6 ) {

        $cost =24055.77;

    }
    else if( $weight > 6 &&  $weight <=6.5) {

        $cost =25337.04;

    }
    else if( $weight > 6.5 &&  $weight <=7 ) {

        $cost =26620.27;

    }
    else if( $weight > 7 &&  $weight <=7.5) {

        $cost =27901.54;

    }
    else if( $weight > 7.5 &&  $weight <=8 ) {

        $cost =29182.80;

    }
    else if( $weight > 8 &&  $weight <=8.5 ) {

        $cost =30466.04;

    }
    else if( $weight > 8.5 &&  $weight <=9 ) {

        $cost =31747.30;

    }
    else if( $weight > 9 &&  $weight <=9.5) {

        $cost =33032.52;

    }
    else if( $weight > 9.5 &&  $weight <=10 ) {

        $cost =36821.03;

    }
    else if( $weight > 10 &&  $weight <=10.5 ) {

        $cost =38161.52;

    }
    else if( $weight > 10.5 &&  $weight <=11 ) {

        $cost =39502.01;

    }
    else if( $weight > 11 &&  $weight <=11.5) {

        $cost =40840.52;

    }
    else if( $weight > 11.5 &&  $weight <=12 ) {

        $cost =42181.01;

    }
    else if( $weight > 12 &&  $weight <=12.5) {

        $cost =43521.50;

    }
    else if( $weight > 12.5 &&  $weight <=13 ) {

        $cost =44861.99;

    }
    else if( $weight > 13 &&  $weight <=13.5 ) {

        $cost =46200.51;

    }
    else if( $weight > 13.5 &&  $weight <=14 ) {

        $cost =47541.00;

    }
    else if( $weight > 14 &&  $weight <=14.5 ) {

        $cost =48881.49;

    }
    else if( $weight > 14.5 &&  $weight <=15 ) {

        $cost =50220.00;

    }

}

else if($country=="ZW"){
               if( $weight <=0.5) {

                    $cost =10242.21;

                } else if( $weight > 0.5 &&  $weight <=1) {

                    $cost =10585.72;

                } else if( $weight > 1 &&  $weight <=1.5 ) {

                    $cost =11888.70;

                }
                else if( $weight > 1.5 &&  $weight <=2 ) {

                    $cost =13189.71;

                }
                else if( $weight > 2 &&  $weight <=2.5 ) {

                    $cost =15082.98;

                }
                else if( $weight > 2.5 &&  $weight <=3 ) {

                    $cost =16364.24;

                }
                else if( $weight > 3 &&  $weight <=3.5 ) {

                    $cost =17647.48;

                }
                else if( $weight > 3.5 &&  $weight <=4 ) {

                    $cost =18928.74;

                }
                else if( $weight > 4 &&  $weight <=4.5 ) {

                    $cost =20210.01;

                }
                else if( $weight > 4.5 &&  $weight <=5 ) {

                    $cost =21493.25;

                }
                else if( $weight > 5 &&  $weight <=5.5 ) {

                    $cost =22774.51;

                }
                else if( $weight > 5.5 &&  $weight <=6 ) {

                    $cost =24055.77;

                }
                else if( $weight > 6 &&  $weight <=6.5) {

                    $cost =25337.04;

                }
                else if( $weight > 6.5 &&  $weight <=7 ) {

                    $cost =26620.27;

                }
                else if( $weight > 7 &&  $weight <=7.5) {

                    $cost =27901.54;

                }
                else if( $weight > 7.5 &&  $weight <=8 ) {

                    $cost =29182.80;

                }
                else if( $weight > 8 &&  $weight <=8.5 ) {

                    $cost =30466.04;

                }
                else if( $weight > 8.5 &&  $weight <=9 ) {

                    $cost =31747.30;

                }
                else if( $weight > 9 &&  $weight <=9.5) {

                    $cost =33032.52;

                }
                else if( $weight > 9.5 &&  $weight <=10 ) {

                    $cost =36821.03;

                }
                else if( $weight > 10 &&  $weight <=10.5 ) {

                    $cost =38161.52;

                }
                else if( $weight > 10.5 &&  $weight <=11 ) {

                    $cost =39502.01;

                }
                else if( $weight > 11 &&  $weight <=11.5) {

                    $cost =40840.52;

                }
                else if( $weight > 11.5 &&  $weight <=12 ) {

                    $cost =42181.01;

                }
                else if( $weight > 12 &&  $weight <=12.5) {

                    $cost =43521.50;

                }
                else if( $weight > 12.5 &&  $weight <=13 ) {

                    $cost =44861.99;

                }
                else if( $weight > 13 &&  $weight <=13.5 ) {

                    $cost =46200.51;

                }
                else if( $weight > 13.5 &&  $weight <=14 ) {

                    $cost =47541.00;

                }
                else if( $weight > 14 &&  $weight <=14.5 ) {

                    $cost =48881.49;

                }
                else if( $weight > 14.5 &&  $weight <=15 ) {

                    $cost =50220.00;

                }

            }
                   
                    $countryZones = array(
                        'AF'=> 1,
                        'DZ'=> 1,
                        'AO'=> 1,
                        'BH'=> 1,
                        'BD'=> 1,
                        'BT'=> 1,
                        'BW'=> 1,
                        'BN'=> 1,
                        'BI'=> 1,
                        'KH'=> 1,
                        'CF'=> 1,
                        'TD'=> 1,
                        'CN'=> 1,
                        'CG'=> 1,
                        'CI'=> 1,
                        'EG'=> 1,
                        'ET'=> 1,
                        'FJ'=> 1,
                        'GM'=> 1,
                        'GH'=> 1,
                        'GN'=> 1,
                        'HK'=> 1,
                        'IN'=> 1,
                        'ID'=> 1,
                        'IQ'=> 1,
                        'IL'=> 1,
                        'JO'=> 1,
                        'KZ'=> 1,
                        'KE'=> 1,
                        'KW'=> 1,
                        'KG'=> 1,
                        'LA'=> 1,
                        'LB'=> 1,
                        'LS'=> 1,
                        'LR'=> 1,
                        'LY'=> 1,
                        'MO'=> 1,
                        'MG'=> 1,
                        'MW'=> 1,
                        'MY'=> 1,
                        'MV'=> 1,
                        'MU'=> 1,
                        'MN'=> 1,
                        'MA'=> 1,
                        'MZ'=> 1,
                        'MM'=> 1,
                        'NA'=> 1,
                        'NP'=> 1,
                        'NZ'=> 1,
                        'NE'=> 1,
                        'NG'=> 1,
                        'OM'=> 1,
                        'PK'=> 1,
                        'PW'=> 1,
                        'PS'=> 1,
                        'PG'=> 1,
                        'PH'=> 1,
                        'QA'=> 1,
                        'RW'=> 1,
                        'WS'=> 1,
                        'SA'=> 1,
                        'SN'=> 1,
                        'SC'=> 1,
                        'SL'=> 1,
                        'SG'=> 1,
                        'SB'=> 1,
                        'SO'=> 1,
                        'ZA'=> 1,
                        'KR'=> 1,
                        'SD'=> 1,
                        'SY'=> 1,
                        'TW'=> 1,
                        'TJ'=> 1,
                        'TZ'=> 1,
                        'TH'=> 1,
                        'TG'=> 1,
                        'TN'=> 1,
                        'TR'=> 1,
                        'UG'=> 1,
                        'AE'=> 1,
                        'UZ'=> 1,
                        'VU'=> 1,
                        'VN'=> 1,
                        'YE'=> 1,
                        'ZM'=> 1,
                        'ZW'=> 1
                        );
 
                    $zonePrices = array(
                        0 => 0,
                        1 => 0,
                        2 => 0,
                        3 => 0
                        );
 
                    $zoneFromCountry = $countryZones[ $country ];
                    $priceFromZone = $zonePrices[ $zoneFromCountry ];
 
                    $cost += $priceFromZone;
 
                    $rate = array(
                        'id' => $this->id,
                        'label' => $this->title,
                        'cost' => $cost
                    );
 
                    $this->add_rate( $rate );
                    
                }
            }
        }
    }
 
    add_action( 'woocommerce_shipping_init', 'tutsplus_shipping_method' );
 
    function add_tutsplus_shipping_method( $methods ) {
        $methods[] = 'TutsPlus_Shipping_Method';
        return $methods;
    }
 
    add_filter( 'woocommerce_shipping_methods', 'add_tutsplus_shipping_method' );
 
    function tutsplus_validate_order( $posted )   {
 
        $packages = WC()->shipping->get_packages();
 
        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
         
        if( is_array( $chosen_methods ) && in_array( 'tutsplus', $chosen_methods ) ) {
             
            foreach ( $packages as $i => $package ) {
 
                if ( $chosen_methods[ $i ] != "tutsplus" ) {             
                    continue;                           
                }
 
                $TutsPlus_Shipping_Method = new TutsPlus_Shipping_Method();
                $weightLimit = (int) $TutsPlus_Shipping_Method->settings['weight'];
                $weight = 0;
 
                foreach ( $package['contents'] as $item_id => $values ) 
                { 
                    $_product = $values['data']; 
                    $weight = $weight + $_product->get_weight() * $values['quantity']; 
                }
 
                $weight = wc_get_weight( $weight, 'kg' );
                
                if( $weight > $weightLimit ) {
 
                        $message = sprintf( __( 'Sorry, %d kg exceeds the maximum weight of %d kg for %s', 'tutsplus' ), $weight, $weightLimit, $TutsPlus_Shipping_Method->title );
                             
                        $messageType = "error";
 
                        if( ! wc_has_notice( $message, $messageType ) ) {
                         
                            wc_add_notice( $message, $messageType );
                      
                        }
                }
            }       
        } 
    }
 
    add_action( 'woocommerce_review_order_before_cart_contents', 'tutsplus_validate_order' , 10 );
    add_action( 'woocommerce_after_checkout_validation', 'tutsplus_validate_order' , 10 );
}