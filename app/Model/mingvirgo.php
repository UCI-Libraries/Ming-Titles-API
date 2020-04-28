<?php

namespace App\Model;

//use Illuminate\Database\Eloquest\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

//class mingvirgo extends Model
class mingvirgo

{
	//
	protected $table = "titles";	
	
	
	//const CAL_VIEW = 'libraryCalendar.dbo.vw_library_calendar';
	const titles_view = 'mingTitles_production.titles';

    private $db = null; //
    private $data = ['today' => null, 'week' => null, 'month' => null];
	
	  function __construct() {
        error_log(__METHOD__);
        $this->db = app('db')->connection('virgo_ming');
        error_log('default time zone: ' . date_default_timezone_get());
    }// __construct(

//


    public function fetch($obj) {
        error_log(__METHOD__);

        $week = property_exists($obj, 'week') ? 1: 0;

        $this->_today($obj);

        // get today's sechedule
		
		  if ( $week ) {
            $this->_fetchAWeek($obj);
            //return $this->data;
        } else {
            //$data = $this->_libraryCalendar($obj);
            $this->_fetchAMonth($obj);
        }//efi

        return $this->data;
    }// fetch()

    public function fetchToday($loc) {
        error_log(__METHOD__);
        $param = (object) ['dept' => $loc];
        error_log(' - $param: ' . print_r($param, 1));
        $this->_today($param);
        error_log(' $data: ' . print_r($this->data, 1));
        return $this->data;
    }// fetchToday()

    public function fetchTodayHomeHours($loc) {
        error_log(__METHOD__);
        $param = (object) ['dept' => $loc];
        error_log(' - $param: ' . print_r($param, 1));
        $this->_todayHome($param);
        error_log(' $data: ' . print_r($this->data, 1));
        return $this->data;
    }// fetchToday()

    private function _libraryCalendar($obj) {
        error_log(__METHOD__);

        $rec = null;
        $db = app('db')->connection('lead_lumenAPI');

  //error_log(sprintf('dept=%s / %d-%d', $obj->dept, date('Y', $obj->time),  date('m', $obj->time)));

        if ( is_object($db) ) {
            error_log('querying data...');
            $year = (String) date('Y', $obj->time);
            $month = (String)  date('j', $obj->time);

            try {
                $rec = current($db->table(self::CAL_VIEW)
                       ->select(
                            'open_hour', 'close_hour',
                            'event' , 'event_type',
                            'cal_day_num', 'cal_month',
                            'cal_year'
                        )
                       ->selectRaw(
                            'CONVERT(VARCHAR(30), DATEFROMPARTS(
                                cal_year,
                                cal_month,
                                cal_day_num
                            )) AS dateStr'
                        )
                       ->where('cal_dept', $obj->dept)
                       ->where('cal_year',  date('Y', $obj->time))
                       ->where('cal_month', date('n', $obj->time)) // month w/o leading zero
                       ->get()
                   );
                $rec = array_combine(range(1, count($rec)), array_values($rec) );
                //error_log('type of: ' . getType( $rec ));
                //error_log('$rec: ' . print_r($rec,1));
            } catch ( QueryException $e ) {
                error_log('$e: ' . $e->getMessage());
            }// cath QueryException/ try

            error_log('RECORD COUNT: ' . count($rec));
			
			 //error_log(print_r(current($rec), 1));
        }//fi

        return $rec;
    }// _()


    private function _today($obj) {
        error_log(__METHOD__);

        if ( is_object($this->db) ) {
            $todayStr = 'DATEFROMPARTS(cal_year, cal_month, cal_day_num)='
                      .  sprintf("'%s'",  date('Y-m-d'));
            try {
                $rec = current($this->db->table(self::CAL_VIEW)
                       ->select('open_hour', 'close_hour', 'event', 'event_type')
                       ->selectRaw(
                            'CONVERT(VARCHAR(30), DATEFROMPARTS(
                                cal_year, cal_month, cal_day_num
                            )) AS dateStr'
                        )
                       ->where('cal_dept', $obj->dept)
                       ->whereRaw($todayStr)
                       ->get()
                   );
                error_log('today: '. print_r($rec,1));

                $this->data['today'] = array_pop($rec);
            } catch ( QueryException $e ) {
                error_log('$e: ' . $e->getMessage());
            }// cath QueryException/ try

        }//fi
    }// _today()

    private function _todayHome($obj) {
		 // service group
        $service = [
            'asl' => 'sl_gen, sl_ref',
            'gml' => 'gml_gen',
            'gsc' => 'lib_gateway',
            'll'  => 'll_gen, ll_ref',
            'mrc' => 'sl_mrc',
            'sca' => 'll_spec,lib_ocseaa',
        ];
        $todayStr = 'DATEFROMPARTS(cal_year, cal_month, cal_day_num)='
                  . sprintf("'%s'",  date('Y-m-d'));
        try {
            $rec = current(
                $this->db->table(self::CAL_VIEW)
                    ->selectRaw(
                        'open_hour AS openHours',
                        'close_hour AS closeHours',
                        'cal_dept AS dept'
                    )
                    ->whereRaw($todayStr)
                    ->where('cal_dept', 'IN', $service[$obj->dept])
                    ->get()

            );
        } catch ( QueryException $e ) {
            error_log('$e: ' . $e->getMessage());
       }// cath QueryException/ try

    }// _todayHome()

    private function _fetchAWeek($obj) {
        error_log(__METHOD__);
        // USE ISO week number to query
        // MSSQL:DATEPART(week, 'YYYY-mm-dd') =  php:date('W', time('YYYY-mm-dd')
        error_log(print_r($obj,1));
        $weekNo = 'DATEPART(week, DATEFROMPARTS(cal_year, cal_month, cal_day_num)) = '
		
		 . (int) $obj->week;

        $columns = ['open_hour', 'close_hour', 'event' , 'event_type',
                 'DATEFROMPARTS(cal_year, cal_month ,cal_day_num) AS dt'];
        try {
            $rec = current($this->db->table(self::CAL_VIEW)
                   //->selectRaw(implode(',', $columns))
                   ->select('open_hour', 'close_hour', 'event' , 'event_type')
                   ->selectRaw('CONVERT(VARCHAR(30), DATEFROMPARTS(cal_year, cal_month ,cal_day_num)) AS dateStr')
                   ->where('cal_dept', $obj->dept)
                   ->where('cal_year', '2019')
                   ->whereRaw($weekNo)
                   ->get()
                );

            //error_log('all: ' . print_r($rec, 1));
            //error_log('last: ' . print_r(array_pop($rec), 1));
            error_log('RECORD COUNT: ' . count($rec));

            $this->data['week'] = $rec;
        } catch ( QueryException $e ) {
            error_log('$e: ' . $e->getMessage());
        }// cath QueryException/ try

    }// _FetchAWeek

    private function _fetchAMonth($obj) {
        error_log(__METHOD__);

        error_log('querying data...');
        $year = (String) date('Y', $obj->time);
        $month = (String)  date('j', $obj->time);
        try {
            $rec = current($this->db->table(self::CAL_VIEW)
                   ->select('open_hour', 'close_hour', 'event' , 'event_type')
                   ->selectRaw('CONVERT(VARCHAR(30), DATEFROMPARTS(cal_year, cal_month, cal_day_num)) AS dateStr')
				    ->where('cal_dept', $obj->dept)
                   ->where('cal_year',  date('Y', $obj->time))
                   ->where('cal_month', date('n', $obj->time)) // month w/o leading zero
                   ->get()
               );
            $rec = array_combine(range(1, count($rec)), array_values($rec) );
            //error_log('type of: ' . getType( $rec ));
            //error_log('$rec: ' . print_r($rec,1));

            error_log('RECORD COUNT: ' . count($rec));

            $this->data['month'] = $rec;

        } catch ( QueryException $e ) {
            error_log('$e: ' . $e->getMessage());
        }// cath QueryException/ try

    }// _fetchAMonth()

//
	
} //class


				   