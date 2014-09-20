String.prototype.NumChar=function(){
    if(!this) return false;
    var y = this.charAt(0), z = 10
    
    while(z--){
        if(y==z){return true;break;}
    }
    return false;
}

//DOM ready borrowed (and botched). Thanks to John Resig (jquery.com)
if (typeof DomReady == 'undefined'){
(function(){

    var DomReady = window.DomReady = {};

	// Everything that has to do with properly supporting our document ready event. Brought over from the most awesome jQuery. 

    var userAgent = navigator.userAgent.toLowerCase();

    // Figure out what browser is being used
    var browser = {
    	version: (userAgent.match( /.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/ ) || [])[1],
    	safari: /webkit/.test(userAgent),
    	opera: /opera/.test(userAgent),
    	msie: (/msie/.test(userAgent)) && (!/opera/.test( userAgent )),
    	mozilla: (/mozilla/.test(userAgent)) && (!/(compatible|webkit)/.test(userAgent))
    };    

	var readyBound = false;	
	var isReady = false;
	var readyList = [];

	// Handle when the DOM is ready
	function domReady() {
		// Make sure that the DOM is not already loaded
		if(!isReady) {
			// Remember that the DOM is ready
			isReady = true;
        
	        if(readyList) {
	            for(var fn = 0; fn < readyList.length; fn++) {
	                readyList[fn].call(window, []);
	            }
            
	            readyList = [];
	        }
		}
	};

	// From Simon Willison. A safe way to fire onload w/o screwing up everyone else.
	function addLoadEvent(func) {
	  var oldonload = window.onload;
	  if (typeof window.onload != 'function') {
	    window.onload = func;
	  } else {
	    window.onload = function() {
	      if (oldonload) {
	        oldonload();
	      }
	      func();
	    }
	  }
	};

	// does the heavy work of working through the browsers idiosyncracies (let's call them that) to hook onload.
	function bindReady() {
		if(readyBound) {
		    return;
	    }
	
		readyBound = true;

		// Mozilla, Opera (see further below for it) and webkit nightlies currently support this event
		if (document.addEventListener && !browser.opera) {
			// Use the handy event callback
			document.addEventListener("DOMContentLoaded", domReady, false);
		}

		// If IE is used and is not in a frame
		// Continually check to see if the document is ready
		if (browser.msie && window == top) (function(){
			if (isReady) return;
			try {
				// If IE is used, use the trick by Diego Perini
				// http://javascript.nwbox.com/IEContentLoaded/
				document.documentElement.doScroll("left");
			} catch(error) {
				setTimeout(arguments.callee, 0);
				return;
			}
			// and execute any waiting functions
		    domReady();
		})();

		if(browser.opera) {
			document.addEventListener( "DOMContentLoaded", function () {
				if (isReady) return;
				for (var i = 0; i < document.styleSheets.length; i++)
					if (document.styleSheets[i].disabled) {
						setTimeout( arguments.callee, 0 );
						return;
					}
				// and execute any waiting functions
	            domReady();
			}, false);
		}

		if(browser.safari) {
		    var numStyles;
			(function(){
				if (isReady) return;
				if (document.readyState != "loaded" && document.readyState != "complete") {
					setTimeout( arguments.callee, 0 );
					return;
				}
				if (numStyles === undefined) {
	                var links = document.getElementsByTagName("link");
	                for (var i=0; i < links.length; i++) {
	                	if(links[i].getAttribute('rel') == 'stylesheet') {
	                	    numStyles++;
	                	}
	                }
	                var styles = document.getElementsByTagName("style");
	                numStyles += styles.length;
				}
				if (document.styleSheets.length != numStyles) {
					setTimeout( arguments.callee, 0 );
					return;
				}
			
				// and execute any waiting functions
				domReady();
			})();
		}

		// A fallback to window.onload, that will always work
	    addLoadEvent(domReady);
	};

	// This is the public function that people can use to hook up ready.
	DomReady.ready = function(fn) {
        if(typeof JQuery != 'undefined'){
            JQuery(document).ready(fn)
            return;
        }else if(typeof MooTools != 'undefined'){
            window.addEvent('domready', fn)
            return;
        }
		// Attach the listeners
		bindReady();
    
		// If the DOM is already ready
		if (isReady) {
			// Execute the function immediately
			fn.call(window, []);
	    } else {
			// Add the function to the wait list
	        readyList.push( function() { return fn.call(window, []); } );
	    }
	};
    
	bindReady();
	
})();
}


var qwikpost={
    load:function(qpconfig, base, xt){
        this.media=qpconfig.media
        this.type=qpconfig.type
        this.base = base
        this.xt = xt
    },
    scan:function(){
        if(!this.media || !this.type) return
            var links = document.getElementById('ContentBody').getElementsByTagName('input')
            var qp = links.length
            while(qp--){
                if(links[qp].getAttribute('name')!=='qwikpost') continue;
                this.parse(links[qp].nextSibling)
            }
    },
    insert_matches:function(x,y){
        if(typeof x !='string') return x;
        var a=0,b,c,d
        while((a=x.indexOf("$",a))!=-1&&x.charAt(a+1).NumChar()&&(a==0 || x.charAt(a-1)!='\\')){
            if(!(b=y[x.charAt(a+1)])){a+=2;continue;}
            c=x.substring(0,a)+b
            d=x.substring(a+2)
            a=c.length;            
            x=c+d
        }
        
        return x;
    },
    insert_params:function(x,y){
        var a=0,b,c,d,e
        while((a=x.indexOf("#{",a))!=-1&&(b=x.indexOf("}",a))!=-1&&(a==0 || x.charAt(a-1)!='\\')){
            if(!(c=y[x.substring(a+2,b)])){a=b;continue;}
            d=x.substring(0,a)+c
            e=x.substring(b+1)
            a=d.length;
            x=d+e        
        }
        return x;
    },
    parse:function(link){
        var text = link.nodeValue
        if(text.indexOf('http://')==-1) return
                for(var m in this.media){
                    var m1 = m.split('|')
                    var z=m1.length
                    var found = false;
                    while(z--){
                        if(text.indexOf(m1[z])==-1) continue
                        var me = new RegExp(this.media[m].id.replace('/','\\/'),'gi')
                        var matches = []
                        if(!(matches = me.exec(text))) continue
                        var params ={}
                        for(var p in this.media[m].params){
                           
                           params[p] = this.insert_matches((this.media[m].params[p] + '').replace(/#\{vanilla\}/,this.base).replace(/#\{qwikpost\}/,this.xt),matches)
                        }
                        text = "<!--qp-->\n" + this.insert_params(this.type[this.media[m].params.type],params) + "\n<!--qp-->"
                        found = true;
                    }
                    if(found) break;
                }
                
        if(typeof link.outerHTML != 'undefined'){link.outerHTML=text; return;}
        
        var insert = document.createElement('div')
        insert.innerHTML=text;
        var nodes = insert.childNodes
        nl = nodes.length
        while(nl--)
                link.parentNode.insertBefore(nodes[nl],link.nextSibling)
        link.parentNode.removeChild(link)
    }
}