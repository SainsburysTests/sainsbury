<?php
// src/Sainsburys/Library/Parse.php
/**
 * Sainsburys Parser Console App
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
namespace SainsburysBundle\Library;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use SainsburysBundle\Library\Traits;
use Symfony\Component\Security\Core\Exception;



class Parser extends ContainerAwareCommand
{
   use Singleton;
   
   /**
    *
    *  $dom
    *
    * @access private
    *
    */
   private $dom = null;
   

   /**
    *
    *  $xpath
    *
    * @access private
    *
    */
   private $xpath = "/html/body/div[@id='page']/div[@id='main']/div[@id='content']/div[@id='productsContainer']/div[@id='productLister']/ul/li";
   
   public function __construct()
   {
	   	try {
		   		//disable all the xpath related errors
		   		libxml_use_internal_errors(true);
		   		//dom part
		   		$this->dom = new \DOMDocument();
		   		$this->dom->recover = true;
		   		$this->dom->strictErrorChecking = false;
		   		 
	   		} catch (Exception $e) {
	   		$output->writeln("Message: " . $e->getCode() + " Code " . $e->getCode());
	   	}
   	}
   	public function parse($response) {
   		$this->dom->loadHTML($response);
   		$xpath = new \DOMXpath($this->dom);
   		$elements = $xpath->query($this->xpath);
   		//var_dump($elements);
   		//die(__FILE__.__LINE__);
   		return $elements;
   	}
}