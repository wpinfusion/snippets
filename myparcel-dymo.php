<?php
// Don't include opening tag when pasting in functions
// Warning: You can only use the filter once ! 
// If you need to return multiple object, you need to put all IF statements into one function.

// Return Track/Trace to Dymo
add_filter('wc_dymo_order_function', 'wpf_dymo_order_tracktrace_output',10,3);
function wpf_dymo_order_tracktrace_output($order_id,$label,$object) {
 
	if($label=='shipping' && $object=='TRACKTRACE') {
		
		//Get order from order ID
		$order=wc_get_order($order_id);
		
		$order_data = $order->get_meta('_myparcel_shipments');
        	$final_array = array_values($order_data);
		$order_track_trace = $final_array[0]['tracktrace'];
		
		return $order_track_trace;
	} else {
		//Return order_id if is not correct label and object
		return '';
	}
}

// Return Delivery Date to Dymo
add_filter('wc_dymo_order_function', 'wpf_dymo_order_del_date_output',10,3);
function wpf_dymo_order_del_date_output($order_id,$label,$object) {
 
	if($label=='shipping' && $object=='DEL_DATE') {
		
		//Get order from order ID
		$order=wc_get_order($order_id);
		
		$order_data = $order->get_meta('_myparcel_shipments');
        	$final_array = array_values($order_data);
        	$del_date = $final_array[0]['shipment']['options']['delivery_date'];
		$final_del_date = DateTime::createFromFormat('Y-m-d h:i:s', $del_date)->format('d-m-Y');
		
		return $final_del_date;
	} else {
		//Return order_id if is not correct label and object
		return '';
	}
}

// Return Signature to Dymo
add_filter('wc_dymo_order_function', 'wpf_dymo_order_signature_output',10,3);
function wpf_dymo_order_signature_output($order_id,$label,$object) {
 
	if($label=='shipping' && $object=='SIG_REQ') {
		
		//Get order from order ID
		$order=wc_get_order($order_id);
		
		$order_data = $order->get_meta('_myparcel_shipments');
        	$final_array = array_values($order_data);
        	$sig_int = $final_array[0]['shipment']['options']['signature'];
		if( $sig_int=="1") {
        		$sig_req = "JA"; }
		else {
            		$sig_req = "NEE";
        	}                          
		return $sig_req;
	} else {
		//Return order_id if is not correct label and object
		return '';
	}
}

// Return Pakketpunt to Dymo (if exists)
add_filter('wc_dymo_order_function', 'wpf_dymo_order_ppunt_output',10,3);
function wpf_dymo_order_ppunt_output($order_id,$label,$object) {
 
	if($label=='shipping' && $object=='PAKK_PUNT') {
		
		//Get order from order ID
		$order=wc_get_order($order_id);
		
		$order_data = $order->get_meta('_myparcel_shipments');
        	$final_array = array_values($order_data);
		if ( isset( $final_array[0]['shipment']['pickup'] ) ) {
	        	$ppunt_name = $final_array[0]['shipment']['pickup']['location_name'];
    	    		$ppunt_postal_code = $final_array[0]['shipment']['pickup']['postal_code'];
            		$ppunt_number = $final_array[0]['shipment']['pickup']['number'];
           		$ppunt_city = $final_array[0]['shipment']['pickup']['city'];
           		$final_str = "Afhalen bij: " . $ppunt_name . ", " . $ppunt_postal_code . ", nr: " . $ppunt_number . ", " . $ppunt_city;
		} else {
    			$final_str = "NVT";
		}
		return $final_str;
	} else {
		//Return order_id if is not correct label and object
		return '';
	}
}

// Display the extra data in the order admin panel for testing output
add_action( 'woocommerce_admin_order_data_after_order_details', 'display_order_data_in_admin' );
function display_order_data_in_admin( $order ){  ?>
    <div class="order_data_column">
        <h4><?php _e( 'Extra Details', 'woocommerce' ); ?></h4>
        <?php 
            echo '<p><strong>' . __( 'Barcode' ) . '</p>';
            $myparcel_array = $order->get_meta('_myparcel_shipments');
            $final_array = array_values($myparcel_array);
            echo $final_array[0]['tracktrace'];
                                                   
            ?>
    </div>
<?php }


/*Array Example for debugging
Array
(
    [31040763] => Array
        (
            [shipment_id] => 31040763
            [tracktrace] => 3SMYPA000000000
            [shipment] => Array
                (
                    [barcode] => 3SMYPA000000000
                    [pickup] => Array
                        (
                            [postal_code] => XXXAA
                            [street] => STRAAT
                            [city] => STAD
                            [number] => XX
                            [location_name] => Gamma
                        )
                    [options] => Array
                        (
                            [signature] => 0
                            [delivery_date] => 2018-03-10 00:00:00
                        )
                )
        )
)*/


//Ignore closing tag when inserting into functions
?>
