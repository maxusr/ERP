<?php
namespace CoreBundle\Utils;

class Utils
{
	public static function formatDateValid($date)
	{
		if(preg_match("#[0-9]{1,2}/[0-9]{1,2}/[0-9]{1,4}#", $date))
		{
			$array = explode("/", $date);

			if(strlen($array[2]) < 4)
				return false;
			if($array[1] < 1 || $array[1] > 12)
				return false;
			if($array[0] > self::nbreJourDuMois((int)$array[2],(int)$array[1]))
				return false;

			return true;
		}else{
			return false;
		}
	}

	public static function joursFerier($annee)
	{
		return ($annee%4 != 0 || ($annee % 100 == 0 && $annee % 400 != 0) ? 28 : 29);
	}

	public static function nbreJourDuMois($annee, $mois)
	{
	    $joursparmois = array(0,31,self::joursFerier($annee),31,30,31,30,31,31,30,31,30,31);
	    return $joursparmois[$mois];
	}

	public static function dateFormat(\DateTime $date, $format = "medium"){

		// Mois
		$medMonths = array("Jan.","Fev.","Mars","Avr.","Mai","Juin","Juil.","Août","Sept.","Oct.","Nov.","Dec.");
		$longMonths = array("Janvier","Février","Mars","Avril.","Mai","Juin","Juillet.","Août","Septembre","Octobre","Novembre","Décembre.");
		
		// Jour
		$longDays = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche");
		$medDays = array("Lun.","Mar.","Mer.","Jeu.","Ven.","Sam.","Dim.");

		$d = $date->format('d');
		$j = $date->format('j');
		$s = $date->format('N');
		$m = $date->format('m');
		$y = $date->format('Y');

		switch ($format) {
			case 'long':
				$day = $longDays[$s-1]." ";
				$month = $longMonths[$m-1];
				break;
			case 'short':
				$day = "";
				$month = " ".$medMonths[$m-1]." ";
				break;
			
			default:
				$day = $medDays[$s-1]." ";
				$month = " ".$medMonths[$m-1]." ";
				break;
		}

		return $day.$d.$month.$y;
	}

	public static function dateTimeFormat(\DateTime $date) {
		return self::dateFormat($date)." à ".$date->format('H\hi\m\i\ns\s');
	}
}