(function(NS){
    NS.main = function()
    {
        var init = function()
        {
            interface();
        }

        var interface = function()
        {
            $("th:has(a)", "#data-grid").click(function(){
                window.location = $('a:first', $(this)).attr('href');
            });
        }

        init();
    }
})(Document);

$(document).ready(function()
{
    new Document.main();
});

