<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>jquery PivotTable Example</title>

        <link href="css/PivotTable.css" rel="stylesheet" type="text/css" />

        <script src="scripts/jquery-1.6.4.min.js" type="text/javascript"></script>
        <script src="scripts/jquery.ui.core.js" type="text/javascript"></script>
        <script src="scripts/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="scripts/jquery.ui.mouse.js" type="text/javascript"></script>
        <script src="scripts/jquery.ui.draggable.js" type="text/javascript"></script>
        <script src="scripts/jquery.ui.droppable.js" type="text/javascript"></script>
        <script src="scripts/jquery.ui.sortable.js" type="text/javascript"></script>
        <script src="scripts/json2.js" type="text/javascript"></script>
        <script src="scripts/number-functions.js" type="text/javascript"></script>
        <script src="scripts/jqPivotTable.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#pivotT").pivottable({
                    urldata: "json_data.php", //URL data from AJAX
                    urlfields: "json_field.php", //URL fields catalog from AJAX (obsolete in v 1.1)
                    table: "vstpein",
                    columns: ["CONDICION OCUPACION"],
                    rows: ["EDUCACION FORMAL", "SEXO"],
                    filters: ["ALFABETISMO"],
                    datafields: "FACTOR",
                    op: "SUM" //sum or count
                });
            })
        </script>
    </head>
    <body>
    <form id="frm1" name="frm1" method="post" action="">
        <div class="main">
                    <table id="pivotT">
                    </table>
        </div>
    </form>
    </body>
</html>
