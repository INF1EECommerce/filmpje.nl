<?php

class DateHelper
{
    private static $vandaag;
    private static $morgen;
    private static $overmorgen;
    private  static $initialized = false;


    private static function init()
    {
       if (self::$initialized)
                return;

      
      self::$vandaag =  date('Ymd',time());
      self::$morgen =  date('Ymd', time()+86400);
      self::$overmorgen =  date('Ymd', time()+172800);
      self::$initialized = true;
    }
    
    
    public static function DatumVandaag()
    {
        self::init();
        
        return self::$vandaag;
        
    }
    
    public static function DatumMorgen()
    {
        self::init();
        
        return self::$morgen;
        
    }
    
    public static function DatumOvermorgen()
    {
        self::init();
        
        return self::$overmorgen;
        
    }
    
    public static function VertaalDatumNaarVandaagMorgenOvermorgen($datum)
    {
       self::init();
       $datum = date('Ymd', strtotime($datum));
       
       switch ($datum) {
            case self::$vandaag:
                return "Vandaag";
                break;
            
            case self::$morgen:
                return "Morgen";
                break;
                
            case self::$overmorgen:
                return "Overmorgen";
                break;
                
            default:
                return $datum;
                break;
        }
    }
}


?>
