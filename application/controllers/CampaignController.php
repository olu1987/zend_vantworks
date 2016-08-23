<?php

class CampaignController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
	
    public function websiteDevelopmentAction()
    {
        $this->view->baseUrl = $this->_request->getBaseUrl();
		
		$contactUsForm = new Application_Form_LeadForm();
		
			
		$contactUsForm->setMethod('post');
		
		$contactUsForm->setAttrib('enctype', 'multipart/form-data');
		$this->view->form = $contactUsForm;
		
			if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($contactUsForm->isValid($formData)) {
			$contact_id = $contactUsForm->getValue('contact_id');
			$title = $contactUsForm->getValue('title');
			$full_name = $contactUsForm->getValue('full_name');
			$email = $contactUsForm->getValue('email');
			$phone = $contactUsForm->getValue('phone');
			$message_type = $contactUsForm->getValue('message_type');
			$message = $contactUsForm->getValue('message');
			$budget = $contactUsForm->getValue('budget');
			
			
			$sent_date = date('Y-m-d H:i:s');
		
			$contactUs = new Application_Model_DbTable_ContactUs();

			$contactUs->addContactMsg($contact_id, $title, $full_name, $email, $phone, $message_type, $message, $budget, $sent_date);
			
			$visitor_message = $message;
			
			//$this->view->visitor_message = $visitor_message;
			
			//$full_name = ucwords($full_name);
			
			$mail_message .="<p>Hi Admin,</p>";
			$mail_message .="<p>Here is a new message from $full_name :</p>";
			$mail_message .="<div>Title: $title</div>";
			$mail_message .="<div>Full Name: $full_name</div>";
			$mail_message .="<div>Email: $email</div>";
			$mail_message .="<div>Phone: $phone</div>";
			$mail_message .="<div>Sent Date: $sent_date</div>";
			$mail_message .="<div>Message Type: $message_type</div>";
			$mail_message .="<div>Message: $visitor_message</div>";
			$mail_message .="<p>Regards</p>";
			$mail_message .="<p><br></p>";
			$mail_message .="<p>AACSL Team</p>";
			$mail_message .= "</body></html>";
			

			// now call the zend_mail function

			$config = array('auth' => 'login',
				'username' => 'hello@vantworks.co.uk',
				'password' => 'h3llo!23');

			$transport = new Zend_Mail_Transport_Smtp('mail.ridebliss.com', $config);


			$mail = new Zend_Mail();
			$mail->setBodyHtml($mail_message);
			$mail->setBodyText($mail_message);
			$mail->setFrom('hello@vantworks.co.uk', 'Vantworks');
			$mail->addTo("chuxeze@yahoo.com", "Chuks Ndubueze");
			$mail->setSubject("Vantworks: Contact Us Message from $full_name");
			$mail->send($transport);
			
			
			$successMessage = "<strong>Thanks $full_name, for contacting us.</strong> <p>We have received your message. We shall be in touch shortly.</p>";
			
			$this->view->successMessage = $successMessage;
			
			$this->view->contact_id = $contact_id; // NOTE this 'contact_id' is used in the view script IF condition
			
			
			
			
			
			
			} else {
	      $contactUsForm->populate($formData);
		  
		           }
			}
    }	

    

}















