<?php

class Application_Form_ContactUsForm extends Zend_Form
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

		$email = new Zend_Form_Element_Text('email');
		$email->setRequired(true)
				->setLabel('Your Email')
				->addFilter('StripTags')
				//->setAttrib('size', 30)
				->setAttrib('class', "form-control")
				->addValidator(new Zend_Validate_EmailAddress())
				->addFilter('StringTrim')
				->addFilter('StringToLower')
				->addErrorMessage("Your email is required and format is 'yourname@something.com'")
				->setValue('your email')
				->setAttrib('onfocus', $email_focus)
				->setAttrib('onblur', $email_blur)
				->addValidator($email_notempty, true, $email_validate);

		$phone = new Zend_Form_Element_Text('phone');
		$phone->setLabel('Phone')
		       //->setAttrib('size', 30)
			   //->setRequired(true)
			   ->setAttrib('class', "form-control")
			   ->addFilter('StripTags')
			   ->addFilter('StringTrim')
			   ->addValidator('NotEmpty')
			   ->setValue('Phone (optional)')
			   ->setAttrib('onfocus', $phone_optional_focus)
			   ->setAttrib('onblur', $phone_optional_blur)
			   //->addErrorMessage('Phone is required and max length is 15 characters')
			   //->addValidator('StringLength', false, array(6, 15))
			   ;		
		
		$message_type = new Zend_Form_Element_Select('message_type');
		$message_type->setRequired(true)
		        ->setLabel('Enquiry Type')
				->setAttrib('class', "form-control")
				->addErrorMessage('Enquiry type is required')
				//->setAttrib('class', 'active_select')
				->addMultiOptions(array(
				'' => 'select enquiry type',
				'Business Quote' => 'Business Quote',
				'Customer Support' => 'Customer Support',
				'Partnership' => 'Partnership',
				'General' => 'General Enquiry'
				));
		
		
		$message = new Zend_Form_Element_Textarea('message');
		$message->setRequired(true)
				->setLabel('Your Message')
				->setAttrib('cols', 23)
				->setAttrib('rows', 6)
				->setAttrib('class', "form-control")
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty')
				//->setValue('enter your message')
				->setAttrib('onfocus', $message_focus)
			    ->setAttrib('onblur', $message_blur);	
				
				
				
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton')
			   ->setAttrib('class', "btn btn-ridebliss btn-lg pull-right")	
		       ->setLabel('Contact Us');
		
		$this->addElements(array($contact_id, $title, $full_name, $email, $phone, $message_type, $message, $submit));
		
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
	   array(array('data'=>'HtmlTag'), array('tag' => 'div')),
	   array('Label'),
	   array(array('row'=>'HtmlTag'),array('tag'=>'div'))
           ));
		   
		   
		$title->setDecorators(array(
	   'ViewHelper',
	   'Description',
	   //'Errors',
       array('Errors', array('class' => 'post_ad_error')),	   
	   array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class'=>'col-md-9')),
	   array('Label', array('class' => 'control-label col-md-3', 'escape' => false, 'requiredSuffix' => '<span class="leftnav_required">* </span>')),
	   array(array('row'=>'HtmlTag'),array('tag'=>'div', 'class' => 'form-group'))
           ));
		   
		   
		$full_name->setDecorators(array(
		   'ViewHelper',
		   'Description',
		   //'Errors',
		    array('Errors'),
		   array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class'=>'col-md-9')),
		   array('Label', array('class' => 'control-label col-md-3', 'escape' => false, 'requiredSuffix' => '<span class="leftnav_required">* </span>')),
		   array(array('row'=>'HtmlTag'),array('tag'=>'div', 'class' => 'form-group'))
        ));  


		$email->setDecorators(array(
		   'ViewHelper',
		   'Description',
		   //'Errors',
		   array('Errors', array('class' => 'post_ad_error')),
		   array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class'=>'col-md-9')),
		   array('Label', array('class' => 'control-label col-md-3', 'escape' => false, 'requiredSuffix' => '<span class="leftnav_required">* </span>')),
		   array(array('row'=>'HtmlTag'),array('tag'=>'div', 'class' => 'form-group'))
        ));


		$phone->setDecorators(array(
		   'ViewHelper',
		   'Description',
		   //'Errors',
		   array('Errors', array('class' => 'post_ad_error')),
		   array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class'=>'col-md-9')),
		   array('Label', array('class' => 'control-label col-md-3', 'escape' => false, 'requiredSuffix' => '<span class="leftnav_required">* </span>')),
		   array(array('row'=>'HtmlTag'),array('tag'=>'div', 'class' => 'form-group'))
        ));	
		
		
		$message_type->setDecorators(array(
		   'ViewHelper',
		   'Description',
		   //'Errors',
		   array('Errors', array('class' => 'post_ad_error')),
		   array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class'=>'col-md-9')),
		   array('Label', array('class' => 'control-label col-md-3', 'escape' => false, 'requiredSuffix' => '<span class="leftnav_required">* </span>')),
		   array(array('row'=>'HtmlTag'),array('tag'=>'div', 'class' => 'form-group'))
        ));
		
		
		$message->setDecorators(array(
		   'ViewHelper',
		   'Description',
		   //'Errors',
		   array('Errors', array('class' => 'post_ad_error')),
		   array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class'=>'col-md-9')),
		   array('Label', array('class' => 'control-label col-md-3','escape' => false, 'requiredSuffix' => '<span class="leftnav_required">* </span>')),
		   array(array('row'=>'HtmlTag'),array('tag'=>'div', 'class' => 'form-group'))
        ));
		
		   
		   
		// buttons do not need labels
       $submit->setDecorators(array(
		'ViewHelper',
		'Description',
		'Errors', 
		array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class'=>'col-sm-12')),
		array(array('row'=>'HtmlTag'),array('tag'=>'div', 'class' => 'form-group'))
        ));	   
		   
    }


}

