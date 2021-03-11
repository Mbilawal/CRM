<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once('/var/www/html/dryvar.com/public_html/wonderpush-php-lib/init.php');

$wonderpush = new \WonderPush\WonderPush("NzY4ZWYzMDNhMjRlZWJlZTU3MjQ3MmFmZDJlNDBhZWIzYmVkNGYxODhlMGZkMjhhOWFiM2U3YzE3NjZlYjc1Mg", "01ehekuj745fi602");
$response = $wonderpush->deliveries()->create(
    \WonderPush\Params\DeliveriesCreateParams::_new()
        ->setTargetInstallationIds('7eefc707fff025d9cb71cbcb7d72481e94901c1e')
        ->setNotification(\WonderPush\Obj\Notification::_new()
		    ->setAlert(\WonderPush\Obj\NotificationAlert::_new()
                ->setAndroid(\WonderPush\Obj\NotificationAlertAndroid::_new()
					->setBigTitle('Hello')
					->setBigText('hghhg')
					->setBigPicture('https://cdn.by.wonderpush.com/upload/01ehekuj745fi602/cef4b0ca52ac0e7de8fe06876f571083dfe9c582')
					->setWhen('1599343043204')
					
            )))
);
print_r($response);
echo $response->getNotificationId();
?>