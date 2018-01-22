<?php 

Class Stripe 
{

	public function __construct($config = array())
	{
		$this->config = $config;
		$this->validation();
		//$this->pay_with_card_form();
	}

	public function plan_create($input){
		$init = array();
		$init['url']= "https://api.stripe.com/v1/plans";
		$post_query = http_build_query($input, '', '&');
		$init['post_data'] = $post_query; 
		return $this->curl_init($init);		
	}

	public function customer_create($input){
		$init = array();
		$init['url']= "https://api.stripe.com/v1/customers";	
		$post_query = http_build_query($input, '', '&');
		$init['post_data'] = $post_query;
		return $this->curl_init($init);
	}

	public function subscribe_customer($input){
		$init = array();
		$init['url']= "https://api.stripe.com/v1/subscriptions";	
		$post_query = http_build_query($input, '', '&');
		$init['post_data'] = $post_query; 
		return $this->curl_init($init);
	}

	public function stripe_charges($input){

		$init = array();
		$init['url']= "https://api.stripe.com/v1/charges";	
		$post_query = http_build_query($input, '', '&');
		$init['post_data'] = $post_query; 
		return $this->curl_init($init);
	}
	public function stripe_refund($input){

		$init = array();
		$init['url']= "https://api.stripe.com/v1/refunds";	
		$post_query = http_build_query($input, '', '&');
		$init['post_data'] = $post_query; 
		return $this->curl_init($init);

	}

	public function curl_init($option){
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $option['url']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$option['post_data']);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_USERPWD, $this->secret_key . ":" . "");
		$headers = array();
		$headers[] = "Content-Type: application/x-www-form-urlencoded";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = array();
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			$result = curl_error($ch);
		}
		curl_close ($ch);
		return $result;
	}

	public function validation(){

		$this->publishable_key = (!empty($this->config['publishable_key'])?$this->config['publishable_key']:'');
		$this->secret_key      = (!empty($this->config['secret_key'])?$this->config['secret_key']:'');

		$this->stripe_name     = (!empty($this->config['stripe_name'])?$this->config['stripe_name']:'Stripe Payment');
		$this->server_side_coding = (!empty($this->config['server_side_coding'])?$this->config['server_side_coding']:'');
		$this->stripe_logo     = (!empty($this->config['stripe_logo'])?$this->config['stripe_logo']:'https://stripe.com/img/documentation/checkout/marketplace.png');
		$this->stripe_description = (!empty($this->config['stripe_description'])?$this->config['stripe_description']:'This is Stripe Payment');

		

		$error_message = array();
		if(empty($this->publishable_key)){
			$error_message['publishable_error'] = "Publishable key is missing";
		}
		if(empty($this->secret_key)){
			$error_message['secret_error'] = "The secret key is missing";
		}
		if(count($error_message) > 0){
			return json_encode($error_message);
		}

	}

	public function pay_with_card_form(){

		$pay_with_card_html = '<form action="'.$this->server_side_coding.'" method="POST" id="stripe_payment" style="display:none">
			<script
			src="https://checkout.stripe.com/checkout.js" class="stripe-button"
			data-key="'.$this->publishable_key.'"
			data-name="'.$this->stripe_name.'"
			data-billing-address="true"
			data-description="'.$this->stripe_description.'"
			data-image="'.$this->stripe_logo.'"
			data-locale="auto">
			</script>
			</form>'; 
		echo $pay_with_card_html;	

	}

}

?>