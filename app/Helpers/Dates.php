<?php
namespace App\Helpers;

use Carbon\Carbon;
use DateTime;

class Dates{
    public static function getNameDay($date) {
        $days = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo',);
        return $days[date('N', strtotime($date)) - 1];
    }

    public static function diff($today,$created_at){
        $today = explode(' ',$today)[0];
        $created_at = explode(' ',$created_at)[0];

        $diff = abs(strtotime($today) - strtotime($created_at));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        return $days;
    }

    public static function canRegister(){
        $today = self::getNameDay(session('day'));
        return ($today == 'Lunes' || $today == 'Jueves' || $today == 'Martes' || $today == 'Viernes') ;
    }

    public static function mustPay(){
        $today = self::getNameDay(session('day'));
        return ($today == 'Lunes' || $today == 'Jueves' || $today == 'Martes' || $today == 'Viernes') ;
    }

    public static function today(){
        return self::getNameDay(session('day'));
    }


    public static function between($start,$end,$date){
        $date = new DateTime($date);
        $start = new DateTime($start);
        $end = new DateTime($end);

        return ($start <= $date) && ($date <= $end);
    }


    public static function transform($date){
        $date = new Carbon($date);
        return $date->isoFormat('dddd\, D \d\e MMMM \d\e\l G');
    }

    public static function atTime($date,$time,$now){
        return strtotime($now) <= strtotime($date.' '.$time);
    }
}
