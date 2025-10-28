# ProgServ2
Mise en place d'une application permettant de noter et commenter les jeux vidéos joués par ses utilisateurs.

Membres du groupe : Loann Juillerat, Elia Nicolo, Marike Platen
Thème : répertoire de jeux vidéos 
Langues : FR & ANG
Nom (provisoire mais stylé) : xxrepogameXx69

Fonctionnalités principales :

Pages publiques :
Deux 'états' : connecté (C) et non connecté (NC)
- C & NC : Homepage avec les jeux les plus populaires ("trending") du moment. Avec moyenne des notes.
- C & NC : Système de tri (catégorie, notes, studio, date de sortie, plateforme, age minimum)
- NC : Page d'inscription (pseudo, mot de passe, date de naissance, mail)
	- Avertissement si le pseudo et/ou le mail existe déjà
	- Avertissement si le mot de passe n'est pas suffisemment fort
- C & NC : Une page pour chaque jeu, avec catégorie, notes, commentaires, sortie, plateforme, age minimum...
- C : Possibilité de mettre une note et/ou un commentaire.

Pages privées :
- Liste de tous nos jeux + liste des jeux favoris
	- état des jeux (pas commencé, en cours (avec date de début), terminé avec date de fin)
- Ajouter un nouveau jeu
	- mettre l'état, une note (optionnelle en cas de jeu non-commencé),
- Paramètres du compte
	- changement de mot de passe (avec vérification), pseudo, mail, bio, genre, réseaux sociaux...
- Liste de souhaits
- Bouton 'se déconnecter'

Fonctionnalités optionnelles (si le temps le permet)
- C : Partager tes jeux (lien d'accès ?)
- C : Liste d'amis
- C & NC : Prix des jeux, en fonction des plateformes
- C : Lors de l'inscription, répondre à un petit questionnaire sur ses goûts personnels, et proposer des suggestions en + de la homepage. Homepage modifiée en fonction des goûts.




Compte rendu étapes de travail 

création des tables et db: 	(Elia) 
- utilisation de claude IA pour la vérification d'oubli et autre (code fait à la main et compris) 
