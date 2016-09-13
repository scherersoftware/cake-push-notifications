<?php
    use Cake\Core\Configure;
?>

<h1 class="page-header">
    Push Notifications
</h1>

<div class="row">
    <div class="col-md-6">
        <h3>
            iOS
        </h3>
        <hr>
        <?php if (is_readable(Configure::read('CakePushNotifications.apnsCertificatePath'))) : ?>
            <i class="fa fa-circle" style="color: #2ECC71;"></i> APNs Certificate
        <?php else : ?>
            <i class="fa fa-circle" style="color: #D73C2C;"></i> APNs Certificate
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <h3>
            Android
        </h3>
        <hr>
        <i class="fa fa-circle" style="color: #2ECC71;"></i> FCM API Key
    </div>
</div>

<br>
<br>

<h3>
    Send Message
</h3>
<hr>