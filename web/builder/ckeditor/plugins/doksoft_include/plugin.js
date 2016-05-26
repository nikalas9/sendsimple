CKEDITOR.plugins.add("doksoft_include",{
	onLoad:function(a){
	
	},
	init:function(b){
		var c=function(d){
			var f=b.document.$,e=f.createElement("link");
			e.href=d;
			e.type="text/css";
			e.rel="stylesheet";
			
			console.log(e);
			
			f.head.appendChild(e);
		};
		var a=function(d){
			var f=b.document.$,e=f.createElement("script");
			e.src=d;e.type="text/javascript";
			f.head.appendChild(e);
		};
		b.on("contentDom",function(){
			if(b.config.doksoft_include_css&&b.config.doksoft_include_css instanceof Array&&b.config.doksoft_include_css.length){
				for(var d in b.config.doksoft_include_css){
					c(b.config.doksoft_include_css[d]);
				}
			}
			if(b.config.doksoft_include_js&&b.config.doksoft_include_js instanceof Array&&b.config.doksoft_include_js.length){
				for(var d in b.config.doksoft_include_js){
					a(b.config.doksoft_include_js[d]);
				}
			}
		});
	}
});