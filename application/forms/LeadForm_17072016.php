<?php

class Application_Form_LeadForm extends Zend_Form
{

    public function init()
    {
        $this->setName('contactUsForm');
		$this->setAttrib('class', "form-horizontal");
		
		$full_name_blur = "if (this.value == '') {this.value = 'your name';}";
		$full_name_focus = "if (this.value == 'your name') {this.value = '';}";
		
		$full_name_value = new Zend_Validate_Identical(
							array('token' => 'your namexxx', 'strict' => false)
						);
								
		$full_name_notempty = new Zend_Validate_NotEmpty();
		
		$last_name_blur = "if (this.value == '') {this.value = 'Your Last Name';}";
		$last_name_focus = "if (this.value == 'Your Last Name') {this.value = '';}";
		
		$email_blur = "if (this.value == '') {this.value = 'your email';}";
		$email_focus = "if (this.value == 'your email') {this.value = '';}";
		
		
		$phone_optional_blur = "if (this.value == '') {this.value = 'Phone (optional)';}";
		$phone_optional_focus = "if (this.value == 'Phone (optional)') {this.value = '';}";
		
		$message_blur = "if (this.value == '') {this.value = 'enter your message';}";
		$message_focus = "if (this.value == 'enter your message') {this.value = '';}";
		
		// generate Zend validators variables for email element
		
		$email_notempty = new Zend_Validate_NotEmpty();
		$email_validate = new Zend_Validate_EmailAddress();
		$email_validate->setMessages(
		  array(
			  Zend_Validate_EmailAddress::INVALID => 'Please enter in a valid email address in the format user@domain.co.uk',
			  Zend_Validate_EmailAddress::INVALID_FORMAT => 'Error with format',
			  Zend_Validate_EmailAddress::INVALID_HOSTNAME => 'Error with hostname',
			  Zend_Validate_EmailAddress::INVALID_LOCAL_PART => 'Error with Local Part',
			  Zend_Validate_EmailAddress::INVALID_MX_RECORD => 'Error with MX record',
			  Zend_Validate_EmailAddress::INVALID_SEGMENT => 'Error with Segment'
				)
		);
		
		$contact_id = new Zend_Form_Element_Hidden('contact_id');
		$contact_id->addFilter('Int');
		
		
		$title = new Zend_Form_Element_Select('title');
		$title->setRequired(true)
		        ->setLabel('Your Title')
				->setAttrib('class', "form-control")
				->addErrorMessage('Title is required')
				->addMultiOptions(array(
				'' => 'please select',
				'Mr' => 'Mr',
				'Mrs' => 'Mrs',
				'Miss' => 'Miss',
				'Chief' => 'Chief',
				'Dr' => 'Dr'
				));
		
		
		$full_name = new Zend_Form_Element_Text('full_name');
		$full_name->setRequired(true)
				->setLabel('Your Full Name')
				->addFilter('StripTags')
				//->setAttrib('size', 30)
				->setAttrib('class', "form-control")
				->addFilter('StringTrim')
				->addValidator('NotEmpty')
				->addValidator('stringLength', false, array(4, 50))
				->setValue('your name')
				//->addValidator($full_name_notempty, true, $full_name_value)
				->setAttrib('onfocus', $full_name_focus)
				->setAttrib('onblur', $full_name_blur)
				->addErrorMessage('Your full name is required, not more than 50 characters');
				
		$first_name = new Zend_Form_Element_Text('first_name');
		$first_name->setLabel('Full Name')
				->setRequired(true)
				->addFilter('StripTags')
				//->setAttrib('size', 35)
				->setAttrib('class', "form-control")
				->setAttrib('placeholder', 'first name')
				->addFilter('StringTrim')
				//->addValidator('NotEmpty')
				->addValidator('stringLength', false, array(2, 50))
				->addErrorMessage('First name required');
				
		$last_name = new Zend_Form_Element_Text('last_name');
		$last_name->addFilter('StripTags')
				->setLabel('Last Name')
				->setRequired(true)
				//->setAttrib('size', 35)
				->setAttrib('class', "form-control")
				->setAttrib('placeholder', 'surname')
				->addFilter('StringTrim')
				//->addValidator('NotEmpty')
				->addValidator('stringLength', false, array(2, 50))
				->addErrorMessage('Surname is required');				

		$email = new Zend_Form_Element_Text('email');
		$email->setRequired(true)
				->setLabel('Your Email')
				->addFilter('StripTags')
				//->setAttrib('size', 30)
				->setAttrib('class', "form-control")
				->setDescription('we will never share your email')
				->addValidator(new Zend_Validate_EmailAddress())
				->addFilter('StringTrim')
				->addFilter('StringToLower')
				->addErrorMessage("Your email is required and format is 'yourname@something.com'")
				->setAttrib('placeholder', "your email")
				->addValidator($email_notempty, true, $email_validate);

		$phone = new Zend_Form_Element_Text('phone');
		$phone->setLabel('Phone')
		       //->setAttrib('size', 30)
			   //->setRequired(true)
			   ->setAttrib('class', "form-control")
			   ->addFilter('StripTags')
			   ->addFilter('StringTrim')
			   ->addValidator('NotEmpty')
			   ->setAttrib('placeholder', 'Phone (optional)')
			   //->addErrorMessage('Phone is required and max length is 15 characters')
			   //->addValidator('StringLength', false, array(6, 15))
			   ;

		$company = new Zend_Form_Element_Text('Company');
		$company->setLabel('company')
		       //->setAttrib('size', 30)
			   ->setRequired(true)
			   ->setAttrib('class', "form-control")
			   ->setAttrib('placeholder', "your company name")
			   ->addFilter('StripTags')
			   ->addFilter('StringTrim')
			   ->addValidator('NotEmpty')
			   ->addErrorMessage('Company name is required and max length is 50 characters')
			   ->addValidator('StringLength', false, array(4, 100));

		$website = new Zend_Form_Element_Text('Website URL');
		$website->setLabel('website')
		       //->setAttrib('size', 30)
			   ->setRequired(true)
			   ->setAttrib('class', "form-control")
			   ->setAttrib('placeholder', "your website url")
			   ->addFilter('StripTags')
			   ->addFilter('StringTrim')
			   ->addValidator('NotEmpty')
			   ->addErrorMessage('website url is required and max length is 50 characters')
			   ->addValidator('StringLength', false, array(4, 100));

		$position = new Zend_Form_Element_Select('position');
		$position->setRequired(true)
		        ->setLabel('Your Role')
				->setAttrib('class', "form-control")
				->addErrorMessage('Your role is required')
				 ->setAttrib('placeholder', "what is your role?")
				->addMultiOptions(array(
				'' => 'please select your role',
				'VP/Director' => 'VP/Director',
				'Manager' => 'Manager',
				'Non-Manager' => 'Non-Manager',
				'Others' => 'Others'
				));			   
				
				
				
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton')
			   ->setAttrib('class', "btn btn-ridebliss btn-lg pull-right")	
		       ->setLabel('GET YOUR OFFER NOW');
		
		$this->addElements(array($contact_id, $first_name, $last_name, $email, $phone, $company, $website, $position, $submit));
		
		//	 add decorators to change the default Zend framework rendering
		// Change the entire form tag rendering

        $this->clearDecorators();
		$this->setDecorators(array(
               'FormElements',
              // array(array('data'=>'HtmlTag')),
               'Form'
       ));

		// Change the entire rendering of individual elements

	   $this->setElementDecorators(array(
	   'ViewHelper',
	   'Description',
	   //'Errors',
	   array('Errors', array('class' => 'post_ad_error')),	   
	   array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class'=>'col-md-12')),
	   //array('Label', array('class' => 'control-label col-sm-3')),
	   //array('Label', array('class' => 'control-label col-sm-4', 'escape' => false, 'requiredSuffix' => '<span class="leftnav_required">* </span>')),
	   array(array('row'=>'HtmlTag'),array('tag'=>'div', 'class' => 'form-group small'))
		   ));
		   
   
		$first_name->setDecorators(array(
		'ViewHelper',
	   'Description',
	   //'Errors',
	   array('Errors', array('class' => 'add_user_error_name')),   
	   array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class'=>'col-md-6 form-top-space')),
	   //array('Label', array('class' => 'control-label col-sm-3')),
	   //array('Label', array('class' => 'control-label col-sm-4 form-top-space', 'escape' => false, 'requiredSuffix' => '<span class="leftnav_required">* </span>')),
	   array(array('row'=>'HtmlTag'),array('tag'=>'div', 'class' => 'form-group small', 'openOnly'=>true))
		   ));
		   
		$last_name->setDecorators(array(
		'ViewHelper',
	   'Description',
	   //'Errors',
	   array('Errors', array('class' => 'add_user_error_name')),	   
	   array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class'=>'col-md-6 form-top-space')),
	   //array('Label', array('class' => 'control-label col-sm-3')),
	   //array('Label', array('class' => 'control-label col-sm-4', 'escape' => false, 'requiredSuffix' => '<span class="leftnav_required">* </span>')),
	   array(array('row'=>'HtmlTag'),array('tag'=>'div', 'class' => 'form-group small', 'closeOnly'=>true))
		   ));  		   

		   
		// buttons do not need labels
       $submit->setDecorators(array(
		'ViewHelper',
		'Description',
		'Errors', 
		array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class'=>'col-xs-6 col-xs-offset-3 col-md-8 col-md-offset-2')),
		array(array('row'=>'HtmlTag'),array('tag'=>'div', 'class' => 'form-group'))
        ));	   
		   
    }


}

