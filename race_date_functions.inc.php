<?php
	function getRaceNum()
	{
		$userDate = new DateTime('now');
		
		//2019 Race starts
		$raceNum1 = new DateTime('2019-03-17');
		$raceNum2 = new DateTime('2019-03-31');
		$raceNum3 = new DateTime('2019-04-14');
		$raceNum4 = new DateTime('2019-04-28');
		$raceNum5 = new DateTime('2019-05-12');
		$raceNum6 = new DateTime('2019-05-26');
		$raceNum7 = new DateTime('2019-06-09');	
		$raceNum8 = new DateTime('2019-06-23');
		$raceNum9 = new DateTime('2019-06-30');
		$raceNum10 = new DateTime('2019-07-14');
		$raceNum11 = new DateTime('2019-07-28');
		$raceNum12 = new DateTime('2019-08-04');
		$raceNum13 = new DateTime('2019-09-01');
		$raceNum14 = new DateTime('2019-09-08');
		$raceNum15 = new DateTime('2019-09-22');
		$raceNum16 = new DateTime('2019-09-29');
		$raceNum17 = new DateTime('2019-10-13');		
		$raceNum18 = new DateTime('2019-10-27');
		$raceNum19 = new DateTime('2019-11-03');
		$raceNum20 = new DateTime('2019-11-17');
		$raceNum21 = new DateTime('2019-12-01');	
		
		
		
		
		if($userDate < $raceNum1){
			$raceNum = 1;
		}
		elseif($userDate >= $raceNum1 && $userDate < $raceNum2){
			$raceNum = 2;
		}
		elseif($userDate >= $raceNum2 && $userDate < $raceNum3){
			$raceNum = 3;
		}
		
		elseif($userDate >= $raceNum3 && $userDate < $raceNum4){
			$raceNum = 4;
		}
			elseif($userDate >= $raceNum4 && $userDate < $raceNum5){
			$raceNum = 5;
		}
			elseif($userDate >= $raceNum5 && $userDate < $raceNum6){
			$raceNum = 6;
		}
			elseif($userDate >= $raceNum6 && $userDate < $raceNum7){
			$raceNum = 7;
		}
			elseif($userDate >= $raceNum7 && $userDate < $raceNum8){
			$raceNum = 8;
		}
			elseif($userDate >= $raceNum8 && $userDate < $raceNum9){
			$raceNum = 9;
		}
			elseif($userDate >= $raceNum9 && $userDate < $raceNum10){
			$raceNum = 10;
		}
			elseif($userDate >= $raceNum10 && $userDate < $raceNum11){
			$raceNum = 11;
		}
			elseif($userDate >= $raceNum11 && $userDate < $raceNum12){
			$raceNum = 12;
		}
			elseif($userDate >= $raceNum12 && $userDate < $raceNum13){
			$raceNum = 13;
		}
			elseif($userDate >= $raceNum13 && $userDate < $raceNum14){
			$raceNum = 14;
		}
			elseif($userDate >= $raceNum14 && $userDate < $raceNum15){
			$raceNum = 15;
		}
			elseif($userDate >= $raceNum15 && $userDate < $raceNum16){
			$raceNum = 16;
		}
			elseif($userDate >= $raceNum16 && $userDate < $raceNum78){
			$raceNum = 17;
		}
			elseif($userDate >= $raceNum17 && $userDate < $raceNum18){
			$raceNum = 18;
		}
			elseif($userDate >= $raceNum18 && $userDate < $raceNum19){
			$raceNum = 19;
		}
			elseif($userDate >= $raceNum19 && $userDate < $raceNum20){
			$raceNum = 20;
		}
			elseif($userDate >= $raceNum20 && $userDate < $raceNum21){
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
				$cutOffDate->setDate(2019, 3, 15);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 2:
				$cutOffDate->setDate(2019, 3, 29);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 3:
				$cutOffDate->setDate(2019, 4, 12);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 4:
				$cutOffDate->setDate(2019, 4, 26);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 5:
				$cutOffDate->setDate(2019, 5, 10);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 6:
				$cutOffDate->setDate(2019, 5, 24);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 7:
				$cutOffDate->setDate(2019, 6, 07);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 8:
				$cutOffDate->setDate(2019, 6, 21);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 9:
				$cutOffDate->setDate(2019, 6, 28);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 10:
				$cutOffDate->setDate(2019, 7, 12);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 11:
				$cutOffDate->setDate(2019, 7, 26);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 12:
				$cutOffDate->setDate(2019, 8, 02);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 13:
				$cutOffDate->setDate(2019, 8, 30);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 14:
				$cutOffDate->setDate(2019, 9, 06);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 15:
				$cutOffDate->setDate(2019, 9, 20);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 16:
				$cutOffDate->setDate(2019, 9, 27);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 17:
				$cutOffDate->setDate(2019, 10, 11);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 18:
				$cutOffDate->setDate(2019, 10, 25);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 19:
				$cutOffDate->setDate(2019, 11, 01);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 20:
				$cutOffDate->setDate(2019, 11, 15);
				$cutOffDate->setTime(00, 00, 00);
			break;
			
			case 21:
				$cutOffDate->setDate(2019, 11, 29);
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