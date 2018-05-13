var Chance = require("chance");
var chance = new Chance();

const express = require('express')
const app = express()

function generateAnimals(){
	var nbr = chance.integer({
		min:5,
		max:15
	});

	console.log("Nbr animals : " + nbr);

	var animals = [];
	for (var i = 0; i < nbr; i++) {
		var gender = chance.gender();
		var color = chance.color();
		var type = chance.animal();

		animals.push({
			type : type,
			color : color,
			gender : gender,
			birthday : chance.integer({
				min:1,
				max:20
			})
		});
	};

	return animals;
}

app.get('/', function (req, res) {
  res.send(generateAnimals());
})

app.listen(3000, function () {
  console.log('Accepting request on port 3000!')
})