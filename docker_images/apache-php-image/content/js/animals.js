$(function(){
    function loadAnimals(){
	$.getJSON("/api/animals/", function( animals ){
		console.log(animals);
		var message = "No animals here";
		if(animals.length > 0) {
			message = animals[0].type + " " + animals[0].color;
		}
		$(".skills").text(message);
	});
};
	
loadAnimals();
setInterval(loadAnimals, 2000);
});
