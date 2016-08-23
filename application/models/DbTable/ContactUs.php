<?php

class Application_Model_DbTable_ContactUs extends Zend_Db_Table_Abstract
{

    protected $_name = 'contact_us';
	
	
	public function getContactMsg($contact_id)
	{
	$contact_id = (int)$contact_id;
	$row = $this->fetchRow('contact_id = ' . $contact_id);
	if (!$row) {
	throw new Exception("Could not find row $contact_id");
	}
	return $row->toArray();
	}

	
	
	public function addContactMsg($contact_id, $title, $first_name, $last_name, $email, $phone, $message_type, $budget, $message, $sent_date)
	
	{
	$data = array(
	'contact_id'=>$contact_id,
	'title'=>$title,
	'first_name' => $first_name,
	'last_name' => $last_name,	
	'email' => $email,
	'phone' =>$phone,
	'message_type' =>$message_type,
	'budget' =>$budget,
	'message' =>$message,
	'sent_date' =>$sent_date,
	'replied_date' =>$sent_date
	);
	$this->insert($data);
	}


}

