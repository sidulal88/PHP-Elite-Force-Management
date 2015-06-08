jQuery.fn.table2json = function(options) {
    var options = jQuery.extend({
        separator: ',',
        header: [],
        delivery: 'value' // popup, value
    },
    options);

    var csvData = [];
    var headerArr = [];
    var el = this;

    //header
    var numCols = options.header.length;
    var tmpRow = []; // construct header avalible array

    if (numCols > 0) {
        for (var i = 0; i < numCols; i++) {
            tmpRow[tmpRow.length] = formatData(options.header[i]);
        }
    } else {
       
    }
    //alert(tmpRow);
    table2json(tmpRow);
	
	
    // actual data
    $(el).find('tr').each(function() {
        var elobj = $(this);
        var tmpRow = [];
        elobj.filter(':visible').find('td').each(function() {
            if ($(this).css('display') != 'none') tmpRow[tmpRow.length] = formatData($(this).html());
        });
	//tmpRow[tmpRow.length] ="||";
        table2json(tmpRow);
        //alert(tmpRow);
    });
    if (options.delivery == 'popup') {
        var mydata = csvData.join('\n');
        return popup(mydata);
    } else {
        var mydata = csvData.join("");
        return mydata;
    }

    function table2json(tmpRow) {
        var tmp = tmpRow.join("") // to remove any blank rows
        // alert(tmp);
        if (tmpRow.length > 0 && tmp != '') {
            var mystr = tmpRow.join(options.separator);
            csvData[csvData.length] = mystr;
        }
    }
    function formatData(input) {
        // replace " with “
        var regexp = new RegExp(/["]/g);
        var output = input.replace(regexp, "“");
        //HTML
        var regexp = new RegExp(/\<[^\<]+\>/g);
        var output = output.replace(regexp, "");
        if (output == "") return '';
        return '"'+'"'+':'+'"' + output + '"';
    }
    function popup(data) {
        var generator = window.open('', 'csv');

        generator.document.write(data);
     
    }
};