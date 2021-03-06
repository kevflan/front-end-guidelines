<?php
if (!empty($_POST))
{
    $time = time();
	$form_time = $_POST['time'];
	$threshold = 5; // Anything filling out the form in fewer than this number of seconds is likely a bot.
	
	if( ($time - $form_time) < $threshold )
	{
		echo "<p>Sorry, your entry appeared too similar to a robot. If you're not a robot, please hit back and try again.</p>";
	}
	else
	{
		//logs the form data into the portal
		   require_once ENV_ROOT.'/portal/libraries/formLogger.api.php';
			    $logger = new formLoggerApi();
			    $logger->setSiteId($siteData['site.id']);
			    $logger->setSessionId($siteDefineData['cms_tracking_sessions']['session.id']);
			    $logger->setFormId('form_logger_');
			    $logger->setFormName('Refer A Friend');
			    $logger->setNotificationEmailAddresses('john@john.com');
			    
			    if ($logger->saveData($_POST)) {
			        echo '<h1>Successfully saved!</h1>';
			    } else {
			        echo '<h1>It looks like something went wrong.</h1>';
			    }


		// Lets try to send a person an email 
	    $subject = 'You Have Been Refered To Finished Basements Plus';
		$headers = 'Content-type: text/html; charset=utf-8'; 
		$headers .= 'MIME-Version: 1.0';
		$headers .= 'Bcc: basementsystems.emailcache@gmail.com';
		$headers .= 'From: no-replay@basementsystems.com';
		$headers .= 'Reply-To: no-replay@basementsystems.com';
		$headers .= 'Return-Path: no-replay@basementsystems.com';
		$headers .= 'Bcc: basementsystems.emailcache@gmail.com';

		$message = '
		<table cellpadding="0" cellspacing="0" width="629">
		<tbody><td>

		<h3>Dear '.$_POST['Name_r'].'</h3>
		<p>Your friend, '.$_POST['Name_r'].', has referred you to us!</p>
		<p>We have received your information and a representative from our company will be contacting you soon to discuss the project and gather additional information.</p>

		<p>If you prefer, you can contact us directly at: Finished Basements Plus [phone]</p>

		<p>Our Business Hours: Monday- Friday 9am to 5pm</p>

		<p>Fee free to: <a href="">Browse our Photo Gallery</a>, <a href="">Read Reviews From Customers Near You</a> and <a href="">Read Testimonials From Customers Near You</a></p>

		<p>Check us out on: <a href="">Instagram</a>, <a href="">Twitter</a>, and <a href="">Facebook</a>!</p>

		<p>Thank you for the interest in our company. We look forward to talking to you!</p>

		<img src="http://d6449bb3dc657045bfc9-290115cc0d6de62a29c33db202ae565c.r80.cf1.rackcdn.com/283/FinishedBasementPluslogo.png" alt="" />
		</td>
		</tbody>
		</table>
		';
        
		$to = $_POST['Email_Address'];
		$bcc_email = '';
		mail($to, $subject, $message, $headers);
		
		
		echo '<h1>Thanks for contacting us!</h1><p>We have received your information, and one of our specialists will contact you soon  regarding our Education Seminar</p>';
	}
}
else
{
	echo '
		<p>Unable to access this page directly.</p>
	';
}
?>
