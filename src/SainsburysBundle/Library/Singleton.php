<?php
// src/Sainsburys/Library/Traits.php
/**
 * Sainsburys Srape Console App
 *
 * Traits.php, handles sraping of sainsburys products site and products a jason string, stored in a file
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

trait Singleton{
        /**
         *@access private
         * @var Object
         */
        private static $instance;
        
        public static function getInstance(){
                if(!(self::$instance instanceof self)){
                        self::$instance = new self();
                }
                return self::$instance;
        }
}
