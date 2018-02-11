class Widget{
	constructor($,config){
		var THIS = this;
		this.jq = $;
		this.config = config;
		this.widget_path = this.config.base + "/" + this.config.type + "/";
		this.parent = this.config.parent;
		this.width = (this.config.size/12) * 100;
		setInterval(function(){
			THIS.updateWidget();
		},this.config.refresh);
	}
	
	getData(callback){
		var args = {};
		for(var i=0;i<this.config.perameters.length;i++){
			var perameter = this.config.perameters[i];
			args[perameter.name] = perameter.value;
		}
		args["return"] = this.config.apicall;
		this.jq.getJSON(this.config.api,args,function(results){
			callback(results);
		});
	}

	
	loadTemplate(callback){
		this.jq.get(this.widget_path + 'widget.html',function(template){
			callback(template);
		});
	}
	
	replacer(find,string){
		return string.replace(new RegExp("["+find.toUpperCase()+"]", 'g'),string);
	}
}