$(document).ready(function() {

        $("#newProductSubmit").val("Fill the items above!");


	$(document).on("keyup", "#formName, #formDescription, #formFile #formPrice", function() {
		//Make sure the "Enter" button is disabled

        var name = $("#formName").val();
	var description = $("#formDescription").val();
	var price = $("#formPrice").val();
        var file = $("#formFile").val();
        var category = $("#formCategory").val();
 
        

        name = String(name);
        bool1 = (name != '');
        description = String(description);
        bool2 = (description != '');
        price = String(price);
        bool3 = (price != '');
        bool4 = (category.length>0);
        bool5 = (file.length>0);
        
        

        
        if (bool1 && bool2) {
        	$("#newProductSubmit").attr("disabled", false);
		$("#newProductSubmit").val("Upload Product");
        } else  {
        	
		$("#newProductSubmit").val("Fill the items above!");
        } 

	});



});