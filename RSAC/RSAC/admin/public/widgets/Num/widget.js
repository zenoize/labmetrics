class Num extends Widget{
	constructor($,config){
		super($,config);
	}		
	getWidget(callback){
		var THIS = this;
		this.getData(function(data){
			THIS.loadTemplate(function(template){
				template = THIS.jq(template);
				THIS.template = template;
				template.addClass(THIS.config.theme);
				template.css("width",THIS.width+'%');
				template.find(".unit").html(THIS.config.unit);
				template.find(".title").html(THIS.config.title);
				template.find(".fa").addClass("fa-" + THIS.config.fa_icon);
				template.find(".value").html(data.response);
				callback(template);
			});
		});
	}
	updateWidget(){
		var THIS = this;
		this.getData(function(data){
			THIS.template.find(".value").html(data.response);
		});
	}
}
classes["Num"] = Num;