<html>
<head></head>
<body style="padding:0;margin:0;color:red;">
<div class="sections section-grey">
    <div class="container">
        <div style="font-family:Arial,Helvetica,sans-serif;padding:20px;line-height:1.5em;">
            <?php
            if (isset($body['errors']) && is_array($body['errors'])) { ?>
                <?php foreach ($body['errors'] as $error) { ?>
                    <?= $error['description'] ?> <?= $error['property'] ?><br/>
                <?php } ?>
            <?php } elseif (isset($body['statusCode']) && $body['statusCode'] == '2001') { ?>
                The authorisation was rejected by the vendor rule-base. Please check your billing address and CSV. Alternatively,  you can also get this error if you incorrectly enter your card details three times.
            <?php } elseif (isset($body['status']) && $body['status'] == 'NotAuthenticated') { ?>
                3-D secure authentication failed.
            <?php } elseif (isset($body['status']) && $body['status'] == 'Error') { ?>
                3-D secure authentication error.
            <?php } elseif (isset($body['status']) && $body['status'] == 'AttemptOnly') { ?>
                Card not enrolled in 3-D secure authentication scheme.
            <?php } elseif (isset($body['status']) && $body['status'] == 'Incomplete') { ?>
                3D secure authentication is not available.
            <?php } elseif (isset($body['description'])) { ?>
                <?= $body['description'] ?>
            <?php } elseif (isset($body['statusDetail'])) { ?>
                <?= $body['statusDetail'] ?>
            <?php } else { ?>
                <?= json_encode($body) ?>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>
