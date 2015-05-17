<?php
// src/Sainsburys/Command/SainsburysCommand.php
/**
 * Sainsburys Srape Console App
 *
 * SainsburyCommand.php, handles sraping of sainsburys products site and products a jason string, stored in a file
 *
 * PHP version 5.4
 *
 * @category  Symfony Console App
 * @package   Sainsburys Scrape Tool
 * @author    Henry Sabiti-Macrae <henry.sabiti@yahoo.co.uk>
 * @copyright 2015 Henry Sabiti-Macrae
 * @license   GPL
 * @version   git: $Id: SainsburysCommand.php hsabiti $
 * @link      https://dummylink/
 */
namespace SainsburysBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Security\Core\Exception;
use SainsburysBundle\Library\Scrape;
class SainsburysCommand extends ContainerAwareCommand
{
   
   /**
   * configure
   *
   *@desc setup the console app
   *
   *@return void
   */
    protected function configure()
    {
        $this
            ->setName('sainsburys:scrape')
            ->setDescription('Scrape Sainburys Product Page')
        ;
    }
   /**
   * execte
   *
   *@desc execure the console app
   *
   *@return void
   */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
	        	// create a new progress bar (50 units)
	        	$progress = new ProgressBar($output, 50);
	        	
	        	// start and displays the progress bar
	        	$progress->start();
	        	// advance the progress bar 1 unit
	        	$progress->advance(25);
	        	//instantiate scrape tool
                $scrape = Scrape::getInstance();
                $response_array = $scrape->process();
                $output->writeln("\n ========== Sainburys Scraped Page JSON =========\n");
                $output->writeln(json_encode($response_array));
                $progress->advance(25);
                $progress->finish();

        } catch (Exception $e) {
                $output->writeln("Message: " . $e->getCode() + " Code " . $e->getCode());
        }

        
        $output->writeln("\n");
    }
}


