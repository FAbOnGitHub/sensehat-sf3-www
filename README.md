# SENSORS


## Projet 

Le but est de jouer avec un Raspberry Pi, une carte SenseHat ainsi que quelques
technos (Python, PHP/Symfony, notions d'API REST)

Le projet est aussi né du besoin de mesurer en continuer le taux d'humidité de
l'air de certaines pièces. Le Raspberry et la SenseHat sont très abordables.

### Documenation

*  [Astro-Pi Challenge](https://www.raspberrypi.org/blog/announcing-2017-18-astro-pi/)
*  [Sense HAT, un tour dans les étoiles](https://www.framboise314.fr/sense-hat-un-tour-dans-les-etoiles/)
*  [Prise en main du Sense HAT (au CNES)](https://proxima.cnes.fr/sites/default/files/drupal/201612/default/prx_meet_the_sense_hat_23_11_fr.pdf)
* [The possibilities of the Sense HAT](https://www.raspberrypi.org/blog/sense-hat-projects/)

### Technologies testées

-  Symfony 3.4 (optique Symfony 4 + webpack)
-  API Rest (FOSRestBundle et autes)
Composants :
-  Bootstrap theme : [grayscale](https://startbootstrap.com/template-overviews/grayscale/)
-  Graphiques [Highcharts](https://www.highcharts.com/)

### Matériels

*  Raspberry 3 B+ : entre 40 et 50 suivant les kits
*  [Carte SenseHat (chez Kubii)](https://www.kubii.fr/cartes-extension-cameras-raspberry-pi/1081-raspberry-pi-sense-hat-kubii-640522710799.html)  environ 40€

### Road Map

Initialisation
*  [X] Tester et aquérir des données

DÉMO v1
  *  [X] Mettre des données en lignes
  *  [ ] Restreindre la plage temporelle d'accès
  *  [ ] Faire les corrections (IHM)

Maturation
*  [ ] Expertiser les données et voir le besoin en terme de correction

DÉMO v2
  -  [ ] Améliorer script de collecte
  -  [ ] Faire une observation live (NRT)
  -  [ ] Activer la partie multi-sites / catpeurs
  -  [ ] Faire une interface d'administration
    - [X] CRUD
    - [ ] Admin 

DÉMO v3
  * [ ] Migrer en Symfony 4
  * [ ] Introduire Vue Js

## Projets annexes

*  La partie embarquée (Python)
*  Une prochaine version en Symfony 4
