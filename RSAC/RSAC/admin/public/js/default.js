$(document).ready(function(){
	if($(".selected a")){
		$("#page_title").html($(".selected a").html());
	}
	$("#sidebar li").on("click",function(){
		if($(this).is(".selected")){
			$(this).removeClass("selected");
			$(this).find(".caret").removeClass('fa-caret-up').addClass('fa-caret-down');
		}else{
			$("li.selected").click();
			$(this).addClass("selected");
			$(this).find(".caret").removeClass('fa-caret-down').addClass('fa-caret-up');
		}
		if($("#sidebar").is(".collapsed")){
			$(".sidebar_expand_collapse").click();
		}
	});
	var carets = $('<i class="fa fa-caret-down caret" aria-hidden="true"></i>');
	$("ul>li>ul").each(function(){
		$(this).prev().append(carets.clone());
	});
	
	$(".sidebar_expand_collapse").on("click",function(){
		if($(this).is(".collapsed")){
			$(this).removeClass("collapsed");
			$("#sidebar").removeClass("collapsed");
			$(this).css("left","200px");
			$('#sidebar').css("width","250px");
			$(".navigation").html("Navigation");
		}else{
			
			$("#sidebar .selected").click();
			$(this).addClass("collapsed");
			$("#sidebar").addClass("collapsed");
			$(this).css("left","0px");
			$('#sidebar').css("width","50px");
			$(".navigation").html("Nav");
		}
		
		$("#content").css("width","calc(100% - "+$("#sidebar").css("width")+")");
		
	});
});


//FUNCTIONS
String.prototype.ucwords= function(){
	return this.toLowerCase().replace(/\b[a-z]/g, function(letter) {
		return letter.toUpperCase();
	});
}