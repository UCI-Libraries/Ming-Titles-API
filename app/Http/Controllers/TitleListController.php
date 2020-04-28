<?php

namespace App\Http\Controllers;
//use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Model\TitleList;


error_log(__FILE__);

class TitleListController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	 
	private $TitleList  = null;
	private $TList  = null;
   
   	public function __construct() {
        error_log(__METHOD__);
        $this->TitleList = new TitleList();
		//  $this2->TList = new TList();
    }//__construct()
		
	//Archana
	public function listtitles()
    {
       //
		error_log(__METHOD__);
		  return '{"test":"db"}';
		 //return mingvirgo::all();
	}
	
	 
	// public function getLibraryHours(Request $req, $str) {
	public function getTitleList() 
	{
        error_log(__METHOD__);
		
		//$data = ['success' => false]; // TODO: use class var $this->data
		$TitleList = new TitleList();
		
		$list = $TitleList->getTitleList();	
		error_log('data: '. print_r($list, 1));
 
        if ( isset($list) && is_array($list) ) {
			error_log('GOT data!');
            $data['success'] = 'true';
            $data['list']    = $list;
        }//fi
		
		return response()->json($list);
		
    }// getTitleList()

	
	
	public function getTitles(Request $request, $data) 
	//public function getTitleList() 
	{
        error_log(__METHOD__);		
		//$data = ['success' => false]; // TODO: use class var $this->data
		$TitleList = new TitleList();
		
		$list = $TitleList->getTitles($data);	
		
		error_log('data: '. print_r($list, 1));
        if ( isset($list) && is_array($list) ) {
			error_log('GOT data!');
            $dat['success'] = 'true';
            $dat['list']    = $list;
        }//fi
		
		return response()->json($list);
		
    }// getTitles()

} //Controller class

