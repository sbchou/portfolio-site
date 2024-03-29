<?php
if(isset($_POST['name']) && empty($_POST['spam_check']))
{
	require 'email-validator.php';
	$validator = new EmailAddressValidator();
	
	$errors = array();
	
	$input_name = strip_tags($_POST['name']);
	$input_email = strip_tags($_POST['email']);
	$input_subject = strip_tags($_POST['subject']);
	$input_message = strip_tags($_POST['message']);

	$required = array('Name field' => 'name', 'Email field' => 'email', 'Message field' => 'message');
	
	foreach($required as $key=>$value)
	{
		if(isset($_POST[$value]) && $_POST[$value] !== '') 
		{
			continue;
		}
		else {
			$errors[] = "Please enter a message.";
		}
	}
	
    if (!$validator->check_email_address($input_email)) {
           $errors[] = 'Please enter a valid email address.';
    }
	
	if(empty($errors))
	{		
		if(mail('sbchou@gmail.com', "Message from $input_name - $input_subject", $input_message, "From: $input_email"))
		{
			echo 'Thank You - your email has been sent.';
		}
		else 
		{
			echo 'There was an issue when sending your email. Please try again.';
		}		
	}
	else 
	{
		echo implode('<br />', $errors);		
	}
}
else
{
	die('You cannot access this page directly.');
}