<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>layout test page</title>
    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <!-- jQuery UI -->
    <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <!-- BootStrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script>
      $(document).ready(function(){
      	//store the data and transfer to the back-end
      	$('.button').click(function(){
          var row_data = new Array();
          var content = $('#row-value').html();
          var temp = content.split('<br>');
      	  for(var i = 0; i < temp.length-1; i++){
      	  	row_data.push(temp[i]);
      	  }
      	  alert(row_data);
      	});
      });
      $(function(){
      	$(".draggable").draggable(
      		{containment:"#right-side",
      		 revert: true, 
      		 helper: "clone"
      		});
      });

      function checkAll(){
      	var row_data = new Array();
      	$('input[name="checkbox"]:checked').each(function(){
		  row_data.push($(this).val()+"<br>");
		});
		$('#row-value').html(row_data);
      }
    </script>
    <style>
      ul{list-style-type:none; margin:0; padding:0;}
      li{cursor:move;}
	  #right-side{border:1px solid #ccc; height:40%;}
	  #filter-value{border:1px solid #ccc; height:25%;}
	  #row-value{border:1px solid #ccc; height:100%;}
	  #row-value p{font-size:22;}
	  #column-value{border:1px solid #ccc; height:100%;}
	  #output-value{border:1px solid #ccc;}
    </style>
  </head>
  <body>
  	<div class="row">
      <div class="col-md-8" id="left-side">
      	<h1>left side</h1>
      </div>
      <div class="col-md-4" id="right-side">
      	<h1>right side</h1>
      	<h3>Field</h3>
      	<div class="row">
      	  <!-- dimension field -->
      	  <div class="col-md-5" id="dimension-field">
      	  	<p>This is dimension field</p>
      	  	<ul>
      	  	  <li class="draggable"> 
      	  	    <input type="checkbox" id="inlinecheckbox" name="checkbox" value="TransDate" onclick="checkAll()">TransDate</inupt>
      	  	  </li><br>
      	  	  <li class="draggable"> 
      	  	    <input type="checkbox" id="inlinecheckbox" name="checkbox" value="TransSource" onclick="checkAll()">TransSource</inupt>
      	  	  </li><br>
      	  	  <li class="draggable"> 
      	  	    <input type="checkbox" id="inlinecheckbox" name="checkbox" value="TransType" onclick="checkAll()">TransType</inupt>
      	  	  </li><br>
      	  	  <li class="draggable"> 
      	  	    <input type="checkbox" id="inlinecheckbox" name="checkbox" value="Store" onclick="checkAll()">Store</inupt>
      	  	  </li><br> 
      	  	   <li class="draggable"> 
      	  	    <input type="checkbox" id="inlinecheckbox" name="checkbox" value="Amount" onclick="checkAll()">Amount</inupt>
      	  	  </li><br>
      	  	   <li class="draggable"> 
      	  	    <input type="checkbox" id="inlinecheckbox" name="checkbox" value="CustomerNmae" onclick="checkAll()">CustomerName</inupt>
      	  	  </li><br>
      	  	</ul>
      	  </div>
      	  <!-- non-dimension field -->
      	  <div class="col-md-6" id="non-dimension-field">
      	  	<p>This is non-dimension-field</p>
      	  	<div id="filter-value">
      	  	  <p>This is filter-value area!</p>
      	  	</div>
      	  	<div id="row-value">
      	  	  <p>This is row-value area!</p>
      	  	</div>
      	  	<div id="column-value">
      	  	  <p>This is column-value area!</p>
      	  	</div>
      	  	<div id="output-value">
      	  	  <p>This is output-value area!</p>
      	  	</div>
      	  </div>  
      </div>
      <input type="button" class="button" value="submit">
    </div>
  </body>
</html>