<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $config = $this->getServiceLocator()->get('Config');
        $emailConfig = $config['email'];

        $html = new MimePart('<h3>Estou enviando este mensagem para você</h3>');
		$html->type = "text/html";

		$body = new MimeMessage();
		$body->setParts(array($html));


        $message = new Message();
        $message->addTo('wesley@php.com')
        		->addFrom('luiz@luiz.com')
        		->setSubject('Enviando e-mail teste')
        		->setBody($body);

        $transport = new SmtpTransport();
        $options = new SmtpOptions([
        	'name' => $emailConfig['host'],
        	'host' => $emailConfig['host'],
        	'connection_class' => $emailConfig['auth'],
        	'port' => $emailConfig['port'],
        	'connection_config' => [
        		'username' => $emailConfig['username'],
        		'password' => $emailConfig['password'],
        		'ssl' => $emailConfig['ssl']
        	]
        ]);

        $transport->setOptions($options);
        $transport->send($message);
    }
}
