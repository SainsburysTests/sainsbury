<?php
// src/Sainsburys/Library/Client.php
/**
 * Sainsburys Client Console App
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



class Client extends ContainerAwareCommand
{
   use Singleton;
   
   /**
    *
    *  $agent
    *
    * @access private
    * 
    */
   private $agent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.204 Safari/534.16';
   
   /**
    *
    *  $client
    *
    * @access private
    *
    */
   private $client = null;
   
   /**
    * construct
    *
    *@desc instantiate class
    *
    *@return void
    */
   public function __construct()
   {
   	try {
   		    
	   		$this->client = curl_init();
	   		
	   		curl_setopt($this->client, CURLOPT_CUSTOMREQUEST, 'GET');
	   		curl_setopt($this->client, CURLOPT_HTTPHEADER, array('Content-type: text/html'));
	   		curl_setopt($this->client, CURLOPT_COOKIEJAR,  __DIR__."/../../../tmp/cookie.tmp");
	   		curl_setopt($this->client, CURLOPT_COOKIEFILE, __DIR__."/../../../tmp/cookie.tmp");
	   		curl_setopt($this->client, CURLOPT_RETURNTRANSFER, true);
	   		curl_setopt($this->client, CURLOPT_FOLLOWLOCATION, true);
	   		curl_setopt($this->client, CURLOPT_VERBOSE, false);
	   		curl_setopt($this->client, CURLOPT_USERAGENT, $this->agent);
	   		
	   		//$file = '/tmp/people.txt';
	   		//file_put_contents($file, $response);
   			//$elements = $xpath->query("/html/body/div[@id='page']/div[@id='main']/div[@id='content']/div[@id='productsContainer']/div[@id='productLister']/ul[@id='productLister']");
   	
   			//var_dump($elements);
   			//die(__FILE__.__LINE__);
   	} catch (Exception $e) {
   		$output->writeln("Message: " . $e->getCode() + " Code " . $e->getCode());
   	}
   }
   
   public function fetch($url)
   {
 		if (!$url) {
 			throw new \Exception('No Source URL Provided');
 		}
 		try {
 			curl_setopt($this->client, CURLOPT_URL, $url);
 			$response = curl_exec($this->client);
 			return $response;
 		} catch (Exception $e) {
 			$output->writeln("Message: " . $e->getCode() + " Code " . $e->getCode());
 		} 	
   }
   public function close()
   {
   		try {
   			 curl_close($this->client);
   		} catch (Exception $e) {
   			$output->writeln("Message: " . $e->getCode() + " Code " . $e->getCode());
   		}
   }
}