<!DOCTYPE html>
<html lang="zh-CN">
<head>

	<title>test</title>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
  
<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>



	<script type"text/javacript">
		$(document).ready(function(){
			$('#example').DataTable({
				 "columns": [
            { "data": "name" },
            { "data": "position" },
            { "data": "office" },
            { "data": "age" },
            { "data": "start_date" },
            { "data": "salary" },
            { "data": "TransDate"}
        ]
			});

		
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
			alert(check_data);
			//generate table's head
			var jsonString = JSON.stringify(check_data);
			//alert(jsonString);
			$.ajax({
				type: "post",
				url: "check_test.php",
				dataType: "json",
				data: {data:jsonString},
				success: function(data){
					//alert(data.length);
					var val = "";
					$.each(data,function(i,n){
					//val += n;
					//val += n["TransDate"]+"---"+n["TransSource"]+"<br>";
					val += n["id"]+"---";
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
			<div id="result">
				<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
                <th>TransDate</th>

            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
                <th>TransDate</th>
            </tr>
        </tfoot>
 
        <tbody>

        </tbody>
    </table>

			</div>
        </div>
        <div class="col-md-4">
          <!--主体内容-->
          <h2>test</h2>
          <input type="button" id="submit" value="submit">
			<div class="row">
				<script>
					 $(function() {
    					$( "#draggable" ).draggable();
  					});
				</script>
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
