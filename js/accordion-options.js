jQuery(document).ready( function($){
    var $accordionTabs = $('.accordion-tabs');

    $accordionTabs.accordionTabs({
        // Plugin options
        mediaQuery: '(min-width: 48em)' // Set when tabs should be used instead of accordion
    }, {
        // jQuery UI Accordion options <http://api.jqueryui.com/accordion/>
        active: 0,
        animate: 20,
        header: 'h3', // Specify the heading level you used (required)
        heightStyle: 'auto',
        collapsible: true
    }, {
        // jQuery UI Tabs options <http://api.jqueryui.com/tabs/>
        show: {
            effect: 'fade'
        }
    });
});
