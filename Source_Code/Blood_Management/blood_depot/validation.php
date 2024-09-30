<?php		
		function email_validation($email){
				if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9?\.!=\-_&]*@[\w-]+(\.\w{2,3})+$/',$email)){
					return false;
			}
			else {
				return true;
			}
			}
		function phone_validation($tp_no){
				if (!preg_match('/^\d{3}-\d{7}$/',$tp_no)){
					return false;
			}
			else {
				return true;
			}
			}
		function date_validation($date){
				if (!preg_match('/^(\d{4})-\d{2}-\d{2}$/',$date)){
					return false;
			}
			else {
				return true;
			}
			}
		function NIC_validation($id_type,$id_num){
			//check whether id type is NIC or DL
				if ($id_type=="NIC"||$id_type=="DL" ){
				//If no of digit is 10
        if (strlen($id_num) == 10) {
				$id_num_upper=strtoupper($id_num);
					if (is_numeric(substr($id_num,0,9)) && ((substr($id_num_upper,9,1) == 'V') || (substr($id_num_upper,9,1) =='X')))
													{
				return true;
													}
			else {
				return false;
				 }
										}
					//If no of digit is 12
		else if (strlen($id_num) == 12) {
			if (is_numeric($id_num)){
				return true;
							}
			else {
				return false;
						}
					}
		else {
			return false;
			 }

				}
				//ID TYPE IS PP so no Validation Required
				else {
					return true;
						}
		}

	//echo NIC_validation("NIC","893150617V");
?>
