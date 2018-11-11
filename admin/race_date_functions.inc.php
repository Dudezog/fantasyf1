<?php
	function getRaceNum()
	{
		$userDate = new DateTime('now');
		
		//Start days of each week
		//Wednesday before race starts week
		$raceNum1 = new DateTime('2018-01-01');
		$raceNum2 = new DateTime('2018-01-02');
		$raceNum3 = new DateTime('2018-01-03');
		$raceNum4 = new DateTime('2018-01-04');
		$raceNum5 = new DateTime('2018-01-05');
		$raceNum6 = new DateTime('2018-01-06');
		$raceNum7 = new DateTime('2018-01-07');	
		$raceNum8 = new DateTime('2018-01-08');
		$raceNum9 = new DateTime('2018-01-09');
		$raceNum10 = new DateTime('2018-01-10');
		$raceNum11 = new DateTime('2018-01-11');
		$raceNum12 = new DateTime('2018-01-12');
		$raceNum13 = new DateTime('2018-01-13');
		$raceNum14 = new DateTime('2018-01-14');
		$raceNum15 = new DateTime('2018-01-15');
		$raceNum16 = new DateTime('2018-01-16');
		$raceNum17 = new DateTime('2018-01-17');
		
		$raceNum18 = new DateTime('2018-10-17');
		$raceNum19 = new DateTime('2018-10-24');
		$raceNum20 = new DateTime('2018-11-07');
		$raceNum21 = new DateTime('2019-11-21');	
		
		if($userDate < $raceNum1){
			$raceNum = 1;
		}
		elseif($userDate >= $raceNum2 && $userDate < $raceNum3){
			$raceNum = 2;
		}
		elseif($userDate >= $raceNum3 && $userDate < $raceNum4){
			$raceNum = 3;
		}
		
		elseif($userDate >= $raceNum4 && $userDate < $raceNum5){
			$raceNum = 4;
		}
			elseif($userDate >= $raceNum5 && $userDate < $raceNum6){
			$raceNum = 5;
		}
			elseif($userDate >= $raceNum6 && $userDate < $raceNum7){
			$raceNum = 6;
		}
			elseif($userDate >= $raceNum7 && $userDate < $raceNum8){
			$raceNum = 7;
		}
			elseif($userDate >= $raceNum8 && $userDate < $raceNum9){
			$raceNum = 8;
		}
			elseif($userDate >= $raceNum9 && $userDate < $raceNum10){
			$raceNum = 9;
		}
			elseif($userDate >= $raceNum10 && $userDate < $raceNum11){
			$raceNum = 10;
		}
			elseif($userDate >= $raceNum11 && $userDate < $raceNum12){
			$raceNum = 11;
		}
			elseif($userDate >= $raceNum12 && $userDate < $raceNum13){
			$raceNum = 12;
		}
			elseif($userDate >= $raceNum13 && $userDate < $raceNum14){
			$raceNum = 13;
		}
			elseif($userDate >= $raceNum14 && $userDate < $raceNum15){
			$raceNum = 14;
		}
			elseif($userDate >= $raceNum15 && $userDate < $raceNum16){
			$raceNum = 15;
		}
			elseif($userDate >= $raceNum16 && $userDate < $raceNum17){
			$raceNum = 16;
		}
			elseif($userDate >= $raceNum17 && $userDate < $raceNum18){
			$raceNum = 17;
		}
			elseif($userDate >= $raceNum18 && $userDate < $raceNum19){
			$raceNum = 18;
		}
			elseif($userDate >= $raceNum19 && $userDate < $raceNum20){
			$raceNum = 19;
		}
			elseif($userDate >= $raceNum20 && $userDate < $raceNum21){
			$raceNum = 20;
		}
			elseif($userDate >= $raceNum21 && $userDate < $raceNum22){
			$raceNum = 21;
		}
			elseif($userDate >= $raceNum21){
			$raceNum = 21;
		}
		
		//Zero index in SQL table for tracks table
		//Offset this
		$raceNum--;
		
		return $raceNum;
	}
	
	function isValidPick($raceNum)
	{
		//Adjust RaceNum Offset
		$raceNum++;
		
		date_default_timezone_set("America/Chicago");
		$isValidPick = false;
		$cutOffDate = new DateTime();
		$now = new DateTime('now');
		
		switch($raceNum)
		{
			case 1:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 2:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 3:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 4:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 5:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 6:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 7:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 8:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 9:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 10:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 11:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 12:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 13:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 14:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 15:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 16:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 17:
				$cutOffDate = new DateTime('01-01-2018 00:00:00');
			break;
			
			case 18:
				$cutOffDate->setDate(2018, 10, 19);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 19:
				$cutOffDate->setDate(2018, 10, 26);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 20:
				$cutOffDate->setDate(2018, 11, 09);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 21:
				$cutOffDate->setDate(2018, 11, 23);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
		}
		
		if($now->format("y-m-d H:i:s") < $cutOffDate->format("y-m-d H:i:s"))
		{
			$isValidPick = true;
		}

		
		return $isValidPick;
	}

?>