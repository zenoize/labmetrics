const path = require('path'),
	_ = require('underscore');
module.exports = {
	build:function(init_func) {
		/*var	env = _.clone(process.env),
			envPath = env.PATH || env.Path,
			binDir = path.join(__dirname, './../../node_modules/.bin'),
			Spooky = require('spooky');
		env.PATH = env.Path = `${envPath};${binDir}`,*/
		var ipport = "";
		
		try {
			var Spooky = require('spooky');
		} catch (e) {
			var Spooky = require('../lib/spooky');
		}
		var spooky = new Spooky({
			child: {
				proxy:ipport,
				//detached: true,
				//stdio: [ 'ignore', out, err ],
				//command: /^win/.test(process.platform) ? 'casperjs.cmd' : 'casperjs',
				transport: 'http'/*,
				spawnOptions: {
					env: env
				}*/
			},
			casper: {
				logLevel: 'debug',
				verbose: true
			}
		},init_func);
		
		spooky.on('error', function(e, stack) {
			console.error(e);
			if (stack) {
				console.log(stack);
			}
		});
		return spooky;
	},
	setProxy(ip,port){
		ipport = ip+":"+port;
	}
}