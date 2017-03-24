<?php
  session_start();
  require('oauth.php');
  require('outlook.php');

  $loggedIn = !is_null($_SESSION['access_token']);
  $redirectUri = 'https://www.solucions-im.com/php-office365/authorize.php';
?>

<html>
    <head>
      <title>PHP Mail API Tutorial</title>
    </head>
  <body>
    <?php 
      if (!$loggedIn) {
    ?>
      <!-- User not logged in, prompt for login -->
      <p>Please <a href="<?php echo oAuthService::getLoginUrl($redirectUri)?>">sign in</a> with your Office 365 or Outlook.com account.</p>
    <?php
      }
      else {
		$messages = OutlookService::getMessages($_SESSION['access_token'], $_SESSION['user_email']);
		$events = OutlookService::getEvents($_SESSION['access_token'], $_SESSION['user_email']);
		$contacts = OutlookService::getContacts($_SESSION['access_token'], $_SESSION['user_email']);
		
		print_r($messages);
    ?>
      <!-- User is logged in, do something here -->
      <h2>Your messages</h2>

      <table style="with:1000px">
        <tr>
          <th>From</th>
          <th>Subject</th>
          <th>Received</th>
        </tr>

        <?php foreach($messages['value'] as $message) { ?>
          <tr>
            <td><?php echo utf8_decode($message['From']['EmailAddress']['Name']) ?></td>
            <td><?php echo utf8_decode($message['Subject']) ?></td>
            <td><?php echo date("d-m-Y", strtotime($message['ReceivedDateTime']))?></td>
          </tr>
          <tr>
            <td colspan=3><?php echo utf8_decode($message['Body']['Content']) ?></td>
          </tr>
        <?php } ?>
      </table>

      <h2>Your events</h2>
      
      <table>
        <tr>
          <th>Subject</th>
          <th>Start</th>
          <th>End</th>
        </tr>
        
        <?php foreach($events['value'] as $event) { ?>
          <tr>
            <td><?php echo utf8_decode($event['Subject']) ?></td>
            <td><?php echo date("d-m-Y", strtotime($event['Start']["DateTime"])) ?></td>
            <td><?php echo date("d-m-Y", strtotime($event['End']["DateTime"])) ?></td>
          </tr>
        <?php } ?>
      </table>

      <h2>Your contacts</h2>
      
      <table>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email Address</th>
        </tr>
        
        <?php foreach($contacts['value'] as $contact) { ?>
          <tr>
            <td><?php echo $contact['GivenName'] ?></td>
            <td><?php echo $contact['Surname'] ?></td>
            <td><?php echo $contact['EmailAddresses'][0]['Address'] ?></td>
          </tr>
        <?php } ?>
      </table>
	<?php    
      }
    ?>
  </body>
</html>