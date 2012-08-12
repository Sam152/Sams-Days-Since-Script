(function(){

	window.onload = function(){
		// Get the form.
		var form = document.getElementById('create');

		// When the form is submitted.
		form.onsubmit = function(){

			// If auth is enabled.
			if(auth_enabled){

				// Ask for a password.
				var password = prompt('Please enter the password');
				
				// And add it to the form.
				form.elements.namedItem('password').value = password;

			}
		}
	}

})();