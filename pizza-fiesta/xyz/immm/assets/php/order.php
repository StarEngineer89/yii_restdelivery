<?php
    $to = 'support@anpsthemes.com';
    $from = 'support@anpsthemes.com';
    $subject = 'Order on Kataleya';

    $message = '';

    /* Order */

    $message .= '<h3>Order</h3>';
    $message .= '<table cellpadding="0" cellspacing="0">';
    foreach ($_POST['order_items'] as $key => $value) {
        $message .= "<tr><td style='padding: 5px 20px 5px 5px'><strong>" . urldecode($key) . ":</strong>" . "</td><td style='padding: 5px; color: #444'>" . $value . "</td></tr>";
    }
    $message .= '</table>';

    /* Delivery information */

    $message .= '<h3>Delivery information</h3>';
    $message .= '<table cellpadding="0" cellspacing="0">';
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