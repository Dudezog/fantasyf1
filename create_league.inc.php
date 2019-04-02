<center>
	<table border="0" cellpadding="5" cellspacing="15" bgcolor=#FFFFFF>
		<tr>
			<td align='center'>
				<h1>
					Create a New League
				</h1>
			</td>
		</tr>
		<tr>
			<td align='center'>
				<h3>
					Please enter the following information
				</h3>
			</td>
		</tr>		
		
		<form action="index" method="post" target="_self">
		
		<tr>
			<td>
				<b>
					League Name:
				</b>
			</td>
			<td>
				<input type="text" name="leagueName">
			</td>
		</tr>
		<tr>
			<td>
				<b>
					Number of Players:
				</b>
			</td>
			<td>
				<select name ="players" id="players" required>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<b>
					League Notes:
				</b>
			</td>
			<td>
				<textarea rows="4" cols="35" name="note"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2" align='center'>
				<input type="hidden" name="content" value="add_league">
				<input type="submit" value="Submit">
			</td>
		</tr>
	</table>
	
	</form>