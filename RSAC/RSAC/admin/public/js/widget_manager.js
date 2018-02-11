var includeds = [];
var classes = {};
var total_widgets = 0;
class WidgetManager {
	
	constructor(jq){
		this.jq = jq;
		this.base = this.jq("[data-base]").attr("data-base");
		this.json = this.jq("[data-json]").attr("data-json");
		this.api = this.jq("[data-api]").attr("data-api");
	}
	
	getWidgets(callback){
		var THIS = this;
		this.jq.getJSON(this.json,function(data){
			total_widgets = data.length;
			THIS.loadWidgets(data,callback);
		});
	}
	
	loadWidgets(widgets,callback){
		var THIS = this;
		var loaded_widgets = 0;
		var Ws = [];
		for(var i=0;i<widgets.length;i++){
			var widget = widgets[i];
			if(includeds.indexOf(widget.type)<0){
				includeds.push(widget.type);
				THIS.includeWidget(widget.type);
			}
			loaded_widgets++;
			widget.api = THIS.api;
			widget.base = THIS.base;
			Ws.push(new classes[widget.type](THIS.jq,widget));
			if(loaded_widgets==total_widgets)callback(Ws);			
		}
	}
	
	includeWidget(type){
		var css = $("<link rel='stylesheet'>");
		css.attr("href",this.base +"/"+type+"/widget.css");
		var script = $("<script/>");
		script.attr("src",this.base+"/"+type+"/widget.js");
		$("head").append(css);
		$("head").append(script);
	}
		
}

