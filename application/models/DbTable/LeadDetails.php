<?php

class Application_Model_DbTable_LeadDetails extends Zend_Db_Table_Abstract
{

    protected $_name = 'leads';
	
	
	public function getContactMsg($lead_id)
	{
	$lead_id = (int)$lead_id;
	$row = $this->fetchRow('lead_id = ' . $lead_id);
	if (!$row) {
	throw new Exception("Could not find row $lead_id");
	}
	return $row->toArray();
	}

	
	
	public function addLeadContact($lead_id, $first_name, $last_name, $email, $phone, $company, $website, $position, $budget, $sent_date)
	
	{
	$data = array(
	'lead_id'=>$lead_id,
	'first_name' => $first_name,
	'last_name' => $last_name,
	'email' => $email,
	'phone' =>$phone,
	'company' =>$company,
	'website' =>$website,
	'position' =>$position,
	'budget' =>$budget,
	'sent_date' =>$sent_date
	);
	$this->insert($data);
	}


}

