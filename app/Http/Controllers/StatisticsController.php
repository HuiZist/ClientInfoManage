<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Contract;
use Carbon\Carbon;
use App\Statdef;
use App\ClientTitle;
use App\Client;
use App\StatTitle;
use App\Ord;

class StatisticsController extends Controller
{
    protected $cliStr = [
        'A','B','C','D','E','F','G',
        'H','I','J','K','L','M','N',
        'O','P','Q','R','S','T',
        'U','V','W','X','Y','Z',
        'AA','AB','AC','AD','AE','AF','AG',
        'AH','AI','AJ',
    ];

    public function show(){
        $statdef = Statdef::find(1);
        if (Auth::user()->can('isAdmin')) {
            $datas = $this->getData($statdef);
        }else{
            $datas = $this->getUserData($statdef);
        }
        $statTitle = StatTitle::find(1);
        
    	return view('statistics.show',compact('datas','statTitle'));
    }

    public function getData($statdef){
        $datas = Contract::distinct('operator_account')
            ->where('operator_account','!=','notInClient')
            ->where('operator_account','!=','noAccount')
            ->whereNotNull('operator_account')
            ->select('operator_account','operator_name')
            ->get()->toArray();
        foreach ($datas as $key => $value) {
            $cliArr = Contract::where('operator_account',$value['operator_account'])->distinct('B')->select('B')->get()->toArray();
           
            $datas[$key]['stat'] = ['sDig'=>0,'aDig'=>0,'bDig'=>0,'cDig'=>0];
            foreach ($cliArr as $ckey => $cval) {
                $clirec = Contract::where('operator_account',$value['operator_account'])->where('B',$cval['B'])->select('C')->get()->toArray();
              
                $count = sizeof($clirec);
                $tcount = 0;
                foreach ($clirec as $k => $v) {
                    if($v['C']>=$statdef->btime && $v['C']<=$statdef->etime){
                        $tcount++;
                    }
                }
                if($count>=$statdef->scount && $tcount>=$statdef->stcount){
                    $datas[$key]['stat']['sDig']++;
                }elseif($count>=$statdef->acount && $tcount>=$statdef->atcount){
                    $datas[$key]['stat']['aDig']++;
                }elseif($count>=$statdef->bcount && $tcount>=$statdef->btcount){
                    $datas[$key]['stat']['bDig']++;
                }elseif($count>=$statdef->ccount && $tcount>=$statdef->ctcount){
                    $datas[$key]['stat']['cDig']++;
                }
            }
        }
        return $datas;
    }

    public function getUserData($statdef){
        $datas[0] = [
        'operator_account'=>Auth::user()->account,
        'operator_name'=>Auth::user()->name,
        ];
        foreach ($datas as $key => $value) {
            $cliArr = Auth::user()->contracts()->distinct('B')->select('B')->get()->toArray();
           
            $datas[$key]['stat'] = ['sDig'=>0,'aDig'=>0,'bDig'=>0,'cDig'=>0];
            foreach ($cliArr as $ckey => $cval) {
                $clirec = Auth::user()->contracts()->where('B',$cval['B'])->select('C')->get()->toArray();
              
                $count = sizeof($clirec);
                $tcount = 0;
                foreach ($clirec as $k => $v) {
                    if($v['C']>=$statdef->btime && $v['C']<=$statdef->etime){
                        $tcount++;
                    }
                }
                if($count>=$statdef->scount && $tcount>=$statdef->stcount){
                    $datas[$key]['stat']['sDig']++;
                }elseif($count>=$statdef->acount && $tcount>=$statdef->atcount){
                    $datas[$key]['stat']['aDig']++;
                }elseif($count>=$statdef->bcount && $tcount>=$statdef->btcount){
                    $datas[$key]['stat']['bDig']++;
                }elseif($count>=$statdef->ccount && $tcount>=$statdef->ctcount){
                    $datas[$key]['stat']['cDig']++;
                }
            }
        }
        return $datas;
    }

    public function link($userId,$stat){
        $contracts = $this->getCon();
        
        $contracts = $contracts->where('operator_account',$userId);
        
        $cliArr = $this->getCliArr($contracts,$stat);

        $strArr = [];
        $clientTitles = ClientTitle::find(1);
        foreach ($this->cliStr as $value) {
            if(!!$clientTitles->$value){
                array_push($strArr,$value);
            }
        }

        $clients = Client::whereIn('D',$cliArr)->orWhereIn('E',$cliArr);

        $order = Ord::find(1);
        $str = $order->conStr?$order->cliStr:'updated_at';
        $ord = $order->conOrd?$order->cliOrd:'desc';

        if($str == 'B' || $str == 'C'){
            $clients = $clients->orderByRaw("convert($str using gbk) $ord")->paginate(40);
        }else{
            $clients = $clients->orderBy($str,$ord)->paginate(40);
        }
        $order = ['str'=>$str,'ord'=>$ord];

        return view('client.client',compact('clientTitles','clients','strArr','order'));
    }

    public function getCon(){
        if (Auth::user()->can('isAdmin')){
            $contracts = new Contract();
        }else{
            $contracts = Auth::user()->contracts();
        }
        return $contracts;
    }

    public function getCliArr($contracts,$stat){
        $statdef = Statdef::find(1);
        $statC = $stat.'count';
        $statT = $stat.'tcount';
        $con = clone $contracts;
        $contracts = $contracts
            ->selectRaw('B,count(id) as count')
            ->groupBy('B')
            ->having('count','>=',$statdef->$statC)
            ->get()->toArray();
        $conArra = [];
        foreach ($contracts as $ak => $av) {
            array_push($conArra,$av['B']);
        }

        $con = $con
            ->where('C','>=',$statdef->btime)
            ->where('C','<=',$statdef->etime)
            ->selectRaw('B,count(id) as count')
            ->groupBy('B')
            ->having('count','>=',$statdef->$statT)
            ->get()->toArray();
        $conArrb = [];
        foreach ($con as $bk => $bv) {
            array_push($conArrb,$bv['B']);
        }

        return $cliArr = array_intersect($conArra,$conArrb);
    }
}
