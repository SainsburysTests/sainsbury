<?php
// src/Sainsburys/Library/ScrapeClass.php
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
namespace SainsburysBundle\Library;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use SainsburysBundle\Library\Traits;
use Symfony\Component\Security\Core\Exception;
use Symfony\Component\Console\Output\OutputInterface;
use SainsburysBundle\Library\Client;
use SainsburysBundle\Library\Parser;



class Scrape extends ContainerAwareCommand
{
   use Singleton;

  /**
   *
   *  $source_url
   *
   * @access private
   * @var string zurich esure dlg
   */
   private $url = 'http://www.sainsburys.co.uk/webapp/wcs/stores/servlet/CategoryDisplay?listView=true&orderBy=FAVOURITES_FIRST&parent_category_rn=12518&top_category=12518&langId=44&beginIndex=0&pageSize=20&catalogId=10137&searchTerm=&categoryId=185749&listId=&storeId=10151&promotionId=#langId=44&storeId=10151&catalogId=10137&categoryId=185749&parent_category_rn=12518&top_category=12518&pageSize=20&orderBy=FAVOURITES_FIRST&searchTerm=&beginIndex=0&hideFilters=true';

  /**
   *
   *  $client
   *
   * @access private
   * @var browser
   */
   private $client = null;
   /**
    *
    *  $parse
    *
    * @access private
    * @var dom parser
    */
   private $parser = null;

   /**
   * construct
   *
   *@desc instantiate class
   *
   *@return void
   */
   public function __construct()
   {
   		
		$this->intializeClient();
		$this->intializeParser();
   }
   
   public function intializeClient()
   {
	   	try {
	   		$this->client = new Client();
	   	} catch (\Exception $e) {
	   		//$output->writeln("Message: " . $e->getCode() + " Code " . $e->getCode());
	   		die($e->getMessage() . __FILE__.__LINE__);
	   	}
   }
	
   public function intializeParser()
   {
   	try {
   		$this->parser = new Parser();
   	} catch (\Exception $e) {
   		die($e->getMessage() . __FILE__.__LINE__);
   		//$output->writeln("Message: " . $e->getCode() + " Code " . $e->getCode());
   	}
   }
   
   public function getClient()
   {
   	 return $this->client;
   }
   
   public function process()
   {
   		$products = array();
   		//fetch initial scrape from sainsburys
   		$response 	= $this->client->fetch($this->url);
   		
   		
   		$file = '/tmp/people.txt';
   		file_put_contents($file, $response);
   		
   		$this->client->close();
   		$elements 	= $this->parser->parse($response);
   		
   		
   		
   		if ($elements->length > 0) {
   			$index = 0;
   			foreach ($elements as $element) {
   				//link
	   			 foreach($element->getElementsByTagName('a') as $link) {
	   			 	$this->intializeClient();
	   			 	$linkPage = $this->client->fetch($link->getAttribute('href'));
	   			 	$linkSize = round(mb_strlen($linkPage, '8bit')/1024) . "kb";
	   			 	$this->client->close();
	        	 }
	        	
   				//get the node values
   				$nodeItems = array();
   				foreach (explode("\n",$element->nodeValue) as $nodeItem) {
   					if (!empty(trim($nodeItem))) {
   						$nodeItems[] = trim($nodeItem);
   					}
   				}
   				$products[$index]['title'] 		= $nodeItems[0];
   				$products[$index]['size']  		= $linkSize;
   				$price = preg_replace('/[a-z\/]/i', '', $nodeItems[2]);
   				$price = substr($price, 2,strlen($price));
   				$products[$index]['unit_price'] 	= $price;
   				$products[$index]['description'] 	= $nodeItems[3];
   				$index++;
   				
   			}
   		}
   		
   		return array(
   				'results'	=> $products,
   				'total'		=> $this->getPriceTotal($products)
   		);
   		
   }
   
   private function getPriceTotal($products = array()) {
   	  $total = 0;
   	  foreach ($products as $product) {
   	  	$total += $product['unit_price'];
   	  }
   	  return $total;
   }
   
}
