<?php
class ControllerModuleDSocialLogin extends Controller {
	public $route  = 'module/d_social_login';
	public $mbooth = 'mbooth_d_social_login_lite.xml';
	public $module = 'd_social_login';
	private $error = array(); 
	
	public function index() {  
		/*
		*	Multistore
		*/
		if(isset($this->request->get['store_id'])){ $store_id = $this->request->get['store_id']; }else{  $store_id = 0; }
		$this->document->addLink('//fonts.googleapis.com/css?family=PT+Sans:400,700,700italic,400italic&subset=latin,cyrillic-ext,latin-ext,cyrillic', "stylesheet");
		$this->document->addStyle('view/stylesheet/shopunity/normalize.css');
		$this->document->addStyle('view/javascript/shopunity/uniform/css/uniform.default.css');
		$this->document->addStyle('view/stylesheet/shopunity/icons.css');
		$this->document->addStyle('view/stylesheet/shopunity/shopunity.css');
		$this->document->addStyle('view/javascript/shopunity/colorpicker/jquery.colorpicker.css');
		$this->document->addScript('view/javascript/shopunity/uniform/jquery.uniform.min.js');		
		$this->document->addScript('view/javascript/shopunity/shopunity.js');
		$this->document->addScript('view/javascript/shopunity/tooltip/tooltip.js');
		$this->document->addScript('view/javascript/shopunity/colorpicker/jquery.colorpicker.js');
		$this->document->addStyle('view/stylesheet/d_social_login/styles.css');

		$this->language->load($this->route);

		$this->document->setTitle($this->language->get('heading_title_main'));
		
		$this->load->model('setting/setting');
		$this->load->model('sale/customer_group');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_setting_setting->editSetting($this->module, $this->request->post, $store_id);

			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['version'] = $this->get_version();
        $this->data['token'] =  $this->session->data['token'];
		$this->data['route'] = $this->route;
		$this->data['id'] = $this->module;
		$this->data['module_link'] = $this->url->link($this->route, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['heading_title'] = $this->language->get('heading_title_main');

		$this->data['text_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['text_newsletter'] = $this->language->get('entry_newsletter');
		$this->data['text_debug'] = $this->language->get('text_debug');
		$this->data['text_return_page_url'] = $this->language->get('entry_return_page_url');
		$this->data['text_debug_mode'] = $this->language->get('entry_debug_mode');
		$this->data['text_debug_file_into'] = $this->language->get('text_debug_file_into');
		$this->data['entry_debug_file'] = $this->language->get('entry_debug_file');
		$this->data['clear_debug_file'] = str_replace('&amp;', '&', $this->url->link($this->route.'/clearDebugFile', 'token=' . $this->session->data['token'], 'SSL'));
		$this->data['button_clear_debug_file'] = $this->language->get('button_clear_debug_file');
		$this->data['text_app_scope'] = $this->language->get('text_app_scope');

		$this->data['text_settings'] = $this->language->get('text_settings');
		$this->data['text_instructions'] = $this->language->get('text_instructions');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_module'] = $this->language->get('text_module');
		$this->data['text_no_update'] = $this->language->get('text_no_update');
		$this->data['text_new_update'] = $this->language->get('text_new_update');
		$this->data['text_error_update'] = $this->language->get('text_error_update');
		$this->data['text_error_failed'] = $this->language->get('text_error_failed');
		$this->data['text_version_check'] = sprintf($this->language->get('text_version_check'), $this->data['version']);
		$this->data['button_save_and_stay'] = $this->language->get('button_save_and_stay');
		$this->data['button_version_check'] = $this->language->get('button_version_check');
		$this->data['text_instructions_full'] = $this->language->get('text_instructions_full');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['text_icons'] = $this->language->get('text_icons');
		$this->data['text_small'] = $this->language->get('text_small');
		$this->data['text_medium'] = $this->language->get('text_medium');		
		$this->data['text_large'] = $this->language->get('text_large');
		$this->data['text_huge'] = $this->language->get('text_huge');

		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		
		$this->data['entry_size'] = $this->language->get('entry_size');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['text_return_url'] = $this->language->get('text_return_url');
		$this->data['text_base_url_index'] = $this->language->get('text_base_url_index');

		$this->data['text_facebook'] = $this->language->get('text_facebook');
		$this->data['text_google'] = $this->language->get('text_google');
		$this->data['text_twitter'] = $this->language->get('text_twitter');
		$this->data['text_live'] = $this->language->get('text_live');
		$this->data['text_linkedin'] = $this->language->get('text_linkedin');
		$this->data['text_vkontakte'] = $this->language->get('text_vkontakte');
		$this->data['text_odnoklassniki'] = $this->language->get('text_odnoklassniki');
		$this->data['text_mailru'] = $this->language->get('text_mailru');
		$this->data['text_yandex'] = $this->language->get('text_yandex');
		$this->data['text_instagram'] = $this->language->get('text_instagram');
		$this->data['text_paypal'] = $this->language->get('text_paypal');
		$this->data['text_vimeo'] = $this->language->get('text_vimeo');
		$this->data['text_tumblr'] = $this->language->get('text_tumblr');
		$this->data['text_yahoo'] = $this->language->get('text_yahoo');
		$this->data['text_foursquare'] = $this->language->get('text_foursquare');


		$this->data['text_background_img'] = $this->language->get('text_background_img');
		$this->data['text_background_color'] = $this->language->get('text_background_color');
		$this->data['text_background_color_active'] = $this->language->get('text_background_color_active');

		$this->data['text_fields_sort_order'] = $this->language->get('text_fields_sort_order');
		$this->data['text_firstname'] = $this->language->get('text_firstname');
		$this->data['text_lastname'] = $this->language->get('text_lastname');
		$this->data['text_phone'] = $this->language->get('text_phone');
		$this->data['text_mask'] = $this->language->get('text_mask');
		$this->data['text_address_1'] = $this->language->get('text_address_1');
		$this->data['text_address_2'] = $this->language->get('text_address_2');
		$this->data['text_city'] = $this->language->get('text_city');
		$this->data['text_postcode'] = $this->language->get('text_postcode');
		$this->data['text_country_id'] = $this->language->get('text_country_id');
		$this->data['text_zone_id'] = $this->language->get('text_zone_id');
		$this->data['text_password'] = $this->language->get('text_password');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_company'] = $this->language->get('text_company');
		$this->data['text_company_id'] = $this->language->get('text_company_id');
		$this->data['text_tax_id'] = $this->language->get('text_tax_id');
		
		$this->data['warning_app_settings'] = $this->language->get('warning_app_settings');
		$this->data['warning_app_settings_full'] = $this->language->get('warning_app_settings_full');

		$this->data['text_app_id'] = $this->language->get('text_app_id');
		$this->data['text_app_secret'] = $this->language->get('text_app_secret');
		$this->data['text_app_key'] = $this->language->get('text_app_key');
		$this->data['text_sort_order'] = $this->language->get('text_sort_order');

		$this->data['text_app_settings'] = $this->language->get('text_app_settings');

		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title_main'),
			'href'      => $this->url->link($this->route, 'token=' . $this->session->data['token'] . '&store_id='.$store_id, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . '&store_id='.$store_id, 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['modules'] = array();
		
		if (isset($this->request->post['d_social_login_module'])) {
			$this->data['modules'] = $this->request->post['d_social_login_module'];
		} elseif ($this->model_setting_setting->getSetting('d_social_login', $store_id)) { 
			$this->data['modules'] = $this->model_setting_setting->getSetting('d_social_login', $store_id);
			$this->data['modules'] = (isset($this->data['modules']['d_social_login_module'])) ? $this->data['modules']['d_social_login_module'] : array();
		}



		if (isset($this->request->post['d_social_login_setting'])) {
			$this->data['setting'] = $this->request->post['d_social_login_settings'];
		} elseif ($this->model_setting_setting->getSetting('d_social_login', $store_id)) { 
			$this->data['setting'] = $this->model_setting_setting->getSetting('d_social_login', $store_id);
			$this->data['setting'] = (isset($this->data['setting']['d_social_login_settings'])) ? $this->data['setting']['d_social_login_settings'] : array();
		} else {
			$this->config->load($this->get_light_or_full_version());
			$this->data['setting'] = $this->config->get('d_social_login_settings');
		}


		$this->config->load($this->get_light_or_full_version());
		$config = $this->config->get('d_social_login_settings'); 
		$this->data['setting'] = $this->array_merge_recursive_distinct($config, $this->data['setting']);
		
		$this->load->model('tool/image');

		if (isset($this->request->post['setting']['background_img'])) {
			$this->data['background_img'] = $this->request->post['setting']['background_img'];
		} else {
			$this->data['background_img'] = $this->data['setting']['background_img'];			
		}

		if ($this->data['setting']['background_img']&& file_exists(DIR_IMAGE . $this->data['setting']['background_img']) && is_file(DIR_IMAGE . $this->data['setting']['background_img'])) {
			$this->data['background_img_thumb'] = $this->model_tool_image->resize($this->data['setting']['background_img'], 100, 100);		
		} else {
			$this->data['background_img_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);


		$this->data['providers'] = $this->data['setting']['providers'];
		$this->data['fields'] = $this->data['setting']['fields'];
		$this->data['return_urls'] = array('viewed', 'checkout', 'address', 'home', 'account');

		//Get stores
		$this->data['store_id'] = $store_id;
		$this->load->model('setting/store');
		$results = $this->model_setting_store->getStores();
		if($results){
			$this->data['stores'][] = array('store_id' => 0, 'name' => $this->config->get('config_name'));
			foreach ($results as $result) {
				$this->data['stores'][] = array(
					'store_id' => $result['store_id'],
					'name' => $result['name']
					
				);
			}	
		}

		//customer groups
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		//debug
		$this->data['debug'] = $this->getFileContents(DIR_LOGS.$this->data['setting']['debug_file']);
		$this->data['debug_file'] = $this->data['setting']['debug_file'];
						
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->db_authentication();
		
		$this->template = $this->route . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function getFileContents($file){

		if (file_exists($file)) {
			$size = filesize($file);

			if ($size >= 5242880) {
				$suffix = array(
					'B',
					'KB',
					'MB',
					'GB',
					'TB',
					'PB',
					'EB',
					'ZB',
					'YB'
				);

				$i = 0;

				while (($size / 1024) > 1) {
					$size = $size / 1024;
					$i++;
				}

				return sprintf($this->language->get('error_get_file_contents'), basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
			} else {
				return file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
			}
		}
	}

	public function clearDebugFile() {
		$this->load->language($this->route);
		$json = array();

		if (!$this->user->hasPermission('modify', $this->route)) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$file = DIR_LOGS.$this->request->post['debug_file'];

			$handle = fopen($file, 'w+');

			fclose($handle);

			$json['success'] = $this->language->get('success_clear_debug_file');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/d_social_login')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->install();
						
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	public function array_merge_recursive_distinct( array &$array1, array &$array2 )
	{
	  $merged = $array1;	
	  foreach ( $array2 as $key => &$value )
		  {
			if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) )
			{
			  $merged [$key] = $this->array_merge_recursive_distinct ( $merged [$key], $value );
			}
			else
			{
			  $merged [$key] = $value;
			}
		  }
		
	  return $merged;
	}

	public function install() {

		// $query = $this->db->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND TABLE_NAME = '" . DB_PREFIX . "customer' ORDER BY ORDINAL_POSITION"); 
		// $result = $query->rows; 
		// $columns = array();
		// foreach($result as $column){
		// 	$columns[] = $column['COLUMN_NAME'];
		// }

		// if(!in_array('facebook_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD facebook_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('twitter_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD twitter_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('google_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD google_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('linkedin_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD linkedin_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('vkontakte_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD vkontakte_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('odnoklassniki_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD odnoklassniki_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('live_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD live_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('yandex_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD yandex_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('mailru_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD mailru_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('instagram_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD instagram_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('paypal_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD paypal_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('vimeo_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD vimeo_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('tumblr_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD tumblr_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('yahoo_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD yahoo_id VARCHAR( 255 )  NOT NULL");
		// }
		// if(!in_array('foursquare_id', $columns)){
		// 	 $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD foursquare_id VARCHAR( 255 )  NOT NULL");
		// }

		$this->db_authentication();

		  // $this->load->model('setting/setting');
		  // $file1 = str_replace("admin", "vqmod/xml", DIR_APPLICATION) . "a_vqmod_quickcheckout.xml_"; $file2 = str_replace("admin", "vqmod/xml", DIR_APPLICATION) . "a_vqmod_quickcheckout.xml";
		  // if (file_exists($file1)) rename($file1, $file2);
		  $this->version_check(1);	  
	}

	public function db_authentication(){
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "customer_authentication` (
		  `customer_authentication_id` int(11) NOT NULL AUTO_INCREMENT,
		  `customer_id` int(11) NOT NULL,
		  `provider` varchar(55) NOT NULL,
		  `identifier` varchar(200) NOT NULL,
		  `web_site_url` varchar(255) NOT NULL,
		  `profile_url` varchar(255) NOT NULL,
		  `photo_url` varchar(255) NOT NULL,
		  `display_name` varchar(255) NOT NULL,
		  `description` varchar(255) NOT NULL,
		  `first_name` varchar(255) NOT NULL,
		  `last_name` varchar(255) NOT NULL,
		  `gender` varchar(255) NOT NULL,
		  `language` varchar(255) NOT NULL,
		  `age` varchar(255) NOT NULL,
		  `birth_day` varchar(255) NOT NULL,
		  `birth_month` varchar(255) NOT NULL,
		  `birth_year` varchar(255) NOT NULL,
		  `email` varchar(255) NOT NULL,
		  `email_verified` varchar(255) NOT NULL,
		  `phone` varchar(255) NOT NULL,
		  `address` varchar(255) NOT NULL,
		  `country` varchar(255) NOT NULL,
		  `region` varchar(255) NOT NULL,
		  `city` varchar(255) NOT NULL,
		  `zip` varchar(255) NOT NULL,
		  `date_added` datetime NOT NULL,
		  PRIMARY KEY (`customer_authentication_id`),
		  UNIQUE KEY `identifier` (`identifier`, `provider`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;");
	}
		 
	public function uninstall() {
		  // $this->load->model('setting/setting');
		  // $file1 = str_replace("admin", "vqmod/xml", DIR_APPLICATION) . "a_vqmod_quickcheckout.xml"; $file2 = str_replace("admin", "vqmod/xml", DIR_APPLICATION) . "a_vqmod_quickcheckout.xml_";
		  // if (file_exists($file1)) rename($file1, $file2);
		  $this->version_check(0);
		  
	}

	public function check_shopunity(){
		$file1 = DIR_APPLICATION . "mbooth/xml/mbooth_shopunity_admin.xml"; 
		$file2 = DIR_APPLICATION . "mbooth/xml/mbooth_shopunity_admin_patch.xml"; 
		if (file_exists($file1) || file_exists($file2)) { 
			return true;
		} else {
			return false;
		}
	}

	public function get_light_or_full_version(){
		$full = DIR_SYSTEM . "config/d_social_login.php";
		$light = DIR_SYSTEM . "config/d_social_login_lite.php"; 
		if (file_exists($full)) { 
			return 'd_social_login';
		} elseif (file_exists($light)) {
			return 'd_social_login_lite';
		}else{
			return false;
		}

	}

	public function get_version(){
		$xml = file_get_contents(DIR_APPLICATION . 'mbooth/xml/' . $this->mbooth);

		$mbooth = new SimpleXMLElement($xml);

		return $mbooth->version ;
		}
		
	public function version_check($status = 1){
		$json = array();
		$mbooth = $this->mbooth;
		$this->load->language($this->route);
		$str = file_get_contents(DIR_APPLICATION . 'mbooth/xml/' . $this->mbooth);
		$xml = new SimpleXMLElement($str);
	
		$current_version = $xml->version ;

		$customer_url = HTTP_SERVER;
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE language_id = " . (int)$this->config->get('config_language_id') ); 
		$language_code = $query->row['code'];
		$ip = $this->request->server['REMOTE_ADDR'];

		$check_version_url = 'http://opencart.dreamvention.com/update/index.php?mbooth=' . $mbooth . '&store_url=' . $customer_url . '&module_version=' . $current_version . '&language_code=' . $language_code . '&opencart_version=' . VERSION . '&ip='.$ip . '&status=' .$status ;
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $check_version_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$return_data = curl_exec($curl);
		$return_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

      if ($return_code == 200) {
         $data = simplexml_load_string($return_data);
	
         if ((string) $data->version == (string) $current_version || (string) $data->version <= (string) $current_version) {
			 
           $json['success']   = $this->language->get('text_no_update');

         } elseif ((string) $data->version > (string) $current_version) {
			 
			$json['attention']   = $this->language->get('text_new_update');
				
			foreach($data->updates->update as $update){

				if((string) $update->attributes()->version > (string)$current_version){
					$version = (string)$update->attributes()->version;
					$json['update'][$version] = (string) $update[0];
				}
			}
         } else {
            $json['error']   = $this->language->get('text_error_update');
         }
      } else { 
         $json['error']   =  $this->language->get('text_error_failed');
      }
		 $json['asdasd']= 'asdasda';
	      if (file_exists(DIR_SYSTEM.'library/json.php')) { 
	         $this->load->library('json');
	         $this->response->setOutput(Json::encode($json));
	      } else {
	         $this->response->setOutput(json_encode($json));
	      }
	}
}
?>