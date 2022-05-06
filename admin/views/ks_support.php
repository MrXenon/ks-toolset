<?php

$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, ".php"));


$base_url = add_query_arg($params, $base_url);

if (isset($_POST['send'])){

$sname          = filter_var($_POST['sname'], FILTER_SANITIZE_STRING);
$onderdeel      = filter_var($_POST['onderdeel'],FILTER_SANITIZE_STRING);
$onderwerp      = filter_var($_POST['onderwerp'],FILTER_SANITIZE_STRING);
$email          = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$beschrijving   = filter_var($_POST['beschrijving'], FILTER_SANITIZE_STRING);

$message = 'Display name: ' . $sname . "\r\n" . 
'Subject: ' . $onderdeel . "\r\n". "\r\n" . 
'Description: ' .$beschrijving; 

$to = 'info@kevinschuit.com';
$subject = $onderwerp;
$headers = 'From: '. $email . "\r\n" .
'Reply-To: ' . $email . "\r\n";

$sent = wp_mail($to, $subject, strip_tags($message), $headers);
}

$current_user = wp_get_current_user();
$user_email   = $current_user->user_email;
$user_name   = $current_user->display_name;
?>
<div class="container">
<?php
if (isset($_POST['send'])){
    if($sent) {
        echo '<p class="alert alert-success">Support ticket has been succesfully send.</p>';
    }
    else  {
        echo '<p class="alert alert-warning">An errr occured, support ticket can not be send.</p>';
    }
}
?>

<h2>Support form</h2>
    <p>There is a problem which you would like us to solve.<br> 
    Through this form you're able to submit a ticket to our support staff.<br>
    As soon as they're able, you'll get notified about your ticket's status.</p>

    <p><strong>NOTE:</strong> One.com users have diffrent e-mail settings, where outbound mails do not work.<br>
    In order to submit a ticket, click the button underneath.</p>

    <input type="button" class="btn btn-dark" value="I can't submit a ticket" 
    onclick="window.location.href='mailto:info@kevinschuit.com?subject=Support%20ticket&body=Software%20Issue:%20Plugin|Theme|Something%20else %0D%0A %0D%0AIssue%20description: %0D%0A %0D%0ADomain%20url: %0D%0A %0D%0A';">
    <br>
    <br>

    <div class="row">
        <form action="<?=$base_url;?>" method="post">
            <div class="col-6">
            <div class="mb-3">
                <label for="sname" class="form-label">Display name</label>
                    <input type="text" class="form-control" required name="sname" id="sname" placeholder="Scherm naam" value="<?=$user_name?>">
                </div>
                <div class="mb-3">
                <label for="email" class="form-label">E-mail address</label>
                    <input type="e-mail" class="form-control" required name="email" id="email" placeholder="E-mail" value="<?=$user_email?>">
                </div>
                <div class="mb-3">
                <label for="onderwerp" class="form-label">Subject of the issue</label>
                    <input type="text" class="form-control" required name='onderwerp' id="onderwerp" placeholder="">
                </div>
                <div class="mb-3">
                <label for="Onderdeel" class="form-label">Select software issue partition </label>
                    <select class="form-control" required name="onderdeel">
                        <option value="Plug-in">Plug-in</option>
                        <option value="Theme">Theme</option>
                        <option value="Something else">Something else</option>
                    </select>
                </div>
                <div class="mb-3">
                <label for="beschrijving" class="form-label">Describe the issue in full detail</label>
                    <textarea class="form-control" required name="beschrijving" style="resize:none;" id="beschrijving" rows="10"></textarea>
                </div>
                <input type="submit" value="Submit ticket" name="send" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>