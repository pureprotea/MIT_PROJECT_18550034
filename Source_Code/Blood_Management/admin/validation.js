	function validateNIC(inputField, helpText) {
		
			//alert(inputField.value.length);
			//alert(isNaN(inputField.value.substring(0, 9)));
		
        // See if the input value contains 10 or 12 chars
        if ((inputField.value.length != 10) && (inputField.value.length != 12)) {
          // Validation Failed, Help Message in span tag
          if (helpText != null){
            helpText.innerHTML = "NIC should Contain 10 or 12 chars.";}
          return false;
        }		
			//alert(inputField.value.length);
			//alert(isNaN(inputField.value));
			
		if (inputField.value.length ==12) {
          // Validation Failed, Help Message in span tag
		  if (isNaN(inputField.value)){
			if (helpText != null){
            helpText.innerHTML = "12 Digits NIC should only contain Numbers";}
          return false;
		  }
        }
			//alert(inputField.value.length);
			//alert(inputField.value.substring(0, 9));
			//alert(inputField.value.substring(9, 10));
			
		if (inputField.value.length ==10) {
          // Validation Failed, Help Message in span tag
		  if (isNaN(inputField.value.substring(0, 9))){
			if (helpText != null){
            helpText.innerHTML = "First 9 Digits should only contain Numbers";}
          return false;
		  }
        }
			//alert(inputField.value.length);
			//alert(inputField.value.substring(9, 10));
			
		if (inputField.value.length ==10) {
          // Validation Failed, Help Message in span tag
		  if ((inputField.value.substring(9, 10) != 'V') && (inputField.value.substring(9, 10) != 'X')){
			if (helpText != null){
            helpText.innerHTML = "Last Digit of NIC should be V or X";}
          return false;
				}
			//alert(inputField.value.length);
			//alert(inputField.value.substring(9, 10));
			else {
          // Validation Passed. So clear the help msg in span tag
			if (helpText != null)
            helpText.innerHTML = "";
			return true;
			}
		}
		else {
          // Validation Passed. So clear the help msg in span tag
			if (helpText != null)
            helpText.innerHTML = "";
			return true;
			}
		}

	
	
	 function validateNonEmpty(inputField, helpText) {
        // See if the input value contains any text
        if (inputField.value.length == 0) {
          // Validation Failed, Help Message in span tag
          if (helpText != null)
            helpText.innerHTML = "Please enter a value.";
          return false;
        }
        else {
          // Validation Passed. So clear the help msg in span tag
          if (helpText != null)
            helpText.innerHTML = "";
          return true;
        }
      }
	  
	  
	  function validateNumber(inputField, helpText) {
        // See if the input value contains any text
		if (!validateNonEmpty(inputField, helpText))
			return false;
        if (isNaN(inputField.value)){
          // Validation Failed, Help Message in span tag
          if (helpText != null)
            helpText.innerHTML = "Please enter a Number.";
          return false;
        }
		 else {
          // Validation Passed. So clear the help msg in span tag
          if (helpText != null)
            helpText.innerHTML = "";
          return true;
        }
      }
	  
	  
	  function validateAmount(inputField, helpText) {
        // See if the input value contains any text
		if (!validateNonEmpty(inputField, helpText))
			return false;
        if (isNaN(inputField.value)){
          // Validation Failed, Help Message in span tag
          if (helpText != null)
            helpText.innerHTML = "Please enter a Amount.";
          return false;
        }
		 else {
          // Validation Passed. So clear the help msg in span tag
          if (helpText != null)
            helpText.innerHTML = "";
          return true;
        }
      }
	  
	  
      function validateRegEx(regex, input, helpText, helpMessage) {
        // See if the input data validates OK
        if (!regex.test(input)) {
          // Validation Failed, Help Message in span tag and return false
          if (helpText != null)
            helpText.innerHTML = helpMessage;
          return false;
        }
        else {
          // Validation Passed. So clear the help msg in span tag and return true
          if (helpText != null)
            helpText.innerHTML = "";
          return true;
        }
      }
	  	  
      function validateDate(inputField, helpText) {
        // First see if the input value contains data
        if (!validateNonEmpty(inputField, helpText))
          return false;

        // Then see if the input value is a date
        return validateRegEx(/^\d{4}\-\d{2}\-\d{2}$/,
          inputField.value, helpText,
          "Invalid Date Format Eg:-(1989-10-11).");
      }

      function validatePhone(inputField, helpText) {
        // First see if the input value contains data
        if (!validateNonEmpty(inputField, helpText))
          return false;

        // Then see if the input value is a phone number
        return validateRegEx(/^\d{3}-\d{7}$/,
          inputField.value, helpText,
          "Invalid Phone No Format Eg:-(077-8050055).");
      }

      function validateEmail(inputField, helpText) {
        // First see if the input value contains data
        if (!validateNonEmpty(inputField, helpText))
          return false;

        // Then see if the input value is an email address
        return validateRegEx(/^[a-zA-Z0-9][a-zA-Z0-9?\.!=\-_&]*@[\w-]+(\.\w{2,3})+$/,
          inputField.value, helpText,
          "Invalid Email Format Eg:-(library@gmail.com).");
      }