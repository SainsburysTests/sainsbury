<?php
namespace SainsburysBundle\Tests\Command;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use SainsburysBundle\Command\SainsburysCommand;

class SainsburysCommandTest extends KernelTestCase 
{
	public function testExecute()
    {
    	$kernel = $this->createKernel();
    	$kernel->boot();
        // mock the Kernel or create one depending on your needs
        $application = new Application($kernel);
        $application->add(new SainsburysCommandTest());

        $command = $application->find('sainburys::scrape');
        $commandTester = new CommandTester($command);
        $commandTester->execute();

        //$this->testExecute();	
        $this->assertRegExp('/.../', $commandTester->getDisplay());

        // ...
    }
    
    
}

