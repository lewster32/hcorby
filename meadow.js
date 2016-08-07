Hoard.Meadow = function(game) { };
Hoard.Meadow.prototype = {
  create: function() {
    game.add.tileSprite(0, 0, game.world.width, game.world.height, 'sprites', 'grass');

    this.shadows = game.add.physicsGroup();

    // create a group to keep all the objects in
    this.meadow = game.add.group();

    this.canopy = game.add.group();

    this.treePickups = game.add.group();

    // create a group for effects, such as flying objects
    this.effects = game.add.group();

    this.pickups = [];

    this.player = new Player(game, 40, 230, (playerData.gender === "male" ? "boy" : "girl"), this.meadow);

    // create the fences
    this.fence = [];
    this.fence.push(game.add.sprite(game.world.width - 10, -8, 'sprites', 'wood-fence', this.meadow));
    this.fence.push(game.add.sprite(game.world.width - 12, 80, 'sprites', 'wood-fence', this.meadow));
    this.fence.push(game.add.sprite(game.world.width - 10, 230, 'sprites', 'wood-fence', this.meadow));
    this.fence.push(game.add.sprite(game.world.width - 11, 300, 'sprites', 'wood-fence', this.meadow));
    this.fence.push(game.add.sprite(game.world.width - 10, 370, 'sprites', 'wood-fence', this.meadow));

    game.physics.arcade.enable(this.fence);

    this.fence.forEach(function(f) {
      f.body.immovable = true;
      f.body.moves = false;
    });

    // create the ogre
    this.ogre = new Ogre(game, game.world.width - 15, 240, this.meadow);

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

    game.rnd.sow("piggle");
    this.createTrees();

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
  update: function() {
    this.meadow.sort('y', Phaser.Group.SORT_ASCENDING);

    var self = this;

    game.physics.arcade.collide(this.player, this.trees, function(p, t) {
      if (p.body.deltaAbsX() > 0.2 || p.body.deltaAbsY() > 0.2) {
        t.bump(self.meadow);
      }
    });

    if (game.physics.arcade.overlap(this.player, this.shadows)) {
      this.player.tint = 0x999999;
    }
    else {
      this.player.tint = 0xffffff;
    }

    // check for overlaps between the player and the pickups
    game.physics.arcade.overlap(this.player, this.pickups, function(p, c) {
      // if we have an overlap, tell the player (p) to collect the pickup (c)
      p.collectPickup(c, this.pickupCounts, this.effects, this.totalPickups);
    }, null, this);

    // check for collisions between the player and the ogre
    game.physics.arcade.collide(this.player, this.ogre, function(p, o) {
      this.checkOgre(p, o);
    }, null, this);

    // check for collisions between the player and the fence
    game.physics.arcade.collide(this.player, this.fence);
  },
  render: function() {
    if (debug) {
      game.debug.body(this.trees[0],'rgba(255,0,0,0.2)', false);
      game.debug.body(this.shadows.children[0],'rgba(255,255,0,0.2)', false);
    }
  },
  createTrees: function() {
    this.trees = [];

    var tree;

    var treeData = [
      {type: "star", amount: 3},
      {type: "star", amount: 2},
      {type: "bow", amount: 3},
      {type: "moon", amount: 2},
      {type: "star", amount: 3},
      {type: "star", amount: 2},
    ];

    for (var t = 0, i = 120; i < game.world.width - 90; i += 240) {
      tree = new Tree(game, i + game.rnd.integerInRange(-30, 30), 140 + game.rnd.integerInRange(-30, 60), this.meadow, undefined, this.canopy, this.shadows, treeData[t].type, this.treePickups, this.pickups, treeData[t].amount);
      this.trees.push(tree);
      t++;

      tree = new Tree(game, i + game.rnd.integerInRange(-10, 50), 370 + game.rnd.integerInRange(-60, 30), this.meadow, undefined, this.canopy, this.shadows, treeData[t].type, this.treePickups, this.pickups, treeData[t].amount);
      this.trees.push(tree);
      t++;
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
          var level = "meadow";
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
          game.state.start("Countdown", true, false, "Sky");
          
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
game.state.add('Meadow', Hoard.Meadow);

var Tree = function(game, x, y, group, type, canopyGroup, shadowGroup, pickupType, pickupGroup, pickupArray, totalPickups, noRandom) {
  type = type || game.rnd.pick(["tree1", "tree2"]);
  Phaser.Sprite.call(this, game, x, y, 'sprites', type + "-trunk");
  this.game = game;
  this.anchor.set(0.5, 1);
  group.add(this);

  this.game.physics.arcade.enable(this, Phaser.Physics.ARCADE);
  this.body.setSize(22, 32, 0, 8);
  this.body.immovable = true;
  this.body.moves = false;

  this.pickupType = pickupType;

  this.canopyScale = 1;

  this.pickups = [];

  var spread = 30, pickup;

  for (var i = 0; i < (totalPickups || 4); i++) {
    pickup = new Pickup(game, x + (noRandom ? 0 : game.rnd.integerInRange(-spread, spread)), (y - 50) + game.rnd.integerInRange(-spread, spread), pickupGroup, Pickup.TYPE[this.pickupType]);
    pickup.shrubbery = game.add.sprite(pickup.x, pickup.y + game.rnd.integerInRange(-5, 0), 'sprites', 'shrubbery', pickupGroup);
    pickup.shrubbery.anchor.set(0.5);
    pickup.shrubbery.scale.set(game.rnd.pick([-1, 1]), game.rnd.pick([-1, 1]));
    pickup.pause();
    this.pickups.push(pickup);
    pickupArray.push(pickup);
  }

  // create the canopy
  if (canopyGroup) {
    this.canopy = canopyGroup.create(x, y - 12, 'sprites', type + '-canopy');
    this.canopy.anchor.set(0.5, 1);
    this.canopy.alpha = 0.9;
    this.canBump = true;
    // create a shadow
    if (shadowGroup) {
      this.shadow = shadowGroup.create(x + 5, y, 'sprites', 'tree-shadow');
      this.shadow.anchor.set(0.5);
      this.shadow.body.setSize(60, 30);
    }
  }
  else {
    this.canBump = false;
  }
};

Tree.prototype = Object.create(Phaser.Sprite.prototype);
Tree.prototype.constructor = Tree;

Tree.prototype.throwPickups = function(group, amount, noRandom) {
    var self = this, p;
    for (var i = 0; i < amount; i++) {
      if (this.pickups.length > 0) {
        (function(p) {
          game.add.tween(p.shrubbery).to({y: "40", alpha: 0}, 600, Phaser.Easing.Quadratic.In, true).onComplete.add(function() {
            p.shrubbery.destroy();
          }, this);
          game.add.tween(p).to({x: p.x + (noRandom ? 0 : game.rnd.integerInRange(-70, 70))}, 1300, null, true);
          var z = self.y + (noRandom ? 10 : game.rnd.integerInRange(10, 50));
          game.add.tween(p).to({y: "-90"}, 300, Phaser.Easing.Quadratic.Out, true).onComplete.add(function() {
            if (z < self.y) { group.add(p); }
            game.add.tween(p).to({y: z}, 1000, Phaser.Easing.Bounce.Out, true).onComplete.add(function() {
              group.add(p);
              p.play();        
            }, this);
          }, this);
        })(this.pickups.pop());
      }
    }
};

Tree.prototype.bump = function(group) {
  if (this.canBump) {
    this.canBump = false;

    if (this.pickups.length > 0) {
      this.canopyScale -= 0.05;
      if (this.canopyScale > 0) {
        this.canopy.scale.set(this.canopyScale);
      }
    }


    this.throwPickups(group, 1);

    this.canopy.angle = game.rnd.pick([-3, -2, 2, 3]);
    this.game.add.tween(this.canopy).to({
      angle: 0
    }, 300, Phaser.Easing.Elastic.Out, true)
      .onComplete.add(function() {
        this.canBump = true;
      }, this);
  }
};