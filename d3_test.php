<html>
<head>
	<title>D3 test</title>
</head>
<body>
  	<p>Hello World 1</p>
    <p>Hello World 2</p>
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script> 
    <script>  
        //d3.select("body").selectAll("p").text("www.ourd3js.com");    
        var p = d3.select("body")
        		  .selectAll("p")
        		  .text("hello world!");
        p.style("color", "red")
         .style("font-size","72px");  
    </script> 
</body> 
</html>