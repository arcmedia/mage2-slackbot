<?php

namespace Arcmedia\Slackbot\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Encryption\Encryptor;
use Arcmedia\Slackbot\Helper\Slackbot;

class Deployed extends Command
{
    protected $helper;
    public $encryptor;
    
    public function __construct(
        Slackbot $helper,
        Encryptor $encryptor
    ) {
        parent::__construct();
        $this->encryptor = $encryptor;
        $this->helper = $helper;
    }
    
    protected function configure()
    {
        $this->setName('arcmedia:slackbot:deployed')->setDescription('Notify Slackbot that deployment is done');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $content = $this->helper->send(php_uname("n")." has finished deployment");
    }
}
