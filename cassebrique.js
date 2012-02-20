
	var NBLIGNES = 10;
	var NBCOLONNES = 7;
	var FENLARGEUR;
	var FENHAUTEUR;
	var BRIQUE_L;
	var BRIQUE_H = 20;
	var RAQUETTE_L = 300;
	var RAQUETTE_H = 10;
	var TAILLE_BALLE = 10;
	var VITESSE_BALLE = 10;
	
	var raquetteX; /* Ne devraient pas etre globales */
	var raquetteY;
	var balleX;
	var balleY;
	var dirBalleX = 1;
	var dirBalleY = 1;
	var nbBriquesRestantes = NBLIGNES * NBCOLONNES;
	var tabBriques;
	
window.addEventListener('load', function() {

	// On récupère l'objet canvas
	var canvas = document.getElementById('canvasElem');
	// On récupère le contexte 2D
	var context = canvas.getContext('2d');
	
	FENLARGEUR = canvas.width;
	FENHAUTEUR = canvas.height;
	BRIQUE_L = (canvas.width-4)/NBLIGNES;
	
	raquetteX = (canvas.width/2) - (RAQUETTE_L/2);
	raquetteY = canvas.height - RAQUETTE_H;

	balleX = raquetteX + RAQUETTE_L/2;
	balleY = FENHAUTEUR - RAQUETTE_H*2;
	
	initTabBriques();
		
	dessineBriques(context);
	dessineRaquette(context, raquetteX, raquetteY);
	
	boucleJeu = setInterval(function() {dessineEcran(context, raquetteX, raquetteY);}, 20);
	
	// Gestion des évènements
	window.document.onkeydown = gereEvent;
	
}, false);	

function dessineEcran(context, raquetteX, raquetteY) {
	context.clearRect(0, 0, FENLARGEUR, FENHAUTEUR);
	dessineBriques(context);
	dessineRaquette(context, raquetteX, raquetteY);
	dessineBalle(context, balleX, balleY);
	
	if (balleX <= 0)
		dirBalleX *= -1;
	if (balleX + TAILLE_BALLE/2 >= FENLARGEUR)
		dirBalleX *= -1;
	if (balleY <= 0)
		dirBalleY = 1;
	if (balleY + TAILLE_BALLE/2 >= FENHAUTEUR)
		perdu();
	else if (balleY >= raquetteY && balleX < raquetteX + RAQUETTE_L && balleX > raquetteX) {
		dirBalleY = -1;
		dirBalleX = 2 * (balleX - (raquetteX + RAQUETTE_L/2)) / RAQUETTE_L;
	}
		
	if (balleY <= NBLIGNES * BRIQUE_H) {
		var ligne = Math.floor(balleY / BRIQUE_H);
		var colonne = Math.floor(balleX / BRIQUE_L);
		if (colonne != -1 && colonne != NBCOLONNES+1 && tabBriques[colonne][ligne] == 1) {
			tabBriques[colonne][ligne] = 0;
			dirBalleY = 1;
			nbBriquesRestantes--;
		}
	}
	
	if (nbBriquesRestantes == 0)
		gagne();
		
	balleX += dirBalleX * VITESSE_BALLE;
	balleY += dirBalleY * VITESSE_BALLE;
	
}
		
function gagne() {
	clearInterval(boucleJeu);
	alert("Gagné !");
}

function perdu() {
	clearInterval(boucleJeu);
	alert("Perdu !");
}
	
function dessineBalle(ctx, X, Y) {
	ctx.fillStyle = "blue";
	ctx.beginPath();
	ctx.arc(X, Y, TAILLE_BALLE, 0, Math.PI*2, true);
	ctx.closePath();
	ctx.fill();
}
		
function gereEvent(e) {
	
	// Flêche de droite préssée
	if (e.keyCode == 39 && raquetteX + RAQUETTE_L < FENLARGEUR)
		raquetteX += 10;
	// Flêche de gauche préssée
	else if (e.keyCode == 37 && raquetteX > 0)
		raquetteX -= 10;
}

function dessineRaquette(ctx, x, y) {

	ctx.fillStyle = "black";
	ctx.fillRect(x, y, RAQUETTE_L, RAQUETTE_H);
	
	return 1;
}

function dessineBriques(ctx) {
	
	ctx.fillStyle = "red";
	for (var i=0 ; i<NBLIGNES; i++) 
	
		for (var j=0 ; j<NBCOLONNES ; j++)
		
			if (tabBriques[i][j] == 1)
				ctx.fillRect(i*BRIQUE_L+2, j*BRIQUE_H+2, BRIQUE_L-2, BRIQUE_H-2);
	
	return 1;
}

function initTabBriques() {
	tabBriques = new Array(NBLIGNES);
	for (var i=0 ; i<NBLIGNES; i++) {
	
		tabBriques[i] = new Array(NBCOLONNES);
		
		for (var j=0 ; j<NBCOLONNES ; j++)
			tabBriques[i][j] = 1;
			
	}
	
	return 1;
}
