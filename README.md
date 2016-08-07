# D.H. Corby - Study on the Effects of Resource Scarcity Cues on Hoarding Behaviour

## Requirements

This study requires the following:
* A PHP-enabled web server *(developed on an Apache server running PHP Version 5.6.19)*

## Installation
Edit `config.php` to set your results password, filenames and environment values. Picking difficult to guess values for these will improve security by making it difficult to gain access to results data. A more comprehensive security system involving access control etc. has been eschewed for brevity and ease of deployment - *please do customise your version to use more advanced security measures as appropriate for your intended usage*.

The pseudo-random number generator seed used to generate each level can be set in the individual level `.js` files (`dungeon.js`, `underwater.js`, `meadow.js` and `sky.js`). Look for the line contaning `game.rnd.sow` and change the string to whatever you wish. 

## Usage
Visitors will reach the index page whereby they will be able to take part in the study. Upon completion of the game and subsequent questionnaires, their results will be submitted and a cookie will be set to help limit their participation to once per browser *(N.B: no further checks will be made for multiple submissions, though IP addresses will be logged in the submission data)*.

The visitor will get a further prompt upon results submission to submit an email address to enter a prize draw, and if the visitor wishes to participate, this info will be stored in a separate datafile.

At any time, a simplified list of the results can be viewed by directing the browser to `/view-results.php?p=<your password>`.

CSV formatted versions of the results and emails can be downloaded by directing the browser to `/csv-results.php?p=<your password>` and `/csv-emails.php?p=<your password>` respectively.

## Known bugs
* Some visitors (~15%) did not appear to be presented with all three questionnaires. This was not noticed until the study was underway, and so rather than change the code mid-study, a method for determining 'bugged' results was added to the `view-results.php` file.

## Acknowledgements

Uses the following graphical assets from [opengameart.org](http://opengameart.org):
* http://opengameart.org/content/old-frogatto-clouds-2 by [Guido Bos](http://neoriceisgood.deviantart.com/) (CC0)
* http://opengameart.org/content/lpc-tile-atlas (CC-BY-SA 3.0, GPL 3.0)
* http://opengameart.org/content/lpc-sign-post by [Nemisys](http://opengameart.org/users/nemisys) (CC-BY 3.0, CC-BY-SA 3.0, GPL 3.0, OGA-BY 3.0)
* http://opengameart.org/content/trees-bushes by [ansimuz](http://opengameart.org/users/ansimuz) (CC0)
* http://opengameart.org/content/alternate-lpc-character-sprites-george by [sheep](http://opengameart.org/users/sheep) (CC-BY 3.0, CC-BY-SA 3.0, GPL 3.0)
* http://opengameart.org/content/one-more-lpc-alternate-character by [Radomir Dopieralski](http://sheep.art.pl/) (CC-BY-SA 3.0, GPL 3.0)
* http://opengameart.org/content/6-more-rpg-enemies by [Redshrike](http://opengameart.org/users/redshrike) (CC-BY 3.0, OGA-BY 3.0)

Built upon the [Phaser 2.4.4](http://phaser.io) JavaScript framework ([github repository](https://github.com/photonstorm/phaser)).

Makes use of the [jQuery 1.12.0](http://jquery.com) JavaScript framework.

## MIT License
----

Copyright (c) 2016 L. Lane and D.H. Corby

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

## Attribution
---
### LPC Tile Atlas

License
-------

CC-BY-SA 3.0:
 - http://creativecommons.org/licenses/by-sa/3.0/
 - See the file: cc-by-sa-3.0.txt
GNU GPL 3.0:
 - http://www.gnu.org/licenses/gpl-3.0.html
 - See the file: gpl-3.0.txt

Note the file is based on the LCP contest readme so don't expect the exact little pieces used like the base one.
*Additional license information.

Assets from:

LPC participants:
----------------

Casper Nilsson
	*GNU GPL 3.0 or later
	email: casper.nilsson@gmail.com
	Freenode: CasperN
	OpenGameArt.org: C.Nilsson
	
 - LPC C.Nilsson (2D art)

Daniel Eddeland 
	*GNU GPL 3.0 or later
 - Tilesets of plants, props, food and environments, suitable for farming / fishing sims and other games. 
 - Includes wheat, grass, sand tilesets, fence tilesets and plants such as corn and tomato. 


Johann CHARLOT 
	*GNU LGPL Version 3. 
	*Later versions are permitted.
	Homepage  http://poufpoufproduction.fr
	Email     johannc@poufpoufproduction.fr
	
 - Shoot'em up graphic kit

Skyler Robert Colladay 

 - FeralFantom's Entry (2D art)

BASE assets:
------------

Lanea Zimmerman (AKA Sharm)
------------

 - barrel.png
 - brackish.png
 - buckets.png
 - bridges.png
 - cabinets.png
 - cement.png
 - cementstair.png
 - chests.png
 - country.png
 - cup.png
 - dirt2.png
 - dirt.png
 - dungeon.png
 - grassalt.png
 - grass.png
 - holek.png
 - holemid.png
 - hole.png
 - house.png
 - inside.png
 - kitchen.png
 - lava.png
 - lavarock.png
 - mountains.png
 - rock.png
 - shadow.png
 - signs.png
 - stairs.png
 - treetop.png
 - trunk.png
 - waterfall.png
 - watergrass.png
 - water.png
 - princess.png and princess.xcf


Stephen Challener (AKA Redshrike)
------------

 - female_walkcycle.png
 - female_hurt.png
 - female_slash.png
 - female_spellcast.png
 - male_walkcycle.png
 - male_hurt.png
 - male_slash.png
 - male_spellcast.png
 - male_pants.png
 - male_hurt_pants.png
 - male_fall_down_pants.png
 - male_slash_pants.png


Charles Sanchez (AKA CharlesGabriel)
------------

 - bat.png
 - bee.png
 - big_worm.png
 - eyeball.png
 - ghost.png
 - man_eater_flower.png
 - pumpking.png
 - slime.png
 - small_worm.png
 - snake.png


Manuel Riecke (AKA MrBeast)
------------

 - hairfemale.png and hairfemale.xcf
 - hairmale.png and hairmale.xcf
 - soldier.png
 - soldier_altcolor.png


Daniel Armstrong (AKA HughSpectrum)
------------

Castle work:

 - castlewalls.png
 - castlefloors.png
 - castle_outside.png
 - castlefloors_outside.png
 - castle_lightsources.png

### 6 More RPG Enemies

Stephen Challener (Redshrike, Blarumyrran and LordNeo, hosted by OpenGameArt.org)
