<?php
namespace Arcmedia\Slackbot\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Slackbot extends AbstractHelper
{
    protected $botName = "SlackBot";
    protected $botIcon = "https://www.akeneo.com/wp-content/uploads/2013/09/icon-magento.png";
    protected $webhook = false; //define a slack webhook in your project
    
    
    CONST ENABLE = 'arcmedia_slackbot/general/enable';
    CONST WEBHOOK = 'arcmedia_slackbot/general/url';
    
    
    public function __construct(
        Context $context
    ){
        parent::__construct($context);
    }
    
    public function getEnable() {
        return $this->scopeConfig->getValue(self::ENABLE);
    }//END getEnable($)
    public function getWebhook()
    {
        $webhookConfig = $this->scopeConfig->getValue(self::WEBHOOK);
        if ($webhookConfig) {
            return $webhookConfig;
        }
        return false;
    }
    
    public function send(string $text)
    {
        if (!$this->getEnable()) {
            return;
        }
        
        $arrData = [
            "text" => php_uname("n").": ".$text,
            "username" => $this->botName,
            "icon_url" => $this->botIcon,
        ];
        $data = array(
            "payload" => json_encode($arrData, JSON_UNESCAPED_UNICODE),
        );
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $webhook = $this->getWebhook();
        if ($webhook) {
            file_get_contents($webhook, false, $context);
        }
    }
    
}