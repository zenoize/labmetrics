var wm = new WidgetManager($);
wm.getWidgets(function(widgets){
		console.log(widgets);
		for(var i=0;i<widgets.length;i++){
			var widget = widgets[i];
			widget.getWidget(function(template){
				wm.jq(widget.parent).append(template);
			});
		}
});
