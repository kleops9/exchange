$(document).ready(function() {
    // on product selection fetch prices and exchange rates to show
   $("select#idItemSelect").change(function(){
        // hide and empty the containers
        $("div.clsInfoBox").hide();
        $("div.clsInfoBox").empty();
        
        // load the info and fill containers
        ajaxInfo($(this).val());
   });
});

// runs an ajax request to fetch the product info
function ajaxInfo(id){
    $.ajax({
        dataType: "json",
        url: "index.php", 
        type: "post",
        data: { "id": id, "state": "productInfo" },
        success: function(result){
            if(result.status){
                table = createItemInfoTable(result.data[id]);
                $("div#idItemInfo").append(table);
                $("div#idItemInfo").show("slow");
                window.price = result.data[id].fltPrice;
                // call the rates table after product info has finished successfully
                ajaxRates();
            }
        },
        error: function() {
            $("div#idItemInfo").text('Error retrieving product info');
        }
    });
}

// runs an ajax request to fetch the exchange rates
function ajaxRates(){
    $.ajax({
        dataType: "json",
        url: "http://api.fixer.io/latest", 
        type: "get",
        data: { "symbols": "USD,GBP,EUR", "base": "EUR" }, // the monetaries to fetch
        success: function(result){
            $("div#idItemRates").append( createRatesTable(result.rates) );
            $("div#idItemRates").show("fast");
        },
        error: function() {
            $("div#idItemRates").text('Error retrieving rates');
        }
    });
}

// creates the table rates for the product
function createRatesTable(rates){
    var table = $("<table>").append(
                    $("<thead>").append(
                            $("<th>").text("Currency")
                        ).append(
                            $("<th>").text("Amount")
                        )
                );
    table.append($("<tbody>"));
    var i = 0;
    for(currency in rates){
        tr = $("<tr>").append(
                    $("<td>").text(currency)
                ).append(
                    $("<td>").text( Math.round(rates[currency]*price*100)/100 ) // round the price to 2 decimals
                );
        if(i % 2 == 0){
        	tr.addClass("clsOdd");
        } else {
        	tr.addClass("clsEven");
    	}
        table.append(tr);
        i++;
    }
    return table;
}

// creates the table of the product information
function createItemInfoTable(info){
    var table = $("<table>").append($("<tbody>"));
    var i = 0;
    for(var property in info){
        if(property == 'fltPrice'){
	        value = "\u20AC "+info[property];
	    } else {
		    value = info[property];
		}
        tr = $("<tr>").append(
                    $("<td>").text(property.substring(3, property.length)) // hide the type of var from interface
                ).append(
                    $("<td>").text(value)
                );
        if(i % 2 == 0){
        	tr.addClass("clsOdd");
        } else {
        	tr.addClass("clsEven");
    	}
        table.append(tr);
        i++;
    }
    return table;
}