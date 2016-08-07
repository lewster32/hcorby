Hoard.Dungeon = function(game) { };
Hoard.Dungeon.prototype = {
  create: function () {
    // create the floor first
    game.add.tileSprite(0, 0, game.world.width, game.world.height - 48, 'sprites', 'floor');

    // create a group to keep all the objects in
    this.dungeon = game.add.group();

    // create a group for effects, such as flying objects
    this.effects = game.add.group();

    // create the top and bottom walls, and the columns of walls with gaps
    this.createWalls();

    // create the player
    this.player = new Player(game, 80, 200, (playerData.gender === "male" ? "boy" : "girl"), this.dungeon);

    // seed the random number generator
    game.rnd.sow('lew');

    // create 12 of each type of pickup  ['star', 'button', 'moon', 'bow'];
    this.createPickups([10,2,2,1]);

    // create the ogre
    this.ogre = new Ogre(game, game.world.width - 5, 310, this.dungeon);

    // create the bubble
    this.ogre.bubble = game.add.sprite(-32, -64, 'sprites', 'bubble');
    this.ogre.bubble.anchor.set(0.5);
    this.ogre.addChild(this.ogre.bubble);
    var bubbleStar = game.add.sprite(-11, 0, 'pickups', 1 * Pickup.TYPE[this.ogre.requires]);
    bubbleStar.anchor.set(0.5);
    this.ogre.bubble.addChild(bubbleStar);

    var bubbleText = game.add.text(8, 2, "x" + this.ogre.amount, {
      font: "16px Georgia",
      fill: "#222222"
    });
    bubbleText.anchor.set(0.5);
    this.ogre.bubble.addChild(bubbleText);

    this.ogre.bubble.alpha = 0;
    
    // create the UI
    this.ui = game.add.group();
    this.ui.y = game.world.height - 48;
    this.ui.x = 8;

    this.ui.add(game.add.text(90, -15, "Backpack", {
      font: "15px Georgia",
      fill: "#ffffff"
    }));
    
    this.pickupCounts = [];
    var pickupIcon, pickupCount;
    for (var p = 0; p < Pickup.NAME.length; p++) {
      pickupIcon = this.ui.create(64 * p, 0, 'pickups', p);
      pickupIcon.scale.set(2);
      
      pickupCount = game.add.text((64 * p) + 46, 8, "0", {
        font: "24px Georgia",
        fill: "#ffffff"
      });
      this.ui.add(pickupCount);
      this.pickupCounts.push(pickupCount);
    }

    // add the previously picked up items to the player's backpack
    this.player.setPickups(totalPickups, this.pickupCounts);

    // this level's pickups
    this.totalPickups = {
      star: 0,
      button: 0,
      moon: 0,
      bow: 0
    };
  },
  update: function () {
    // sort all the objects by their y position, so objects lower on the screen are in front
    // of objects higher on the screen
    this.dungeon.sort('y', Phaser.Group.SORT_ASCENDING);

    // check for overlaps between the player and the pickups
    game.physics.arcade.overlap(this.player, this.pickups, function(p, c) {
      // if we have an overlap, tell the player (p) to collect the pickup (c)
      p.collectPickup(c, this.pickupCounts, this.effects, this.totalPickups);
    }, null, this);

    // check for collisions between the player and the walls
    game.physics.arcade.collide(this.player, this.walls);

    // check for collisions between the player and the ogre
    game.physics.arcade.collide(this.player, this.ogre, function(p, o) {
      this.checkOgre(p, o);
    }, null, this);
  },
  render: function () {
    if (debug) {
      game.debug.text(game.time.fps || '--', 2, 14, "#ff0");
      this.dungeon.forEach(function(s) {
        if (s.hasOwnProperty("body")) {
          game.debug.body(s, 'rgba(0,255,0,0.2)', true);
        }
      })
    }
  },
  createColumn: function(x, gapY, size) {
    var wall;

    // if not specified, make size default to 3 
    size = size || 3;

    var skip = false;

    // loop through each of our y positions (0-13)
    for (var y = 0; y < 14; y++) {
      // ensure the gap position is specified
      if (typeof gapY !== "undefined") {
        // if the gap is an array of positions...
        if (Array.isArray(gapY)) {
          // ... loop through that array...
          for (var g = 0; g < gapY.length; g++) {
            // ... and if our y position correlates with the gap position and size...
            if (y >= gapY[g] && y < gapY[g] + size) {
              // ... skip creating a wall section
              skip = true;
            }
          }
        }
        // if it isn't an array of positions, just check the one gap position and size...
        else if (y >= gapY && y < gapY + size) {
          // ... and skip creating a wall section if it correlates
          skip = true;
        }
      }
      // if our 'skip' flag has been set to true, skip this wall section and reset the flag
      // for the next loop
      if (skip) {
        skip = false;
        continue;
      }

      // if we've got this far, create a wall sprite, set it up and add it to the walls array
      wall = game.add.sprite(x, (y * 24) + 72, 'sprites', 'wall');
      game.physics.enable(wall, Phaser.Physics.ARCADE);
      wall.body.immovable = true;
      wall.body.moves = false;
      wall.anchor.set(0.5, 1);
      wall.body.setSize(24, 32, 0, 0);
      this.walls.push(wall);
    }
  },
  createWalls: function() {
    // create an array to hold our walls
    this.walls = [];

    // create the top and bottom walls and add them  to the walls array
    var northWall = game.add.tileSprite(0, 48, game.world.width, 48, 'sprites', 'wall');
    this.walls.push(northWall);
    var southWall = game.add.tileSprite(0, game.world.height - 40, game.world.width, 48, 'sprites', 'wall');
    this.walls.push(southWall);

    // enable physics on the top and bottom walls
    game.physics.enable([northWall, southWall], Phaser.Physics.ARCADE);

    // set the size of the collision boxes for the top and bottom walls
    northWall.body.setSize(game.world.width, 32, 0, 0);
    southWall.body.setSize(game.world.width, 32, 0, 0);

    // create the left-hand walls as an unbroken column
    this.createColumn(0);

    // define our gaps for the subsequent columns - a single number makes one gap, an array of
    // numbers makes several gaps; the number specifies where on the y axis the gap appears
    var gaps = [
      [2, 9],
      0,
      5,
      0,
      [2, 9],
      0,
      9
    ];

    // loop through our gaps array...
    for (var c = 0; c < gaps.length; c++) {
      // ..and create columns every (c + 1) * 120 pixels, with a gap size of 3 (we do c + 1
      // because the loop starts at 0, and 0 * 120 = 0)
      this.createColumn((c + 1) * 120, gaps[c], 3);
    }

    var self = this;

    // loop through all the walls we've created
    this.walls.forEach(function(wall) {
      wall.anchor.set(0, 1);

      // ensure the wall can't be moved
      wall.body.immovable = true;
      wall.body.moves = false;

      // add the wall to the 'dungeon' group so it can be visually sorted correctly
      self.dungeon.add(wall);
    });
  },
  getValidLocations: function(xmin, xmax, ymin, ymax) {
    // create an empty array of possible locations
    var locs = [];

    // loop through all of the possible x and y positions...
    for (var y = ymin; y <= ymax; y++) {
      for (var x = xmin; x <= xmax; x++) {
        // ... if the x position is not a factor of 5...
        if (x % 5 !== 0) {
          // ... add it to the locations array
          locs.push({x: x, y: y});
        }
      }
    }

    // once we're done, return the array filled with possible valid locations
    return locs;
  },
  // this function accepts an array of amounts - the position in the array of each amount
  // corresponding to the type/frame of the pickup
  createPickups: function(amounts) {
    var posX, posY, currentLoc;

    // create an empty array for the pickups
    this.pickups = [];

    // get an array of all possible locations for pickups
    var locs = this.getValidLocations(1, 34, 3, 15);

    // if there are more objects than there are locations to put them, throw an error
    if (amounts.reduce(function(a, b) { return a + b; }) > locs.length) {
      throw new Error("Too many pickups for available area");
    }

    // for each amount...
    for (var a = 0; a < amounts.length; a++) {
      // ... loop the amount number of times
      for (var i = 0; i < amounts[a]; i++) {

        // pick a location randomly and set it to the current location for this loop
        currentLoc = game.rnd.pick(locs);
        // remove the picked location from the array of available locations
        locs.splice(locs.indexOf(currentLoc), 1);

        // convert the current location into pixel coordinates
        posX = (currentLoc.x * 24) + 12;
        posY = (currentLoc.y * 24);

        // create a new pickup at the current location and add it to the array of pickups
        this.pickups.push(new Pickup(game, posX, posY, this.dungeon, a));
      }
    }
  },
  checkOgre: function(player, ogre) {
    // stop the player in their tracks
    player.body.velocity.setTo(0, 0);
    player.canMove = false;
    
    // do we have the right amount of items that the ogre requires?
    if (player.pickups.hasOwnProperty(ogre.requires) && player.pickups[ogre.requires] >= ogre.amount) {
      // prevent any further collisions
      ogre.body.enabled = player.body.enabled = false;
      
      // move the ogre off the screen to the right
      game.add.tween(ogre).to({x: "+80"}, 1000, Phaser.Easing.Quadratic.InOut, true, 500)
        .onComplete.add(function() {      
          // ...and destroy it when finished
          ogre.destroy();
        }, this);
      
      // move the player off the screen to the right about half a second after the ogre
      game.add.tween(player).to({x: "+80"}, 1000, Phaser.Easing.Quadratic.InOut, true, 1000)
        .onComplete.add(function() {
          var level = "dungeon";
          playerData.levels[level] = {
            // store the items collected
            pickups: this.totalPickups,
            instrumental: 0,
            novel: 0
          };
        
          // tally up the instrumental vs novel items        
          for (var p in this.totalPickups) {
            if (p === ogre.requires) {
              playerData.levels[level].instrumental += this.totalPickups[p];
            }
            else {
              playerData.levels[level].novel += this.totalPickups[p];
            }
          }
          
          // destroy the player sprite
          player.destroy();

          // subtract the required number of instrumental items
          totalPickups[ogre.requires] -= ogre.amount;
        
          // process the callback
          game.state.start("Countdown", true, false, "Underwater");
          
        }, this);
    }
    else {
      player.body.velocity.setTo(-600, game.rnd.integerInRange(-200, 200));
      player.canMove = true;
      ogre.bubble.alpha = 1;
      if (ogre.hasOwnProperty("tween")) {
        ogre.tween.stop();
      }
      ogre.tween = game.add.tween(ogre.bubble).to({alpha: 0}, 200, Phaser.Easing.Linear.None, true, 1000);
    }
  }
};
game.state.add('Dungeon', Hoard.Dungeon);