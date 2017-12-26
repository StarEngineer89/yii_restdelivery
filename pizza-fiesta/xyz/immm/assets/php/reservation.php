<?php
    $to = 'support@anpsthemes.com';
    $from = 'support@anpsthemes.com';
    $subject = 'Reservation on Kataleya';

    $message = '';
    $message .= '<table cellpadding="0" cellspacing="0">';

    if( isset($_POST['form_data']['day']) ) {
        $date = $_POST['form_data']['day'] . '.' . $_POST['form_data']['month'] . '.' . $_POST['form_data']['year'];
        $date .= ' at ' . $_POST['form_data']['hour'] . ':' . $_POST['form_data']['minute'];

        $message .= "<tr><td style='padding: 5px 20px 5px 5px'><strong>date:</strong>" . "</td><td style='padding: 5px; color: #444'>" . $date . "</td></tr>";
    }
    
    foreach ($_POST['form_data'] as $postname => $post) {
        if ($postname != "recaptcha_challenge_field" && $postname != "recaptcha_response_field" && $postname != 'day' && $postname != 'hour' && $postname != 'minute' && $postname != 'month' && $postname != 'year') {
            $message .= "<tr><td style='padding: 5px 20px 5px 5px'><strong>" . urldecode($postname) . ":</strong>" . "</td><td style='padding: 5px; color: #444'>" . $post . "</td></tr>";
        }
    }

    $message .= '</table>';

    $headers = 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
?>