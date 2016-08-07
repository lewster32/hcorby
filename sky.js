Hoard.Sky = function(game) { };
Hoard.Sky.prototype = {
  create: function() {
    game.add.tileSprite(0, 0, game.world.width, game.world.height, 'sky').autoScroll(-5, 0);

    // create a group to keep all the objects in
    this.sky = game.add.group();

    this.skyPickups = game.add.group();

    // create a group for effects, such as flying objects
    this.effects = game.add.group();

    this.pickups = [];

    this.player = new Player(game, 40, 230, (playerData.gender === "male" ? "boy" : "girl"), this.sky);
    this.player.drag = 0.9;
    this.player.speed = 6;
    this.addPuffs(this.player);
    this.player.cloud = game.add.sprite(0, 6, 'sprites', 'cloud3');
    this.player.cloud.anchor.set(0.5, 1);
    this.player.addChild(this.player.cloud);
    this.player.body.bounce.set(1);

    this.game.add.tween(this.player.cloud).to({
      y: "+3"
    }, 700, Phaser.Easing.Quadratic.InOut, true, this.game.rnd.integerInRange(0, 500), Infinity, true).start();


    // create the ogre
    this.ogre = new Ogre(game, game.world.width - 15, 260, this.sky);
    this.ogre.cloud = game.add.sprite(0, 6, 'sprites', 'cloud3');
    this.ogre.cloud.anchor.set(0.5, 1);
    this.ogre.addChild(this.ogre.cloud);

    // create 8 of each type of pickup
    this.createPickups([10,2,1,2]);

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

    game.rnd.sow("ramona");

    this.clouds = this.createClouds(8, this.sky);

    // create the UI
    this.ui = game.add.group();
    this.ui.y = game.world.height - 48;
    this.ui.x = 8;
    
    this.pickupCounts = [];
    var pickupIcon, pickupCount;
    for (var p = 0; p < Pickup.NAME.length; p++) {
      pickupIcon = this.ui.create(64 * p, 0, 'pickups', p);
      pickupIcon.scale.set(2);
      
      pickupCount = game.add.text((64 * p) + 46, 8, "0", {
        font: "24px Georgia",
        fill: "#111111"
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
  update: function() {
    this.sky.sort('y', Phaser.Group.SORT_ASCENDING);

    var self = this;

    // check for overlaps between the player and the pickups
    game.physics.arcade.overlap(this.player, this.pickups, function(p, c) {
      // if we have an overlap, tell the player (p) to collect the pickup (c)
      p.collectPickup(c, this.pickupCounts, this.effects, this.totalPickups);
    }, null, this);

    // check for collisions between the player and the ogre
    game.physics.arcade.collide(this.player, this.ogre, function(p, o) {
      this.checkOgre(p, o);
    }, null, this);

    game.physics.arcade.collide(this.player, this.clouds);
  },
  render: function() {
    if (debug) {
      this.clouds.forEach(function(cloud) {
        game.debug.body(cloud,'rgba(0,255,0,0.2)', false);
      });
    }
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
    var locs = this.getValidLocations(3, 33, 2, 16);

    // if there are more objects than there are locations to put them, throw an error
    if (amounts.reduce(function(a, b) { return a + b; }) > locs.length) {
      throw new Error("Too many pickups for available area");
    }

    var pickup;

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
        pickup = new Pickup(game, posX, posY, this.sky, a);
        pickup.speed = 0.2 + ((posY / 300) * 0.5);
        pickup.update = function() {
          this.x -= this.speed;
          if (this.x < -40) {
            this.x = game.world.width + 40;
          }
        };
        this.pickups.push(pickup);
      }
    }
  },
  addPuffs: function(sprite) {
    var emitter = game.add.emitter(-8, 0, 6);
    emitter.makeParticles('puffs', [0, 1, 2]);
    emitter.setYSpeed(2, 16);
    emitter.setXSpeed(-15, 15);
    emitter.width = 52;
    emitter.minRotation = 0;
    emitter.maxRotation = 0;
    emitter.minScale = 1;
    emitter.maxScale = 1;
    emitter.gravity = 10;
    emitter.flow(1500, 200, 1, -1);
    sprite.bubbles = emitter;
    emitter.emitX = sprite.x;
    emitter.emitY = sprite.y - 64;
    emitter.offsetY = 0;
    return emitter;
  },
  createClouds: function(num, group) {
    var clouds = [], cloud;
    for (var i = 0; i < num; i++) {
      cloud = new Cloud(game, game.world.randomX, game.world.randomY, group, undefined);
      clouds.push(cloud);
    }
    return clouds;
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
          var level = "sky";
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
          game.state.start("Thanks");
          
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
game.state.add('Sky', Hoard.Sky);

var Cloud = function(game, x, y, group, type) {
  type = type || game.rnd.pick(["cloud1", "cloud2", "cloud3"]);
  Phaser.Sprite.call(this, game, x, y, 'sprites', type);
  this.game = game;
  this.anchor.set(0.5, 1);
  this.scale.set(game.rnd.pick([-1, 1]), 1);
  this.speed = game.rnd.realInRange(0.1, 0.5);
  group.add(this);

  this.game.physics.arcade.enable(this, Phaser.Physics.ARCADE);
  switch(type) {
    case "cloud1":
      this.body.setSize(128, 64);
      break;
    case "cloud2":
      this.body.setSize(90, 48);
      break;
    default:
      this.body.setSize(64, 16);
      break;
  }
  this.body.immovable = true;
  this.body.moves = false;
};


Cloud.prototype = Object.create(Phaser.Sprite.prototype);
Cloud.prototype.constructor = Cloud;

Cloud.prototype.update = function() {
  this.x -= this.speed;
  if (this.x < -200) {
    this.x = game.world.width + 200;
    this.y = game.world.randomY;
  }
};