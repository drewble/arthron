			// browser check - will error out if not IE 5 or newer
			
			//Create a variable that will hold an instance of the navigator object
			var nav = navigator;
			
			//Create a variable that will store the name of the browser
			var appN = nav.appName;
			
			//Create a variable that will store the browser version
			//Use the parseFloat function to ensure a number is returned, var x = parseFloat(value)
			var vers = parseFloat(nav.appVersion);       
			
			//Check if the name of the browser equals "Microsoft internet Explorer", replace appN with your variable
			if(appN=="Microsoft Internet Explorer"){
			//Set your variable to "ie"
				var browser = "ie";
		
			//Create a variable that will store the browser's user agent property
				var ua = nav.userAgent;
			//Check to see whether or not the user agent contains the string value "MSIE 5", if so set your version variable to 5, replace ua and vers with your variables
				if(ua.indexOf("MSIE 5")>0){
				  vers=5;
				}
				//Check to see whether or not the user agent contains the string value "MSIE 6", if so set your version variable to 6, replace ua and vers with your variables
				 else if(ua.indexOf("MSIE 6")>0){
				   vers=6;
				 }
			}
			//Check to see if the name of the browser equals "Netscape", replace appN with your variable
				else if(appN=="Netscape"){
			  //Set your variable to "nn"
						var browser = "nn";
				}
		   //If the browser's name is not "Microsoft Internet Explorer" or "Netscape", store the name in your variable
			else{
				var browser = appN;
			}
		
			//Check if the browser is not IE 5 or newer        
			if((browser !="ie")||(browser=="ie" && vers<5)){
			//If not IE 5 or newer, give error message
				alert("These features require Internet Explorer 5.0 or higher");
				window.close();
			}
