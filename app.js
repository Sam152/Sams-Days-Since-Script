(function(){

	window.onload = function(){

		// Get the form.
		var form = document.getElementById('create');

		// If the form is in the DOM
		if(form !== null){

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

		// Get the counter.
		var counter = document.getElementById('numbers');

		// If it's in the DOM.
		if(counter !== null){

			// A function to calculate the date and populate the DOM.
			function calculateDate(){
				
				// Get the timestamp of now.
				var now = Date.now() / 1000;

				// Get the time since.
				var timeSince = now - timestamp;

				// Split to components.
				var days = Math.floor(timeSince / 86400);
				var hours = Math.floor((timeSince % 86400) / 3600);
				var mins = Math.floor(((timeSince % 86400) % 3600) / 60);
				var seconds = Math.floor((timeSince % 86400) % 3600) % 60;

				// Build an HTML string.
				var text = '<span class="days">' + days + ' days</span> ';
				text += '<span class="hours">' + hours + ' hours</span> ';
				text += '<span class="mins">' + mins + ' mins</span> ';
				text += '<span class="seconds">' + seconds + ' seconds</span>';

				counter.innerHTML = text;

			}

			// Do it on load.
			calculateDate();

			// And every second.
			setInterval(calculateDate,1000);
		}

	}

})();