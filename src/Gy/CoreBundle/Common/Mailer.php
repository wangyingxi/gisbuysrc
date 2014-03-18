<?php

class Mailer extends \Symfony\Component\HttpKernel\Tests\Controller {
    
    public function sendMail() {
        $this->get('doctrine_mongodb');
    }

}
