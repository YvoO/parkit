<form method="post">
	<div class="form-group">
		<div class="col-md-2">
			<select id="type" class="form-control" name='type'><?php if($_SESSION['type']== 'Admin') { ?>
				<option value="Beheerder">Beheerder</option><?php } ?>
				<option value="Gebruiker">Gebruiker</option>
				<option value="Toezichthouder">Toezichthouder</option>
			</select>
		</div>
		<div class="col-md-2">
			<input type='text' class='form-control' name='name' value="<?php echo st_row['name'] ?>"/>
		</div>
		<div class="col-md-2">
			<input type='text' class='form-control' name='email' placeholder="e-mail"/>
		</div>
		<div class="col-md-2">
			<input type='text' class='form-control' name='password' placeholder="Wachtwoord"/>
		</div>
		<div class="col-md-2">
			<input type='text' class='form-control' name='spots' placeholder="Plekken" id="spots"/>
		</div>
	</div>
	<div class="form-group">
		<input type='submit' value='Voeg toe' class='btn btn-primary'/>
	</div>
	<script>
		var type = document.getElementById("type");
 				
		if (type.selectedIndex == 2) {
			document.getElementById('spots').disabled = true;
		};
	</script> 
</form>