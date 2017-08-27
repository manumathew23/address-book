
function displayYear()
{
    var current = new Date().getFullYear();
    var till = current - 13;
    var yearstart = till - 120;
    var options = "";
    options += "<option>"+"year"+"</option>";
    for (var y = yearstart; y <= till; y++){
        options += "<option>"+ y +"</option>";
    }
    return options;
}

function displayDate()
{
    var date = 1;
    var last = 31;
    var options = "";
    options += "<option>"+"date"+"</option>";
    for (var d = date; d <= last; d++) {            
        options += "<option>"+ d +"</option>";
    }
    return options;
}

function displayMonth()
{
    var startmonth = 1;
    var lastmonth = 12;
    var options = "";
    options += "<option>"+"month"+"</option>";
    for (var m = startmonth; m <= lastmonth; m++) {
        options += "<option>"+ m +"</option>";
    }
    return options;
}


