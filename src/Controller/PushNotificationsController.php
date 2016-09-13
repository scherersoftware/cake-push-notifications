<?php
namespace Scherersoftware\CakePushNotifications\Controller;

class PushNotificationsController extends AppController
{
    /**
     * index function
     *
     * @return void
     */
    public function index()
    {
        $this->viewBuilder()->layout('Admin.default');
    }
}
