var spookybuilder = require('./SpookyInit.js'),
express = require('express'),
age = process.argv[2],
username = process.argv[3],
password = process.argv[4],
email = process.argv[5],
solution = process.argv[6],
ip = process.argv[7],
port = process.argv[8];
if(ip)spookybuilder.setProxy(ip,port);
var spooky = spookybuilder.build(function(err){
    spooky.userAgent('Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');
	spooky.start("https://secure.runescape.com/m=account-creation/l=2/g=oldscape/create_account");
	spooky.thenEvaluate(function(age,username,password,email,solution){
		document.getElementById("age").value = age;
		document.getElementById("charactername").value = username;
		document.getElementById("email1").value = email;
		document.getElementById("password1").value = password;
		document.getElementById("password2").value = password;
		document.getElementById("g-recaptcha-response").innerHTML = solution;
		document.getElementById("submit").click();
	},{age:age,username:username,password:password,email:email,solution:solution});
	spooky.waitForSelector(".account-box__download",function(){
		this.emit("success");
		this.emit("done");
	},function(){
		this.emit("fail",this.evaluate(function(){
			var formerror = document.getElementsByClassName("account-form__error");
			if(formerror.length==0){
				formerror = document.querySelector("[data-error]");
				return formerror.getAttribute("data-error");
			}
			return formerror[0].innerHTML;
		}));
		this.emit("done");
	});
	spooky.run();
});
spooky.on("success",function(){
	var status = {status:"success"};
	console.log(JSON.stringify(status));
});
spooky.on("fail",function(error){
	var status = {status:"fail",error:error};
	console.log(JSON.stringify(status));
});
spooky.on('done',function(){
	process.exit();
});

spooky.on('console', function (line) {
	//console.log(line);
});