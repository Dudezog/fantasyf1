Assuming you have WampServer,  copy this folder to:  C:\wamp\www

To get scores, use 'index.php'

You must pass the race you want as 'id':

IE-  "http://localhost/f1/index.php?id=0"  - would give you Australia Results

'0 - Australia',
'1 - Bahrain',
'2 - China',
'3 - Azerbaijan',
'4 - Spain',
'5 - Monaco',
'6 - Canada',
'7 - France',
'8 - Austria',
'9 - Great Britain',
'10 - Germany',
'11 - Hungary',
'12 - Belgium',
'13 - Italy',
'14 - Singapore',
'15 - Russia',
'16 - Japan',
'17 - United States',
'18 - Mexico',
'19 - Brazil',
'20 - Abu Dhabi'


To use each individual page: pass race as 'id'

Note: fastest_lap.php does not require parameters


//Calculate points Page
Use this page to pick 2, 3 or 4 drivers and calculate their total points for a race.

Parameters: pass race id (0-20) as 'id'.  Pass up to 4 drivers as 'driver1', 'driver2', 'driver3', 'driver4'

Example:  These URLs would give us each team's scores for Japan GP.

Dudezog:  http://localhost/f1/calculate_points.php?id=16&driver1=HAM&driver2=GAS
Kalb:  http://localhost/f1/calculate_points.php?id=16&driver1=BOT&driver2=OCO
Aston Markin : http://localhost/f1/calculate_points.php?id=16&driver1=VER&driver2=MAG&driver3=STR
Jason: http://localhost/f1/calculate_points.php?id=16&driver1=VET&driver2=ERI
