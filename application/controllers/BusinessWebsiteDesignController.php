<?php

class BusinessWebsiteDesignController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
	
    public function getOfferAction()
    {
        $this->view->baseUrl = $this->_request->getBaseUrl();
		
		$leadForm = new Application_Form_LeadForm();
		
			
		$leadForm->setMethod('post');
		
		$leadForm->setAttrib('enctype', 'multipart/form-data');
		$this->view->form = $leadForm;
		
			if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($leadForm->isValid($formData)) {
			$lead_id = $leadForm->getValue('lead_id');
			$first_name = ucwords($leadForm->getValue('first_name'));
			$last_name = ucwords($leadForm->getValue('last_name'));
			$email = strtolower($leadForm->getValue('email'));
			$phone = $leadForm->getValue('phone');
			$company = $leadForm->getValue('company');
			$website = strtolower($leadForm->getValue('website'));
			$position = $leadForm->getValue('position');
			$budget = $leadForm->getValue('budget');
			
			$sent_date = date('Y-m-d H:i:s');
		
			$contactUs = new Application_Model_DbTable_LeadDetails();

			$contactUs->addLeadContact($lead_id, $first_name, $last_name, $email, $phone, $company, $website, $position, $budget, $sent_date);
			
			$visitor_message = $message;
			
			//$this->view->visitor_message = $visitor_message;
			
			$full_name = "$first_name $last_name";
			
			$mail_message .="<p>Hi Admin,</p>";
			$mail_message .="<p>Here is a new message from $first_name $last_name :</p>";
			$mail_message .="<div>Full Name: $first_name $last_name</div>";
			$mail_message .="<div>Email: $email</div>";
			$mail_message .="<div>Phone: $phone</div>";
			$mail_message .="<div>Company: $company</div>";
			$mail_message .="<div>Website: $website</div>";
			$mail_message .="<div>Position: $position</div>";
			$mail_message .="<div>Sent Date: $sent_date</div>";
			$mail_message .="<p>Regards</p>";
			$mail_message .="<p><br></p>";
			$mail_message .="<p>Vantworks Team</p>";
			$mail_message .= "</body></html>";
			

			// now call the zend_mail function
			/**
			$config = array('auth' => 'login',
				'username' => 'hello@vantworks.co.uk',
				'password' => 'h3llo!23');

			$transport = new Zend_Mail_Transport_Smtp('mail.vantworks.co.uk', $config);


			$mail = new Zend_Mail();
			$mail->setBodyHtml($mail_message);
			$mail->setBodyText($mail_message);
			$mail->setFrom('hello@vantworks.co.uk', 'Vantworks');
			$mail->addTo("chuxeze@yahoo.com", "Chuks Ndubueze");
			$mail->setSubject("Vantworks: Contact Us Message from $full_name");
			$mail->send($transport);
			**/
			
			
			$successMessage = "<strong>Thanks $first_name $last_name for contacting us.</strong> <p>We have received your message. We shall be in touch shortly.</p>";
			
			$this->view->successMessage = $successMessage;
			
			$this->view->lead_id = $lead_id; // NOTE this 'lead_id' is used in the view script IF condition
			
			//capture $first_name in session variable
			//session_start();
			$_SESSION["firstname"] = $first_name;
			
			//define flash Messenger to be used as confirmation message in redirect page, addSuccess Action
			// this prevents duplicate Rides post by this action
				
			$this->_helper->flashMessenger->addMessage($first_name);		
				
			//redirect page to a different URL (BusinessWebsiteDesign/offer-thank-you view script) to prevent duplicate request			
	
			
			//$this->_helper->redirector('offer-thank-you');
			$this->_redirect('business-website-design/offer-thank-you');

			} else {
	      $leadForm->populate($formData);
		  
		           }
			}
    }


    public function offerThankYouAction()
    {
		// This is used as a redirect page for getOffer Action
		
		$offerReceived = $this->_helper->flashMessenger->getMessages();
		
		$this->view->offerReceived = $offerReceived;
		
		if ($offerReceived) {
			
			$first_name = $offerReceived[0];	
			$_SESSION['first_name'] = $first_name;	
		}
		$this->view->first_name = $_SESSION['first_name'];		
		
    }
		

    

}















