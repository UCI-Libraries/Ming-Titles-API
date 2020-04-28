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
    //private $data = ['success' => false];
	 //private $data2 = ['success' => false];
   
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
	
	 public function show($id)
    {
        return TitlesList::findOrFail($id);
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
/*	*/
	public function getTitleListByID(Request $request, $id) 
	//public function getTitleList() 
	{
        error_log(__METHOD__);		
		//$data = ['success' => false]; // TODO: use class var $this->data
		$TitleList = new TitleList();
		
		//$list->id = $request->input('id');
		
		//$id = $request->input('id');
		//print_r($id);
		//error_log($id);
		$list = $TitleList->getTitleListByID($id);	
		//$list = $TitleList->getTitleList();	
		//	$list = $TitleList::all();		
		
	//	$data2 = ['success' => false]; // TODO: use class var $this->data
		error_log('data: '. print_r($list, 1));
        if ( isset($list) && is_array($list) ) {
			error_log('GOT data!');
            $data['success'] = 'true';
            $data['list']    = $list;
        }//fi
		
		//if ($request->has('id'))
		//{
	//		return response()->json($list);
		//}
		//else
			return response()->json($list);
		
    }// getTitleList()
	
	public function getTitleListByChnTit(Request $request, $chinese_title) 
	//public function getTitleList() 
	{
        error_log(__METHOD__);		
		//$data = ['success' => false]; // TODO: use class var $this->data
		$TitleListC = new TitleListC();
		
		//$list->id = $request->input('id');
		
		//$id = $request->input('id');
		//print_r($id);
		//error_log($id);
		$list = $TitleListC->getTitleListByChnTit( $chinese_title);	
		//$list = $TitleList->getTitleList();	
		//	$list = $TitleList::all();		
		
	//	$data2 = ['success' => false]; // TODO: use class var $this->data
		error_log('data: '. print_r($list, 1));
        if ( isset($list) && is_array($list) ) {
			error_log('GOT data!');
            $data['success'] = 'true';
            $data['list']    = $list;
        }//fi
		
		//if ($request->has('id'))
		//{
	//		return response()->json($list);
		//}
		//else
			return response()->json($list);
		
    }// getTitleList()
	
	
	public function getTitleListByPinTit(Request $request, $pinyin_title) 
	//public function getTitleList() 
	{
        error_log(__METHOD__);		
		//$data = ['success' => false]; // TODO: use class var $this->data
		$TitleList = new TitleList();
		
	//	$list->id = $request->input('id');
		//	$list->pinyin_title = $request->input('pinyin_title');
		// error_log('$id    = ' . $id);
        error_log('$pinyin_title = ' . $pinyin_title);
		//$id = $request->input('id');
		//print_r($id);
		//error_log($id);
		$list = $TitleList->getTitleListByPinTit( $pinyin_title);	
		//$list = $TitleList->getTitleList();	
		//	$list = $TitleList::all();		
		
	//	$data2 = ['success' => false]; // TODO: use class var $this->data
		error_log('data: '. print_r($list, 1));
        if ( isset($list) && is_array($list) ) {
			error_log('GOT data!');
            $data['success'] = 'true';
            $data['list']    = $list;
        }//fi
		
		//if ($request->has('id'))
		//{
	//		return response()->json($list);
		//}
		//else
			return response()->json($list);
		
    }// getTitleList()
	
	public function getTitles(Request $request, $data) 
	//public function getTitleList() 
	{
        error_log(__METHOD__);		
		//$data = ['success' => false]; // TODO: use class var $this->data
		$TitleList = new TitleList();
		
	//	$list->id = $request->input('id');
		//	$list->pinyin_title = $request->input('pinyin_title');
		// error_log('$id    = ' . $id);
//        error_log('$pinyin_title = ' . $pinyin_title);
		//$id = $request->input('id');
		//print_r($id);
		//error_log($id);
		$list = $TitleList->getTitles($data);	
		//$list = $TitleList->getTitleList();	
		//	$list = $TitleList::all();		
		
	//	$data2 = ['success' => false]; // TODO: use class var $this->data
		error_log('data: '. print_r($list, 1));
        if ( isset($list) && is_array($list) ) {
			error_log('GOT data!');
            $dat['success'] = 'true';
            $dat['list']    = $list;
        }//fi
		
		//if ($request->has('id'))
		//{
	//		return response()->json($list);
		//}
		//else
			return response()->json($list);
		
    }// getTitles()
/*	public function getTitles(Request $request) 
	//public function getTitleList() 
	{
		
		$titles = Titles::where('is_active', true);
		
		 if ($request->has('id')) {
            $titless->where('id', '=', $request->id);
        }

        if ($request->has('chinese_title')) {
             $titless->where('chinese_title', '=', $request->chinese_title);
        }

        if ($request->has('pinyin_title')) {
             $titless->where('pinyin_title', '=', $request->pinyin_title);
        }

        return $titles->get();
        
    }// getTitleList()
	*/
/*	public function myfirstapi()
	{
		$data = [
			'name' => 'Archana',
			'email' => 'achaudhr@uci.edu'
		];		
	return response()->json($data);	
	}*/
} //Controller class

