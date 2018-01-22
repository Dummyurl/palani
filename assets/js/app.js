$(document).ready(function() {
	if($('body').length > 0 ){
	var $wrapper = $("body");
		$(document).on('click', '#mobile_btn', function (e) {
			$(".dropdown.open > .dropdown-toggle").dropdown("toggle");
			return false;
		});
		$(document).on('click', '#mobile_btn', function (e) {
			$wrapper.toggleClass('slide-nav-toggle').removeClass('chatuser-opened');
			return false;
		});
		$(document).on('click', '.chat-body-left a', function (e) {
			$("body").removeClass('chatuser-opened');
			$(".sidebar-overlay").removeClass('opened');
			$(".chat-box-left").removeClass('opened');
			return false;
		});
	}
});	
	
var $sidebarOverlay = $(".sidebar-overlay");
$(".chat-users").on("click", function(e) {
	var $target = $($(this).attr("href"));
	if ($target.length) {
		$target.toggleClass("opened");
		$sidebarOverlay.toggleClass("opened");
		$("body").toggleClass("chatuser-opened").removeClass('menu-opened slide-nav-toggle');
		$sidebarOverlay.attr("data-reff", $(this).attr("href"))
	}
	e.preventDefault()
});
$sidebarOverlay.on("click", function(e) {
	var $target = $($(this).attr("data-reff"));
	if ($target.length) {
		$target.removeClass("opened");
		$("body").removeClass("chatuser-opened");
		$(this).removeClass("opened")
	}
	e.preventDefault()
});
		
var $sidebarOverlay = $(".sidebar-overlay");
$("#mobile_btn").on("click", function(e) {
	var $target = $($(this).attr("href"));
	if ($target.length) {
		$target.toggleClass("opened");
		$sidebarOverlay.toggleClass("opened");
		$("body").toggleClass("menu-opened");
		$("#chatuser_window").removeClass("opened");
		$sidebarOverlay.attr("data-reff", $(this).attr("href"))
	}
	e.preventDefault()
});
$sidebarOverlay.on("click", function(e) {
	var $target = $($(this).attr("data-reff"));
	if ($target.length) {
		$target.removeClass("opened");
		$("body").removeClass("menu-opened");
		$(this).removeClass("opened")
		$("body").removeClass("slide-nav-toggle");
	}
	e.preventDefault()
});