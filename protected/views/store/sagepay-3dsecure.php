<html>
<head></head>
<body style="padding:0;margin:0;">
<div class="sections section-grey">
    <div class="container">
        <div class="row top30">
            <form id="pa-form" method="post" action="<?= $acsUrl ?>" target="3d-secure-iframe">
                <input type="hidden" name="PaReq" value="<?= $paReq ?>">
                <input type="hidden" name="TermUrl" value="<?= $termUrl ?>">
                <input type="hidden" name="MD" value="<?= $transactionId . '{{&}}' . $orderId ?>">
            </form>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var b = document.getElementById("pa-form");
                    b && b.submit();
                });
            </script>
            <iframe name="3d-secure-iframe" height="450" width="100%" style="border:none;"></iframe>
        </div>
    </div>
</div>
</body>
</html>
