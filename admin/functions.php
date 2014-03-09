<?php

	function cf7_highrise_menu(){
	    add_options_page('CF7 Highrise Options', 'CF7 Highrise Hook', 'manage_options', 'cf7-highrise-menu', 'cf7_highrise_options');
	}

	function cf7_highrise_options(){
	    include( CF7_HIGHRISE_DIR. '/admin/admin.php' );
	}	


	add_action( 'admin_menu', 'cf7_highrise_menu', 9 );
	add_filter( 'plugin_action_links', 'cf7_highrise_action_links', 10, 2 );

	function cf7_highrise_action_links( $links, $file ) {
		if ( $file != CF7_HIGHRISE_BASENAME ){
			return $links;
		}

		$settings_link = '<a href="' . menu_page_url( 'cf7-highrise-menu', false ) . '">'
			. esc_html( __( 'Settings', 'cf7-highrise-menu' ) ) . '</a>';

		array_unshift( $links, $settings_link );

		return $links;
	}

	add_action('admin_init', 'cf7_highrise_admin_init');
	function cf7_highrise_admin_init(){
		register_setting( 'cf7_highrise_options', 'cf7_highrise_options' );
		add_settings_section(CF7_HIGHRISE_BASENAME, 'Settings', 'cf7_highrise_section_text', CF7_HIGHRISE_BASENAME);
		add_settings_field('highrise_url', 'Highrise URL', 'cf7_highrise_url', CF7_HIGHRISE_BASENAME, CF7_HIGHRISE_BASENAME);
		add_settings_field('api_token', 'API Token', 'cf7_highrise_token', CF7_HIGHRISE_BASENAME, CF7_HIGHRISE_BASENAME);
	}

	function cf7_highrise_section_text(){
		
	}

	function cf7_highrise_url() {
		$options = get_option('cf7_highrise_options');
		echo "<input id='highrise_url' name='cf7_highrise_options[highrise_url]' size='40' type='text' value='{$options['highrise_url']}' />";
	}	

	function cf7_highrise_token() {
		$options = get_option('cf7_highrise_options');
		echo "<input id='highrise_token' name='cf7_highrise_options[highrise_token]' size='40' type='text' value='{$options['highrise_token']}' />";
	}	

	add_action('wpcf7_before_send_mail', 'send_to_highrise');	
	function send_to_highrise (&$WPCF7_ContactForm) {
		$data = $WPCF7_ContactForm->posted_data;

		// don't send if no contact name
		if( !isset($data['contact_name']) ){
			return;
		}

		// setup endpoint and auth
		$options = get_option('cf7_highrise_options');
		$highrise_url = $options['highrise_url'];
		$api_token = $options['highrise_token'];

		$contact_name = explode(' ', $data['contact_name']);

		// create curl
		$curl = curl_init($highrise_url.'/people.xml');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERPWD, $api_token.':x'); 
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, '
			<person>
				<first-name>'.htmlspecialchars($contact_name[0]).'</first-name>
				<last-name>'.htmlspecialchars(isset($contact_name[1]) ? $contact_name[1] : '').'</last-name>
				<background></background>
				<company-name>'.htmlspecialchars($data['company_name']).'</company-name>
				<contact-data>
					<email-addresses>
						<email-address>
							<address>'.htmlspecialchars($data['contact_email']).'</address>
							<location>Work</location>
						</email-address>
					</email-addresses>
					<phone-numbers>
						<phone-number>
							<number>'.htmlspecialchars(isset($data['contact_phone']) ? $data['contact_phone'] : '').'</number>
							<location>Work</location>
						</phone-number>
					</phone-numbers>
					<addresses>
						<address>
							<city></city>
							<country></country>
							<state></state>
							<street></street>
							<zip></zip>
							<location>Work</location>
						</address>
				  	</addresses>
				</contact-data>
			</person>'
		);

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);

		$xml = curl_exec($curl);
		curl_close($curl);		
	}

