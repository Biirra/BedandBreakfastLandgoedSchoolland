YUI().use('calendar', function (Y) {

    // Create a new instance of calendar, placing it in
    // #mycalendar container, setting its width to 340px,
    // the flags for showing previous and next month's
    // dates in available empty cells to true, and setting
    // the date to today's date.
    var calendar = new Y.Calendar({
        contentBox: "#mycalendar",
        width: '520px',
        showPrevMonth: true,
        showNextMonth: true,
        date: new Date()
    }).render();

    var data = {
        "action": "getDatumsBezet"
    };

    var filterFunction = function (date, node, rules) {
        if (rules.indexOf("summer-2011" >= 0)) {
            node.removeClass("yui3-calendar-day")
            node.addClass("bezet");
        }
    }

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "includes/kalenderdata.php",
        data: data,
        success: function (response) {
            var daysTaken = $.parseJSON(response['json']);
            console.log(daysTaken);
            calendar.set("customRenderer", {rules: daysTaken, filterFunction: filterFunction});
        },
        error: function (response) {
            console.log("error: " + response['error']);
        }
    });
});
