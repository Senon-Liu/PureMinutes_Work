 //
 // PivotTables for jQuery  v1.1
 //
 // Copyright (c) 2011 - 2012 Benito Duran Romo
 // Dual licensed under the MIT or GPL Version 2 licenses.
 // http://jquery.org/license
 //
 // Dependencies:
 // jquery-1.7.1.min.js
 // jquery-ui-1.8.17.custom.min.js
 // json2.js
 // number-functions.js
 
 (function ($) {  
    $.fn.pivottable = function (p) {
        return this.each(function () {
            var t = this;
            $.addPivot(t, p);
        });
    }; //end PivotTable
})(jQuery);

$.addPivot = function (t, p) {
    p = $.extend({ //apply default properties
        height: 200, //default height
        width: 'auto', //auto width
        minwidth: 70, //min width of columns
        minheight: 25, //min height of columns
        urldata: false, //URL data from AJAX
        urlfields: false, //URL fields catalog from AJAX
        table: false, //source data table in database
        columns: [],
        rows: [],
        filters: [],
        datafields: false,
        op: "sum",
        format: "###,###,###,##0"
    }, p);
    $(t).show() //show if hidden
			.attr({
			    cellPadding: 0,
			    cellSpacing: 0,
			    border: 1
			}) //remove padding and spacing
			.removeAttr('width'); //remove width properties
    var pt = {
        ptbody: false,
        pthead: false,
        ptData: false,
        ptCols: [],
        ptRows: [],
        ptFilters: [],
        ptFiltersSel: [],
        ptColsSel: [],
        ptRowsSel: [],
        ptFields: 0,
        catArray: function (jsonOb) {
            var xx = new Array();
            for (var key1 in jsonOb.items)
                for (var key2 in jsonOb.items[key1]) {
                    var yy = new Array();
                    if (key2.toLowerCase() != "frec") {
                        yy.push(key2);
                        yy.push(jsonOb.items[key1][key2]);
                        xx.push(yy);
                    }
                }
            return xx;
        },
        compareNumbers: function (a, b) {
            return b - a;
        },
        getData: function () {
            if (!p.datafields) return 6;
            if (!p.urlfields | !p.urldata) return 8;
            var theurl = p.urldata;
            var thedata = { "tabla": p.table, "renglones": p.rows, "columnas": p.columns, "filtros": p.filters, "dato": p.datafields, "op": p.op };
            $.ajax({
                async: true,
                type: "POST",
                url: theurl,
                data: JSON.stringify(thedata),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                complete: function (myXHR, myStatus) {
                    if (myStatus == 'success') {
                        var resdata = myXHR.responseText;
                        var obResData = JSON.parse(resdata);
                        pt.ptData = obResData;
                        pt.buildCat();
                        pt.createHeader();
                        pt.createBody();
                        pt.setData();
                    } else
                        alert("Error al extraer el conjunto de datos");
                }
            });
        },
        handleDrop: function (ev, objsc, objtg) {
            var x = ev.pageX - $(objtg).offset().left;
            var y = ev.pageY - $(objtg).offset().top;
            var sc_arr = objsc.helper.context.id.substr(0, 1);
            var sc_pos = parseInt(objsc.helper.context.id.substr(1, objsc.helper.context.id.length - 1));
            var tr_arr = objtg.id.substr(0, 1);
            var tr_pos = parseInt(objtg.id.substr(1, objtg.id.length - 1));
            if (tr_arr == "f") {
                var tr_len = objtg.offsetHeight / 2;
                if (x > tr_len)
                    tr_pos += 1;
            }
            else {
                var tr_len = objtg.offsetWidth / 2;
                if (y > tr_len)
                    tr_pos += 1;
            }
            var changes = false;
            switch (sc_arr) {
                case "f":
                    {
                        switch (tr_arr) {
                            case "c":
                                {
                                    p.columns.splice(tr_pos, 0, p.filters[sc_pos]);
                                    p.filters.splice(sc_pos, 1);
                                    pt.ptCols.splice(tr_pos, 0, pt.ptFilters[sc_pos]);
                                    pt.ptFilters.splice(sc_pos, 1);
                                    pt.ptColsSel.splice(tr_pos, 0, pt.ptFiltersSel[sc_pos]);
                                    pt.ptFiltersSel.splice(sc_pos, 1);
                                    var changes = true;
                                    break;
                                }
                            case "r":
                                {
                                    p.rows.splice(tr_pos, 0, p.filters[sc_pos]);
                                    p.filters.splice(sc_pos, 1);
                                    pt.ptRows.splice(tr_pos, 0, pt.ptFilters[sc_pos]);
                                    pt.ptFilters.splice(sc_pos, 1);
                                    pt.ptRowsSel.splice(tr_pos, 0, pt.ptFiltersSel[sc_pos]);
                                    pt.ptFiltersSel.splice(sc_pos, 1);
                                    var changes = true;
                                    break;
                                }
                        }
                        if (p.filters.length == 0) {
                            var tdivp = document.createElement('div');
                            $(tdivp).attr('id', 'fil');
                            $(tdivp).attr('float', 'left');
                            $(tdivp).html('filters:');
                            $(tdivp).addClass("fields");
                            $(tdivp).droppable({
                                drop: function (event, ui) {
                                    pt.handleDrop(event, ui, this);
                                }
                            });
                            var ttd = $('td_fil');
                            $(ttd).append(tdivp);
                        }
                        break;
                    }
                case "c":
                    {
                        if (p.columns.length > 1)
                            switch (tr_arr) {
                            case "f":
                                {
                                    var arrSel = new Array();
                                    for (var j = 0; j < pt.ptCols[sc_pos].length; j++) {
                                        arrSel.push(true);
                                    }
                                    if (p.filters.length > 0) {
                                        p.filters.splice(tr_pos, 0, p.columns[sc_pos]);
                                        pt.ptFilters.splice(tr_pos, 0, pt.ptCols[sc_pos]);
                                        pt.ptFiltersSel.splice(tr_pos, 0, arrSel);
                                    }
                                    else {
                                        p.filters.push(p.columns[sc_pos]);
                                        pt.ptFilters.push(pt.ptCols[sc_pos]);
                                        pt.ptFiltersSel.push(arrSel);
                                    }
                                    p.columns.splice(sc_pos, 1);
                                    pt.ptCols.splice(sc_pos, 1);
                                    var changes = true;
                                    break;
                                }
                            case "r":
                                {
                                    p.rows.splice(tr_pos, 0, p.columns[sc_pos]);
                                    p.columns.splice(sc_pos, 1);
                                    pt.ptRows.splice(tr_pos, 0, pt.ptCols[sc_pos]);
                                    pt.ptCols.splice(sc_pos, 1);
                                    pt.ptRowsSel.splice(tr_pos, 0, pt.ptColsSel[sc_pos]);
                                    pt.ptColsSel.splice(sc_pos, 1);
                                    var changes = true;
                                    break;
                                }
                            default:
                                {
                                    p.columns.splice(tr_pos, 0, p.columns[sc_pos]);
                                    pt.ptCols.splice(tr_pos, 0, pt.ptCols[sc_pos]);
                                    pt.ptColsSel.splice(tr_pos, 0, pt.ptColsSel[sc_pos]);
                                    if (sc_pos > tr_pos)
                                        sc_pos++;
                                    p.columns.splice(sc_pos, 1);
                                    pt.ptCols.splice(sc_pos, 1);
                                    pt.ptColsSel.splice(sc_pos, 1);
                                    var changes = true;
                                    break;
                                }
                        }
                        break;
                    }
                case "r":
                    {
                        if (p.rows.length > 1)
                            switch (tr_arr) {
                            case "f":
                                {
                                    var arrSel = new Array();
                                    for (var j = 0; j < pt.ptRows[sc_pos].length; j++) {
                                        arrSel.push(true);
                                    }
                                    if (p.filters.length > 0) {
                                        p.filters.splice(tr_pos, 0, p.rows[sc_pos]);
                                        pt.ptFilters.splice(tr_pos, 0, pt.ptRows[sc_pos]);
                                        pt.ptFiltersSel.splice(tr_pos, 0, arrSel);
                                    }
                                    else {
                                        p.filters.push(p.rows[sc_pos]);
                                        pt.ptFilters.push(pt.ptRows[sc_pos]);
                                        pt.ptFiltersSel.push(arrSel);
                                    }
                                    p.rows.splice(sc_pos, 1);
                                    pt.ptRows.splice(sc_pos, 1);
                                    var changes = true;
                                    break;
                                }
                            case "c":
                                {
                                    p.columns.splice(tr_pos, 0, p.rows[sc_pos]);
                                    p.rows.splice(sc_pos, 1);
                                    pt.ptCols.splice(tr_pos, 0, pt.ptRows[sc_pos]);
                                    pt.ptRows.splice(sc_pos, 1);
                                    pt.ptColsSel.splice(tr_pos, 0, pt.ptRowsSel[sc_pos]);
                                    pt.ptRowsSel.splice(sc_pos, 1);
                                    var changes = true;
                                    break;
                                }
                            default:
                                {
                                    p.rows.splice(tr_pos, 0, p.rows[sc_pos]);
                                    pt.ptRows.splice(tr_pos, 0, pt.ptRows[sc_pos]);
                                    pt.ptRowsSel.splice(tr_pos, 0, pt.ptRowsSel[sc_pos]);
                                    if (sc_pos > tr_pos)
                                        sc_pos++;
                                    p.rows.splice(sc_pos, 1);
                                    pt.ptRows.splice(sc_pos, 1);
                                    pt.ptRowsSel.splice(sc_pos, 1);
                                    var changes = true;
                                    break;
                                }
                        }
                        break;
                    }
            }
            if (changes) {
                pt.updatePT();
            }
        },
        addSelect: function (cat, sec, i) {
            var tsel = document.createElement('div');
            $(tsel).attr('id', sec + "Sel" + i.toString());
            $(tsel).css('visibility', 'hidden');
            $(tsel).css('z-index', 1000 + 1);
            $(tsel).addClass('catalog');
            $(tsel).hide();
            var ttable = document.createElement("table");
            $(ttable).attr('id', 'tbl' + sec + "Sel" + i.toString());
            var ttr = document.createElement("tr");
            var ttd = document.createElement("td");
            var tcb = document.createElement("input");
            tcb.type = "checkbox";
            tcb.id = sec + "CBall" + i.toString();
            tcb.value = "(all)";
            tcb.checked = true;
            $(ttd).append(tcb);
            $(ttr).append(ttd);
            $(ttable).append(ttr);
            $(tcb).css('float', 'left');
            $(tcb).css('clear', 'right');
            $(tcb).click(function () {
                if ($(this).is(':checked')) {
                    var theChecks = $('#tbl' + sec + "Sel" + i.toString() + ' input:checkbox')
                    for (var j = 0; j < theChecks.length; j++)
                        theChecks[j].checked = true;
                }
                else {
                    var theChecks = $('#tbl' + sec + "Sel" + i.toString() + ' input:checkbox')
                    for (var j = 0; j < theChecks.length; j++)
                        theChecks[j].checked = false;
                }
            });
            tcb = null;
            ttd = null;
            var ttd = document.createElement("td");
            $(ttd).html('(all)');
            $(ttr).append(ttd);
            ttd = null;
            ttr = null;
            for (var j = 0; j < cat.length; j++) {
                var ttr = document.createElement("tr");
                var ttd = document.createElement("td");
                var tcb = document.createElement("input");
                tcb.type = "checkbox";
                tcb.id = sec + "CB" + i.toString() + j.toString();
                tcb.value = cat[j][1];
                $(tcb).css('float', 'left');
                $(tcb).css('clear', 'right');
                tcb.checked = true;
                $(tcb).click(function () {
                    if (!$(this).is(':checked'))
                        $("#" + sec + "CBall" + i.toString()).attr('checked', false);
                });
                $(ttd).append(tcb);
                $(ttr).append(ttd);
                var ttd = document.createElement("td");
                $(ttd).html(cat[j][1]);
                $(ttr).append(ttd);
                $(ttable).append(ttr);
                $(tsel).append(ttable);
                tcb = null;
                ttd = null;
                ttr = null;
            }
            return tsel;
        },
        textWidth: function (text) {
            var calc = '<span  style="display:none">' + text + '</span>';
            $(calc).attr('id', 'spTemp');
            $(calc).attr('font-size', '14');
            $(calc).attr('font-family', 'Arial, Verdana');
            $('body').append(calc);
            var width = $('body').find('span:last').width();
            $('body').find('span:last').remove();
            return width;
        },
        addField: function (Filters, FiltersSel, sec, i) {
            var tdivgp = document.createElement('div');
            $(tdivgp).addClass("coraza");
            $(tdivgp).css('z-index', i);
            var tdivp = document.createElement('div');
            $(tdivp).attr('id', sec + i.toString());
            $(tdivp).addClass("fields");
            $(tdivp).draggable({ revert: true, containment: '#pivotT', stack: ".fields", opacity: 0.9 });
            $(tdivp).droppable({
                drop: function (event, ui) {
                    pt.handleDrop(event, ui, this);
                }
            });
            var tdivh = document.createElement('span');
            $(tdivh).attr('id', sec + i.toString() + 'a');
            $(tdivh).css('float', "left");
            $(tdivp).append(tdivh);
            var timg = document.createElement('div');
            $(timg).attr('id', sec + '_im_' + i.toString());
            $(timg).addClass('tri_down');
            $(timg).click(function () {
                var Filters;
                var FiltersSel;
                switch (sec) {
                    case "f":
                        Filters = pt.ptFilters;
                        FiltersSel = pt.ptFiltersSel;
                        break;
                    case "r":
                        Filters = pt.ptRows;
                        FiltersSel = pt.ptRowsSel;
                        break;
                    case "c":
                        Filters = pt.ptCols;
                        FiltersSel = pt.ptColsSel;
                        break;
                }
                var cl_src = ($(this).attr("class") === "tri_down") ? "tri_up" : "tri_down";
                $(this).removeClass();
                $(this).addClass(cl_src);
                var idImgPos = this.id.lastIndexOf('_') + 1;
                var idImg = parseInt(this.id.substring(idImgPos, this.id.length));
                var theSel = document.getElementById(sec + 'Sel' + idImg.toString());
                if (theSel) {
                    if (theSel.style.visibility == 'visible') {
                        $(theSel).slideUp("slow");
                        var areChanges = 0;
                        for (var x = 0; x < Filters[idImg].length; x++) {
                            var selector = '#' + sec + 'CB' + idImg.toString() + x.toString(); //+ ':checkbox';
                            var theSelCB = $(selector);
                            if (FiltersSel[idImg][x] != $(theSelCB).is(':checked')) {
                                FiltersSel[idImg][x] = $(theSelCB).is(':checked');
                                areChanges++;
                            }
                        }
                        theSel.style.visibility = 'hidden';
                        if (areChanges > 0)
                            pt.updatePT();
                    }
                    else {
                        $(theSel).slideDown("slow");
                        theSel.style.visibility = 'visible';
                        for (var x = 0; x < Filters[idImg].length; x++) {
                            var selector = '#' + sec + 'CB' + idImg.toString() + x.toString(); //+ ':checkbox';
                            var theSelCB = $(selector);
                            if (FiltersSel[idImg][x] != $(theSelCB).is(':checked')) {
                                $(theSelCB).attr('checked', FiltersSel[idImg][x]);
                                if (!FiltersSel[idImg][x])
                                    $("#" + sec + "CBall" + idImg.toString()).attr('checked', false);
                            }

                        }
                    }
                }
            });
            $(tdivgp).append(timg);
            //}
            var tdivf = pt.addSelect(Filters[i], sec, i);
            $(tdivp).append(tdivf);
            switch (sec) {
                case "c":
                    tdivh.innerHTML = pt.ptCols[i][0][0].trim();
                    $(timg).css('position', 'relative');
                    $(tdivf).css('position', 'relative');
                    $(tdivh).css('position', 'relative');
                    $(tdivp).css('position', 'relative');
                    $(timg).css('z-index', 140 * (10 - i));
                    $(tdivf).css('z-index', 130 * (10 - i));
                    $(tdivh).css('z-index', 120 * (10 - i));
                    $(tdivp).css('z-index', 110 * (10 - i));
                    break;
                case "r":
                    tdivh.innerHTML = pt.ptRows[i][0][0].trim();
                    $(timg).css('position', 'relative');
                    $(tdivf).css('position', 'relative');
                    $(tdivh).css('position', 'relative');
                    $(tdivp).css('position', 'relative');
                    $(timg).css('z-index', 240 * (10 - i));
                    $(tdivf).css('z-index', 230 * (10 - i));
                    $(tdivh).css('z-index', 220 * (10 - i));
                    $(tdivp).css('z-index', 210 * (10 - i));
                    break;
                default:
                    tdivh.innerHTML = pt.ptFilters[i][0][0].trim();
                    $(timg).css('position', 'relative');
                    $(tdivf).css('position', 'relative');
                    $(tdivh).css('position', 'relative');
                    $(tdivp).css('position', 'relative');
                    $(timg).css('z-index', 340 * (10 - i));
                    $(tdivf).css('z-index', 330 * (10 - i));
                    $(tdivh).css('z-index', 320 * (10 - i));
                    $(tdivp).css('z-index', 310 * (10 - i));
                    break;
            }
            var theWidth = pt.textWidth($(tdivh).text());
            if (theWidth > p.minwidth) {
                $(tdivgp).width(theWidth + 20);
                $(tdivp).width(theWidth);
            }
            else {
                $(tdivgp).width(p.minwidth + 20);
                $(tdivp).width(p.minwidth);
            }
            timg = null;
            tdivh = null;
            $(tdivgp).append(tdivp);
            tdivp = null;
            return tdivgp;
        },
        addFiltersHeader: function () {
            var ttable = document.createElement('table');
            for (i = 0; i < pt.ptFilters.length; i++) {
                var ttr = document.createElement('tr');
                var ttd = document.createElement('td');
                $(ttd).append(pt.addField(pt.ptFilters, pt.ptFiltersSel, "f", i));
                $(ttr).append(ttd);
                $(ttable).append(ttr);
                ttd = null;
                ttr = null;
            }
            return ttable;
        },
        addColsHeader: function () {
            var ttable = document.createElement('table');
            var ttr = document.createElement('tr');
            for (i = 0; i < pt.ptCols.length; i++) {
                var ttd = document.createElement('td');
                $(ttd).append(pt.addField(pt.ptCols, pt.ptColsSel, "c", i));
                $(ttr).append(ttd);
                ttd = null;
            }
            $(ttable).append(ttr);
            ttr = null;
            return ttable;
        },
        buildCat: function () {
            var xx = new Array();
            var cnt = 0;
            for (var key1 in pt.ptData.items) {
                for (var key2 in pt.ptData.items[key1]) {
                    var key2Val = pt.ptData.items[key1][key2]
                    if (cnt == 0) {
                        var yy = new Array();
                        var zz = new Array();
                        yy.push(key2);
                        yy.push(key2Val);
                        zz.push(yy);
                        xx.push(zz);
                    } else {
                        var laPos1 = -1;
                        for (var i = 0; i < xx.length; i++)
                            if (key2 == xx[i][0][0])
                                laPos1 = i;
                        var laPos2 = -1;
                        for (var i = 0; i < xx[laPos1].length; i++)
                            if (key2Val == xx[laPos1][i][1])
                                laPos2 = i;
                        if (laPos2 == -1) {
                            var yy = new Array();
                            yy.push(key2);
                            yy.push(key2Val);
                            xx[laPos1].push(yy);
                        }
                    }
                }
                cnt++;
            }
            for (var i = 0; i < p.rows.length; i++)
                for (var j = 0; j < xx.length; j++)
                    if (p.rows[i] == xx[j][0][0])
                        pt.ptRows.push(xx[j]);
            for (var i = 0; i < p.columns.length; i++)
                for (var j = 0; j < xx.length; j++)
                    if (p.columns[i] == xx[j][0][0])
                        pt.ptCols.push(xx[j]);
            for (var i = 0; i < p.filters.length; i++)
                for (var j = 0; j < xx.length; j++)
                    if (p.filters[i] == xx[j][0][0])
                        pt.ptFilters.push(xx[j]);
            for (var i = 0; i < pt.ptRows.length; i++) {
                var arrSel = new Array();
                for (var j = 0; j < pt.ptRows[i].length; j++)
                    arrSel.push(true);
                pt.ptRowsSel.push(arrSel);
            }
            for (var i = 0; i < pt.ptCols.length; i++) {
                var arrSel = new Array();
                for (var j = 0; j < pt.ptCols[i].length; j++)
                    arrSel.push(true);
                pt.ptColsSel.push(arrSel);
            }
            for (var i = 0; i < pt.ptFilters.length; i++) {
                var arrSel = new Array();
                for (var j = 0; j < pt.ptFilters[i].length; j++)
                    arrSel.push(true);
                pt.ptFiltersSel.push(arrSel);
            }
        },
        createHeader: function () {
            var numRows = pt.ptRows.length;
            var numCols = pt.ptCols.length;
            var totCols = new Array();
            totCols.push(1);
            var cnt = 0;
            for (i = pt.ptCols.length; i > 0; i--) {
                totCols.push(totCols[cnt] * pt.ptCols[i - 1].length);
                cnt++;
            }
            totCols.sort(pt.compareNumbers);
            var tthead = $(pt.pthead);

            var ttr = document.createElement('tr');
            var ttd = document.createElement('td');
            $(ttd).css('text-align', 'left');
            $(ttd).css('vertical-align', 'top');
            $(ttd).attr('id', 'td_fil');
            $(ttd).attr('colspan', numRows);
            $(ttd).attr('rowspan', numCols);
            $(ttd).attr('width', p.minwidth);
            $(ttd).addClass("headerpt");
            if (pt.ptFilters.length > 0)
                $(ttd).append(pt.addFiltersHeader());
            else {
                var tdivp = document.createElement('div');
                $(tdivp).attr('id', 'fil');
                $(tdivp).attr('float', 'left');
                $(tdivp).html('filters:');
                $(tdivp).addClass("fields");
                $(tdivp).droppable({
                    drop: function (event, ui) {
                        pt.handleDrop(event, ui, this);
                    }
                });
                $(ttd).append(tdivp);
            }
            $(ttr).append(ttd);
            ttd = null;
            var ttd = document.createElement('td');
            $(ttd).attr("colspan", totCols[0]);
            $(ttd).css('height', "30px");
            $(ttd).addClass("headerpt");
            $(ttd).append(pt.addColsHeader());
            $(ttr).append(ttd);
            var ttd = document.createElement('td');
            $(ttd).attr("rowspan", pt.ptCols.length + 1);
            $(ttd).addClass("headerpt");
            $(ttd).html('Total');
            $(ttr).append(ttd);
            $(tthead).append(ttr);
            ttd = null;
            ttr = null;
            var totColsOt = new Array();
            totColsOt.push(pt.ptCols[0].length);
            for (i = 1; i < pt.ptCols.length; i++)
                totColsOt.push(pt.ptCols[i].length * totColsOt[i - 1]);
            var otCnt = new Array();
            for (i = 0; i < pt.ptCols.length - 1; i++)
                otCnt.push(0);
            for (i = 0; i < pt.ptCols.length - 1; i++) {
                ttr = document.createElement('tr');
                for (j = 0; j < totColsOt[i]; j++) {
                    var ttd = document.createElement('td');
                    $(ttd).attr('colspan', totCols[i + 1]);
                    $(ttd).attr('width', p.minwidth);
                    $(ttd).attr('height', p.minheight);
                    $(ttd).addClass("headerpt");
                    ttd.innerHTML = pt.ptCols[i][otCnt[i]][1];
                    $(ttr).append(ttd);
                    ttd = null;
                    if (otCnt[i] >= pt.ptCols[i].length - 1)
                        otCnt[i] = 0;
                    else
                        otCnt[i]++;
                }
                $(tthead).append(ttr);
                ttr = null;
            }
            var ttr = document.createElement('tr');
            for (i = 0; i < numRows; i++) {
                var ttd = document.createElement('td');
                $(ttd).attr('width', p.minwidth);
                $(ttd).addClass("headerrowpt");
                $(ttd).append(pt.addField(pt.ptRows, pt.ptRowsSel, "r", i));
                $(ttr).append(ttd);
                ttd = null;
            }
            var totTd = 1;
            for (j = pt.ptCols.length; j > 0; j--) {
                totTd *= pt.ptCols[j - 1].length;
            }
            var cnt = 0;
            for (i = 0; i < totTd; i++) {
                var ttd = document.createElement('td');
                $(ttd).attr('width', p.minwidth);
                $(ttd).attr('height', p.minheight);
                $(ttd).addClass("headerpt");
                ttd.innerHTML = pt.ptCols[pt.ptCols.length - 1][cnt][1];
                var theCol = i + 1;
                $(ttd).attr('id', "Ccell" + theCol.toString());
                $(ttr).append(ttd);
                ttd = null;
                if (cnt < pt.ptCols[pt.ptCols.length - 1].length - 1)
                    cnt++;
                else
                    cnt = 0;
            }
            $(tthead).append(ttr);
            ttr = null;
            $(t).append(tthead);
            tthead = null;
        },
        createBody: function () {
            var numRows = pt.ptRows.length;
            var totRows = new Array();
            totRows.push(1);
            var cnt = 0;
            for (i = pt.ptRows.length; i > 0; i--) {
                totRows.push(totRows[cnt] * pt.ptRows[i - 1].length);
                cnt++;
            }
            totRows.sort(pt.compareNumbers);
            var arCnt = new Array();
            var otCnt = new Array();
            for (i = 0; i < totRows.length - 1; i++) {
                arCnt.push(0);
                otCnt.push(0);
            }
            var ttbody = $(pt.ptbody);
            $(ttbody).empty();
            var totTd = 1;
            for (j = pt.ptCols.length; j > 0; j--) {
                totTd *= pt.ptCols[j - 1].length;
            }

            for (i = 0; i < totRows[0]; i++) {
                var ttr = document.createElement('tr');
                for (j = 0; j < pt.ptRows.length - 1; j++) {
                    if (arCnt[j] == 0) {
                        var ttd = document.createElement('td');
                        $(ttd).attr('rowspan', totRows[j + 1]);
                        $(ttd).addClass("rowspt");
                        ttd.innerHTML = pt.ptRows[j][otCnt[j]][1];
                        $(ttr).append(ttd);
                        ttd = null;
                        arCnt[j]++;
                        otCnt[j]++;
                    }
                    else
                        arCnt[j]++;
                    if (arCnt[j] >= totRows[j + 1])
                        arCnt[j] = 0;
                    if (otCnt[j] >= pt.ptRows[j].length)
                        otCnt[j] = 0;
                }
                var ttd = document.createElement('td');
                $(ttd).addClass("rowspt");
                ttd.innerHTML = pt.ptRows[pt.ptRows.length - 1][otCnt[pt.ptRows.length - 1]][1];
                otCnt[pt.ptRows.length - 1]++;
                if (otCnt[pt.ptRows.length - 1] >= pt.ptRows[pt.ptRows.length - 1].length)
                    otCnt[pt.ptRows.length - 1] = 0;
                var theRow = i + 1;
                $(ttd).attr('id', "Rcell" + theRow.toString());
                $(ttr).append(ttd);
                ttd = null;

                for (j = 0; j <= totTd; j++) {
                    var ttd = document.createElement('td');
                    //var theRow = i + 1;
                    var theCol = j + 1;
                    if (j == totTd)
                        $(ttd).attr('id', "totR_" + theRow.toString());
                    else
                        $(ttd).attr('id', "cell" + theRow.toString() + "_" + theCol.toString());
                    $(ttd).attr('width', p.minwidth);
                    $(ttd).attr('height', p.minheight);
                    $(ttd).addClass("datacell");
                    $(ttr).append(ttd);
                    ttd = null;
                }
                $(ttbody).append(ttr);
                ttr = null;
            }
            //Total Row
            //The head row
            var ttr = document.createElement('tr');
            var ttd = document.createElement('td');
            $(ttd).attr('colspan', pt.ptRows.length);
            $(ttd).addClass("rowspt");
            $(ttd).html('Total');
            $(ttr).append(ttd);
            ttd = null;
            //The cells row
            for (j = 0; j <= totTd; j++) {
                var ttd = document.createElement('td');
                var theRow = i + 1;
                var theCol = j + 1;
                $(ttd).attr('id', "totC_" + theCol.toString());
                $(ttd).attr('width', p.minwidth);
                $(ttd).attr('height', p.minheight);
                $(ttd).addClass("datacell");
                $(ttr).append(ttd);
                ttd = null;
            }
            $(ttbody).append(ttr);
            ttr = null;
            $(t).append(ttbody);
            ttbody = null;
        }, //end createBody
        hideCells: function () {
            var theRows = $('td[id*="totR"]');
            var theCols = $('td[id*="totC"]');
            if (theRows.length > 0) {
                for (var i = 0; i < theRows.length; i++) {
                    if (theRows[i].innerHTML == '') {
                        var x = i + 1;
                        $('#totR' + '_' + x.toString()).height(1);
                        $('#Rcell' + x.toString()).html('');
                        $('#Rcell' + x.toString()).height(1);
                        for (var j = 0; j < theCols.length; j++) {
                            var y = j + 1;
                            $('#cell' + x.toString() + '_' + y.toString()).height(1);
                        }
                    }
                }
            }
            if (theCols.length > 0) {
                for (var i = 0; i < theCols.length; i++) {
                    if (theCols[i].innerHTML == '') {
                        var x = i + 1;
                        $('#totC' + '_' + x.toString()).width(1);
                        $('#Ccell' + x.toString()).html('');
                        $('#Ccell' + x.toString()).width(1);
                        for (var j = 0; j < theRows.length; j++) {
                            var y = j + 1;
                            $('#cell' + y.toString() + '_' + x.toString()).width(1);
                        }
                    }
                }
            }
        },
        getPos: function (value, thearray) {
            var theRes = -1;
            for (var i = 0; i < thearray.length; i++) {
                if (value == thearray[i][1])
                    theRes = i;
            }
            return theRes;
        },
        getPosRow: function (item) {
            //get Position in Rows //
            var laPosRowFinal = 0;
            var laPosRowPar = new Array();
            var posCodRow = new Array();
            var totCodRow = new Array();
            //Get position in row catalog
            for (j = 0; j < p.rows.length; j++) {
                thePos = pt.getPos(item[p.rows[j]], pt.ptRows[j]) + 1;
                posCodRow.push(thePos);
                totCodRow.push(pt.ptRows[j].length);
                laPosRowPar.push(0);
            }
            //get partial potitions
            for (var j = 0; j < posCodRow.length; j++) {
                laPosRowPar[j] = posCodRow[j] - 1;
                if (j < posCodRow.length - 1) {
                    for (x = j + 1; x < posCodRow.length; x++)
                        laPosRowPar[j] *= totCodRow[x];
                }
                else
                    laPosRowPar[j] = posCodRow[j];
            }
            //Get Final position
            for (var j = 0; j < posCodRow.length; j++)
                laPosRowFinal += laPosRowPar[j];

            return laPosRowFinal;
        },
        getPosCol: function (item) {
            //get Position in Cols //
            var laPosColFinal = 0;
            var laPosColPar = new Array();
            var posCodCol = new Array();
            var totCodCol = new Array();
            //Get position in row catalog
            for (j = 0; j < p.columns.length; j++) {
                thePos = pt.getPos(item[p.columns[j]], pt.ptCols[j]) + 1;
                posCodCol.push(thePos);
                totCodCol.push(pt.ptCols[j].length);
                laPosColPar.push(0);
            }
            //get partial potitions
            for (var j = 0; j < posCodCol.length; j++) {
                laPosColPar[j] = posCodCol[j] - 1;
                if (j < posCodCol.length - 1) {
                    for (x = j + 1; x < posCodCol.length; x++)
                        laPosColPar[j] *= totCodCol[x];
                }
                else
                    laPosColPar[j] = posCodCol[j];
            }
            //Get Final position
            for (var j = 0; j < posCodCol.length; j++)
                laPosColFinal += laPosColPar[j];

            return laPosColFinal;
        },
        isInFilters: function (item, filters, Filters, FiltersSel) {
            var isFilter = true;
            for (j = 0; j < filters.length; j++) {
                thePos = pt.getPos(item[filters[j]], Filters[j]);
                if (!FiltersSel[j][thePos])
                    isFilter = false;
            }
            return isFilter;
        },
        setData: function () {
            var totTr = 1;
            for (j = pt.ptRows.length; j > 0; j--)
                totTr *= pt.ptRows[j - 1].length;
            var totRow = new Array(totTr);
            for (var z = 0; z < totTr; z++)
                totRow[z] = 0;

            var totTd = 1;
            for (j = pt.ptCols.length; j > 0; j--)
                totTd *= pt.ptCols[j - 1].length;
            var totCol = new Array(totTd);
            for (var z = 0; z < totTd; z++)
                totCol[z] = 0;
            var theTotal = 0;
            var totCell = new Array(totTr)
            for (i = 0; i < totTr; i++)
                totCell[i] = new Array(totTd);
            for (i = 0; i < totTr; i++)
                for (j = 0; j < totTd; j++)
                    totCell[i][j] = 0;
            for (i = 0; i < pt.ptData.items.length; i++) {
                var inFiltersF = pt.isInFilters(pt.ptData.items[i], p.filters, pt.ptFilters, pt.ptFiltersSel);
                var inFiltersC = pt.isInFilters(pt.ptData.items[i], p.columns, pt.ptCols, pt.ptColsSel);
                var inFiltersR = pt.isInFilters(pt.ptData.items[i], p.rows, pt.ptRows, pt.ptRowsSel);
                if (inFiltersF & inFiltersC & inFiltersR) {
                    var posRow = pt.getPosRow(pt.ptData.items[i]) - 1;
                    var posCol = pt.getPosCol(pt.ptData.items[i]) - 1;
                    var theData =  pt.ptData.items[i][p.datafields];
                    var theValue=0;
                    if (typeof(theData)=='string')
                        theValue= parseFloat(theData);
                    if (typeof(theData)=='number')
                        theValue= theData;
                    totCell[posRow][posCol] += theValue;
                    totRow[posRow] += theValue;
                    totCol[posCol] += theValue;
                    theTotal += theValue;
                    posCol=null; posRow=null; theData=null; theValue=null;
                }
            }
            for (i = 0; i < totTr; i++) {
                for (j = 0; j < totTd; j++) {
                    var posRow = i + 1;
                    var posCol = j + 1;
                    var theCell = $("#cell" + posRow.toString() + "_" + posCol.toString());
                    if (totCell[i][j] > 0)
                        theCell.html(Number(totCell[i][j]).numberFormat(p.format));
                }
            }
            for (i = 0; i < totTr; i++) {
                var posRow = i + 1;
                var theCell = $("#totR_" + posRow.toString());
                if (totRow[i] > 0)
                    theCell.html(Number(totRow[i]).numberFormat(p.format));
            }
            for (i = 0; i < totTd; i++) {
                var posCol = i + 1;
                var theCell = $("#totC_" + posCol.toString());
                if (totCol[i] > 0)
                    theCell.html(Number(totCol[i]).numberFormat(p.format));
            }
            //add Total Total
            var posCol = totTd + 1;
            var theCell = $("#totC_" + posCol.toString());
            theCell.html(Number(theTotal).numberFormat(p.format));
        },
        removeTRs: function (selector) {
            selector += " tr";
            $(selector).each(function () {
                this.parentNode.removeChild(this);
            });
        },
        ptPause: function (millis) {
            var date = new Date();
            var curDate = null;

            do { curDate = new Date(); }
            while (curDate - date < millis);
        },
        checkError: function (err) {
            var errDes = '';
            switch (err) {
                case 1:
                    errDes = 'Error: It was not possible to connect to Web service.';
                    break;
                case 2:
                    errDes = 'Error: it was not possible to extract the catalogues.';
                    break;
                case 3:
                    errDes = 'Error: It was not possible to extract the data.';
                    break;
                case 4:
                    errDes = 'Error: Must be defined a field or variable in rows.';
                    break;
                case 5:
                    errDes = 'Error: must be defined a field or variable in columns.';
                    break;
                case 6:
                    errDes = 'Error: Is not defined the data to add or count.';
                    break;
                case 7:
                    errDes = 'Error: The table in the database where the data is extracted is not defined.';
                    break;
                case 8:
                    errDes = 'Error: The data or catalogs url is not defined.';
                    break;
            }
            alert(errDes);
        },
        updatePT: function () {
            pt.removeTRs(pt.pthead);
            pt.removeTRs(pt.ptbody);
            $(t).fadeOut(1000);
            pt.createHeader();
            pt.createBody();
            pt.setData();
            pt.hideCells();
            $(t).fadeIn(1000);
        }
    }; //end pt
    $(t).empty();
    $(t).css('width', '100%');
    $(t).css('height', '100px');
    var tthead = document.createElement('thead');
    $(tthead).attr("id", "had");
    pt.pthead = "#had";
    $(t).append(tthead);
    tthead = null;
    var ttbody = document.createElement('tbody');
    $(ttbody).attr("id", "bdy");
    pt.ptbody = "#bdy";
    var ttr = document.createElement('tr');
    var ttd = document.createElement('td');
    $(ttd).css('text-align', 'center');
    $(ttd).css('vertical-align', 'center');
    $(ttd).css('width', '100%');
    $(ttd).css('height', '100%');
    $(ttd).html("<img src='../css/images/loader.gif' />");
    $(ttr).append(ttd);
    $(ttbody).append(ttr);
    $(t).append(ttbody);
    ttbody = null;
    pt.getData();
}  //end addPivot