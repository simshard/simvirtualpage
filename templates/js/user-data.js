jQuery(document).ready(function ($) {
    var log = $("#user-data");
    var apiurl = ivpVars.apiurl;
    var ajaxLoading = false;
    var spinner = $("#cG");
    spinner.hide();
    $('.userlink').on('click', function (event) {
        event.preventDefault();
        log.empty();
        ajaxLoading = true;
        spinner.show();

        var userid = event.target.getAttribute('user').valueOf();
        var userDataUrl = apiurl + userid;

        var jqxhr = $.getJSON(userDataUrl, function (data) {
            jQuery.each(data, function (key, value) {
                if (typeof (value) === 'string') {
                    log.append(key + " : " + value + "<br> ");
                }
                if (typeof (value) === 'object') {
                    log.append(key + "<br>");
                    jQuery.each(value, function (key, value) {
                        if (typeof (value) === 'string') {
                            log.append(" &nbsp; &nbsp; " + key +
                                " : " + value +
                                "<br> ");
                        }
                        if (typeof (value) === 'object') {
                            jQuery.each(value, function (key, value) {
                                log.append(
                                    " &nbsp; &nbsp; &nbsp; &nbsp; " +
                                    key + ":" +
                                    value + "<br> ");
                            });
                        }
                    });
                }
            }); //each
           
            console.dir(data);
             
        } //success handler
        )
            .done(function () {
                ajaxLoading = false;
                spinner.hide();
            })
            .fail(function (xhr, status, error) {
                ajaxLoading = false;
                spinner.hide();
                log.html(`<p>An error has occurred while fetching data: <em>${xhr.statusText}</em></p>`);
            })
    console.dir(jqxhr);        
    }); //click  
    
}); //DomReady