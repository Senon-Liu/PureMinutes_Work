<!DOCTYPE html>
<html lang="zh-CN">
<head>





	<title>test</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js">
	</script>
	<script type"text/javacript">
		$(document).ready(function(){
		function connect(){
			$.ajax({
				type:"post",
				url: "mssql_test.php",
				dataType: "json",
				data:{input_1:"TransType", input_2: "TransDate"},
				success: function(data){
					alert("success");
					//alert(data.length);
					
					
					/*
					for(var i = 0; i < data.length; i++){
						alert(data[i]);
					}*/
				},
				error: function(){
					alert("error");
				}
			});
		}

		$('#button').click(function(){
			$.getJSON("mssql_test.php", function(data){
				//alert("enter");
				var val = "";
			$.each(data,function(i,n){
				//val += n;
				val += n["id"]+"---"+n["TransType"]+"---"+n["TransDate"]+"<br>";
			});
			
			$('#result').append(val);
					});

		});

		
		$('#submit').click(function(){
			var check_data = new Array();
			$('input[name="checkbox"]:checked').each(function(){
				check_data.push($(this).val());
			})
			//alert(check_data);
			var jsonString = JSON.stringify(check_data);
			//alert(jsonString);
			$.ajax({
				type: "post",
				url: "check_test.php",
				dataType: "json",
				data: {data:jsonString},
				success: function(data){
					//alert("get_json_success");
					var val = "";
					$.each(data,function(i,n){
					//val += n;
					//val += n["TransDate"]+"---"+n["TransSource"]+"<br>";

					 for(var k = 0; k < check_data.length; k++){
					 	var temp = check_data[k];
					 	val += n[temp]+" ";
					 }

					 val += "<br>";


					});
			
					$('#check_get').html(val);
				
					
				},
				error: function(){
					alert("error");
				}


			});
		});

		//connect();
	});
	</script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>

	    



      <div class="row">
        <div class="col-md-8">
          <!--边栏内容-->
          <h1> Test !!! </h1>
          	<div class = "row">
          		<div class = "col-md-1">
					<input type = "button" id = "button" value = "get"/>
				</div>
				<div class = "col-md-1">
					<input type = "button" id = "reverse" value = "reverse" />
				</div>
			</div>
			<div id="result"></div>
        </div>
        <div class="col-md-4">
          <!--主体内容-->
          <h2>test</h2>
          <input type="button" id="submit" value="submit">
			<div class="row">
          		<div class="col-md-6">     
  					<input type="checkbox" name="checkbox" id="inlineCheckbox1" value="TransDate"> TransDate <br>
  					<input type="checkbox" name="checkbox" id="inlineCheckbox2" value="TransType"> TransType <br>
  					<input type="checkbox" name="checkbox" id="inlineCheckbox3" value="TransSource"> TransSource
				</div>
				<div class="col-md-6">
  					<input type="checkbox" name="checkbox" id="inlineCheckbox4" value="Store"> Store <br>
  					<input type="checkbox" name="checkbox" id="inlineCheckbox5" value="Amount"> Amount<br>
  					<input type="checkbox" name="checkbox" id="inlineCheckbox6" value="CustomerName"> CustomerName
  				</div>

        </div>
        <div id="check_get">
        <p>test
       	</div> 	
      </div>
  </div>










		

</body>
</html>
