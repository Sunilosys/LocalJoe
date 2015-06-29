jQuery.validator.addMethod("phone", function(phone_number, element) {
	var valchanged = false;
	if(phone_number == phoneformat){
		phone_number = '';
		element.value = '';
		valchanged = true;
	}
    phone_number = phone_number.replace(/\s+/g, ""); 
	var x = this.optional(element) || phone_number.length > 7 &&
		phone_number.match(/^(\+65)?\s?[689]\d{7}$/i);
	if(valchanged){
		element.value = phoneformat;
	}
	return x;
}, "Please specify a valid phone number");
