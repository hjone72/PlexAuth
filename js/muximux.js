function setTitle(title) {
    $(document).ready(function ($) {
        $(document).attr("title", "YTB | " + title);
    })
}

function setHash(hash) {
	window.history.pushState(hash, "Title", "#" + hash);
}

jQuery(document).ready(function($){
    $.extend($.expr[":"], {
        "containsInsensitive": function(elem, i, match, array) {
        return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
    });

	var tabs = $('.nav-wrapper');

	tabs.each(function(){
		var tab = $(this),
			tabItems = tab.find('li.iframed'),
			tabContentWrapper = $('.iframe-content'),
			tabNavigation = tab.find('nav');
		tabItems.on('click', 'a', function(event){
			event.preventDefault();
			var selectedItem = $(this);
			if( !selectedItem.hasClass('selected') ) {
				var selectedTab = selectedItem.data('content'),
					selectedContent = tabContentWrapper.find('li[data-content="'+selectedTab+'"]'),
					selectedContentHeight = selectedContent.innerHeight();
				selectedItem.dblclick(function() {
					selectedContent.children('iframe').attr('src', selectedContent.children('iframe').attr('src'));
				})
				setTitle(selectedTab);
				setHash(selectedTab);
		                var sifsrc = selectedContent.children('iframe').attr('src');
		                if (sifsrc === undefined || sifsrc === "") {
		                    selectedContent.children('iframe').attr('src', selectedContent.children('iframe').data('src'));
		                }

				tabItems.find('a.selected').removeClass('selected');
				selectedItem.addClass('selected');
				selectedContent.siblings('li').children('iframe').removeClass('iselected');
				selectedContent.children('iframe').addClass('iselected');
				//animate tabContentWrapper height when content changes
				tabContentWrapper.animate({
					'height': selectedContentHeight
				}, 200);
			}
		});

		//hide the .cd-tabs::after element when tabbed navigation has scrolled to the end (mobile version)
		checkScrolling(tabNavigation);
		tabNavigation.on('scroll', function(){
			checkScrolling($(this));
		});
	});


	$('#reload').on('click', function(){
		var selectedFrame = $('.cd-tabs-content').find('.selected').children('iframe');
		selectedFrame.attr('src', selectedFrame.attr('src'));
	})


	$(window).on('resize', function(){
		tabs.each(function(){
			var tab = $(this);
			checkScrolling(tab.find('nav'));
			$('.iframe-content').css('height', 'auto');
		});
		resizeIframe(); // Resize iframes when window is resized.
	});


	function checkScrolling(tabs){
		var totalTabWidth = parseInt(tabs.children('.cd-tabs-navigation').width()),
		 	tabsViewport = parseInt(tabs.width());
		if( tabs.scrollLeft() >= totalTabWidth - tabsViewport) {
			tabs.parent('.cd-tabs').addClass('is-ended');
		} else {
			tabs.parent('.cd-tabs').removeClass('is-ended');
		}
	}

	// Measure viewport and subtract the height the navigation tabs, then resize the iframes.
	function resizeIframe(){
		$('.navbar-fixed').css({ 'margin-bottom': '0px'});
		$('.page-footer').css({ 'margin-top': '0px'});
                var newSize = $(window).height() - $('nav').height();
		$('.valign-wrapper').css({ 'align-items': 'flex-start'});
		$('iframe').css({ 'height': newSize + 'px' });
	}

        if($(location).attr('hash')) {
            var bookmarkHash = $(location).attr('hash').substr(1).replace("%20", " ").replace("_", " ");
            var menuItem = $(document).find('a:containsInsensitive("'+bookmarkHash+'")');
		console.log(bookmarkHash);
            menuItem.trigger("click");
        }else{
		window.location.href = 'https://blog.yourtechbase.com';
	}

// Call resizeIframe when document is ready
resizeIframe();
});
