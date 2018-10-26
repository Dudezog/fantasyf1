<center>
	<table border="0" cellpadding="5" cellspacing="15" bgcolor=#FFFFFF>
		<tr>
			<td align='center'>
				<h1>
					Register!
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
		
		<form action="adduser.php" method="post" target="_self">
		
		<tr>
			<td>
				<b>
					User Name:
				</b>
			</td>
			<td>
				<input type="text" name="userid">
			</td>
		</tr>
		<tr>
			<td>
				<b>
					Password:
				</b>
			</td>
			<td>
				<input type="password" name="password">
			</td>
		</tr>
		<tr>
			<td>
				<b>
					Confirm Password:
				</b>
			</td>
			<td>
				<input type="password" name="password2">
			</td>
		</tr>
		<tr>
			<td>
				<b>
					E-mail:
				</b>
			</td>
			<td>
				<input type="email" name="email">
			</td>
		</tr>
		<tr>
			<td colspan="2" align='center'>
				<input type="submit" value="Submit">
			</td>
		</tr>
	</table>
	
	</form>
		
		<p>
			<a href="index.php?content=login">Log-In</a>
		</p>	
</center>