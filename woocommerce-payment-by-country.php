# PHP snippet for filtering payment methods based on country
# In this example we're showing Belgian payment methods when the billing country is 'BE', and Dutch for 'NL'
 
function payment_gateway_disable_country( $available_gateways ) {
	global $woocommerce;
	if ( is_admin() ) return;
	if ( isset( $available_gateways['mollie_wc_gateway_ideal'] ) && $woocommerce->customer->get_billing_country() == 'BE' ) {
		unset( $available_gateways['mollie_wc_gateway_ideal'] );
	} elseif ( $woocommerce->customer->get_billing_country() == 'NL' ) {
		unset( $available_gateways['mollie_wc_gateway_belfius'] );
        unset( $available_gateways['mollie_wc_gateway_bancontact'] );
		unset( $available_gateways['mollie_wc_gateway_kbc'] );
	}
	return $available_gateways;
}
 
add_filter( 'woocommerce_available_payment_gateways', 'payment_gateway_disable_country' );
