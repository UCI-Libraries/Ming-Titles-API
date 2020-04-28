<?php

namespace App\Model;
//namespace Appl;

use Illuminate\Database\Eloquest\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

//class mingvirgo extends Model
class TitleList 

{
	
	//const titles_view = 'public.titles';
	const translations_view = 'public.translations';
	//const titles_view = 'public.titles_with_translations_merged';
	const titles_view = 'public.titles_with_translations_and_institutions';

   
	function __construct() 
	{
    	error_log(__METHOD__);
        //$this->db = app('db')->connection('virgo_ming');
        error_log('default time zone: ' . date_default_timezone_get());
    }// __construct(


	public function getTitleList() 
	{

       error_log(__METHOD__);
       $rec = null;
	   //$result = null;
		
       $db = app('db')->connection('virgo_ming');
       if ( is_object($db) ) 
	   {
       		error_log('querying data...');
            try {
            	    $fields = '';
                	$rec = current($db->table(self::titles_view) 
					  ->select('id', 'cbdb_id', 'chinese_title', 'pinyin_title', 'created_at', 'updated_at', 'alternate_chinese_title', 'alternate_pinyin_title', 'starting_date', 'ending_date', 'historical_changes', 'source_of_historical_changes', 'english_translation', 'instn1', 'instn2', 'instn3')
					   ->where('archived', '=', 'false')
					   ->orderBy('id', 'ASC')
                       ->get()
                     );   
		       } 
				catch ( QueryException $e ) 
				{
                	error_log('$e: ' . $e->getMessage());
            	}// cath QueryException/ try
        }//fi
				
        return $rec; 
    }// getTitleList()  
	
	
	//echo hex2str($n);

// shows chinese characters, properly

// hex2str is a nifty little function I found online:


	
	
	public function getTitles($data) 
	{	
		
		
		

       error_log(__METHOD__);
       $rec = null;
	   //$result = null;
	   $db = app('db')->connection('virgo_ming');
	   
       if ( is_object($db) ) 
	   {
       		error_log('querying data...');
            try 
			{
                $fields = '';
				error_log($data);
				$data = urldecode($data);
				//$data = ucwords(mb_strtolower($data, 'UTF-8'));
               	$rec = current($db->table(self::titles_view) 
			    ->select('id', 'cbdb_id', 'chinese_title', 'pinyin_title', 'created_at', 'updated_at', 'alternate_chinese_title', 'alternate_pinyin_title', 'starting_date', 'ending_date', 'historical_changes', 'source_of_historical_changes', 'english_translation', 'instn1', 'instn2', 'instn3')
				->Where('pinyin_title', "like", "%$data%") 
				->orWhere('id', "=", intval($data)) 
				->orWhere('chinese_title', "like", "%$data%")
				->orderBy('id', 'ASC')
                ->get()
                     );   	 
			} 
			catch ( QueryException $e ) 
			{
				error_log('$e: ' . $e->getMessage());
			}// cath QueryException/ try
        }//fi
		
        return $rec; 
		
    }// getTitles() 
} //class


				   
