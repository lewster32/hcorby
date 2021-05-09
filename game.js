var game = new Phaser.Game(864, 448, Phaser.AUTO, 'game', null, true, false);
var debug = false;

// the collected player data - presetting these will skip the relevant steps
var playerData = {
  age: null,
  gender: null,
  // Always use 'control' path
  path: 2,
  levels: {},
  code: null
};

var totalPickups = {
  star: 0,
  button: 0,
  moon: 0,
  bow: 0
};

var Hoard = function(game) { };

Hoard.Boot = function(game) { };
Hoard.Boot.prototype = {
  preload: function() {
    game.stage.disableVisibilityChange = true;


    // asset attribution
    // http://opengameart.org/content/old-frogatto-clouds-2
    // http://opengameart.org/content/lpc-tile-atlas
    // http://opengameart.org/content/lpc-sign-post    
    // http://opengameart.org/content/trees-bushes
    // http://opengameart.org/content/alternate-lpc-character-sprites-george
    // http://opengameart.org/content/one-more-lpc-alternate-character
    // http://opengameart.org/content/6-more-rpg-enemies

    // load our graphics
    game.load.spritesheet('bubbles', 'gfx/bubbles.png', 8, 8, 4);
    game.load.spritesheet('puffs', 'gfx/puffs.png', 8, 8, 4);
    game.load.atlas('sprites', 'gfx/atlas.png', 'gfx/atlas.json', Phaser.Loader.TEXTURE_ATLAS_JSON_HASH);
    game.load.image('sky', 'gfx/sky.png');
    game.load.spritesheet('underwater-rocks', 'gfx/underwater-rocks.png', 64, 64, 3);
    game.load.spritesheet('boy', 'gfx/boy.png', 48, 48, 16);
    game.load.spritesheet('girl', 'gfx/girl.png', 48, 48, 16);
    game.load.spritesheet('pickups', 'gfx/pickups.png', 24, 24, 16);
    game.physics.startSystem(Phaser.Physics.ARCADE);
  },
  create: function() {
    playerData.starttime = Date.now();
    game.state.start("Age");
  }
};
game.state.add('Boot', Hoard.Boot);

Hoard.Gender = function(game) { };
Hoard.Gender.prototype = {
  create: function() {
    if (playerData.gender === "male" || playerData.gender === "female") {
      this.nextState();
    }
    game.add.tileSprite(0, 0, game.world.width * 0.5, game.world.height * 0.5, 'sprites', 'floor').scale.set(2);

    game.add.text(game.world.centerX, 90, "Select your character", {
      font: "38px Georgia",
      fill: "#ffffff"
    }).anchor.set(0.5);

    this.boy = game.add.sprite(game.world.centerX - 100, game.world.centerY, 'boy');
    this.boy.scale.set(2);
    this.boy.anchor.set(0.5);

    this.girl = game.add.sprite(game.world.centerX + 100, game.world.centerY, 'girl');
    this.girl.scale.set(2);
    this.girl.anchor.set(0.5);

    this.boy.inputEnabled = this.girl.inputEnabled = true;
    this.boy.input.useHandCursor = this.girl.input.useHandCursor = true;
  },
  update: function() {
    this.boy.alpha = (this.boy.input.pointerOver() ? 1 : 0.5);
    this.girl.alpha = (this.girl.input.pointerOver() ? 1 : 0.5);

    if (game.input.activePointer.isDown) {
      if (this.boy.input.pointerOver()) {
        playerData.gender = 'male';
        this.nextState();
      }
      else if (this.girl.input.pointerOver()) {
        playerData.gender = 'female';
        this.nextState();
      }
    }
  },
  nextState: function() {
    game.state.start("Cue");
  }
};
game.state.add('Gender', Hoard.Gender);

Hoard.Cue = function(game) { };
Hoard.Cue.prototype = {
  create: function() {
    game.add.tileSprite(0, 0, game.world.width * 0.5, game.world.height * 0.5, 'sprites', 'floor').scale.set(2);

    var scrollTime, scrollText;

    if (playerData.path === 1) {
      scrollTime = Phaser.Timer.SECOND * 20;
      scrollText = "Very much like our own society, in Ogre World there is not enough to go around. The Ogre King has rationed medical supplies, fuel and all luxury goods.\n\nFearing things will only get worse, you have chosen to escape, but to get out you must pass through the four districts of Ogre World.\n\nOgres guard the gates between the districts of Ogre World. You will need to exchange 5 stars to pass through each gate.";
    }
    else {
      scrollTime = Phaser.Timer.SECOND * 6;
      scrollText = "Star World has 4 levels.\n\nTo pass each level, you'll need to pay the ogre 5 stars.";
    }
    
    var scroll = game.add.text(game.world.centerX, 190, scrollText, {
      font: "24px Georgia",
      fill: "#ffffff",
      align: "center",
      wordWrap: true,
      wordWrapWidth: 700
    });
    scroll.anchor.set(0.5);

    game.add.tween(scroll).from({y: 600}, scrollTime, Phaser.Easing.Linear.None, true).onComplete.add(function() {
      var cont = game.add.text(game.world.centerX, 390, "Click to continue ➞", {
        font: "24px Georgia",
        fill: "#94c8d7"
      });
      cont.anchor.set(0.5);
      game.add.tween(cont).to({alpha: 0.3}, 600, Phaser.Easing.Quadratic.InOut, true, 0, -1);
      game.add.tween(cont).from({x: -300}, 500, Phaser.Easing.Quadratic.Out, true);
      game.input.onDown.addOnce(function() {
        game.state.start("Countdown", true, false, "Dungeon");
      }, this);
    }, this);
  }
};
game.state.add('Cue', Hoard.Cue);

Hoard.Thanks = function(game) { };
Hoard.Thanks.prototype = {
  create: function() {
    var bg = game.add.tileSprite(0, 0, game.world.width * 0.5, game.world.height * 0.5, 'sprites', 'grass');
    bg.scale.set(2);
    bg.tint = 0x444444;
    bg.autoScroll(0, -20);

    var player = game.add.sprite(game.world.centerX, game.world.centerY + 40, (playerData.gender === "male" ? "boy" : "girl"));
    player.anchor.set(0.5);
    player.scale.set(2);
    player.animations.add('walk', [0, 4, 0, 12], 5, true);
    player.animations.play('walk');

    game.add.text(game.world.centerX, 60, "Congratulations, you completed the game!", {
      font: "32px Georgia",
      fill: "#ffffff"
    }).anchor.set(0.5);

    game.time.events.add(Phaser.Timer.SECOND * 2, function() {
      var cont = game.add.text(game.world.centerX, 390, "Click to continue ➞", {
        font: "24px Georgia",
        fill: "#94c8d7"
      });
      cont.anchor.set(0.5);
      game.add.tween(cont).to({alpha: 0.3}, 600, Phaser.Easing.Quadratic.InOut, true, 0, -1);
      game.add.tween(cont).from({x: -300}, 500, Phaser.Easing.Quadratic.Out, true);
      game.input.onDown.addOnce(function() {
        game.state.start("GameOver");
      }, this);
    }, this);
  }
};
game.state.add('Thanks', Hoard.Thanks);

Hoard.Countdown = function(game) { };
Hoard.Countdown.prototype = {
  init: function(nextState) {
    if (nextState && game.state.states[nextState]) {
      this.nextState = nextState;
    }
    else {
      this.nextState = "Dungeon";
    }
  },
  create: function() {
    var locomotion = "walk";
    var bg;
    if (this.nextState === "Sky") {
      locomotion = "float";
      bg = game.add.tileSprite(0, 0, game.world.width * 0.5, game.world.height * 0.5, 'sky');
      bg.scale.set(2)
      bg.autoScroll(-5, 0);
    }
    else if (this.nextState === "Meadow") {
      bg = game.add.tileSprite(0, 0, game.world.width * 0.5, game.world.height * 0.5, 'sprites', 'grass');
      bg.scale.set(2);
    }
    else if (this.nextState === "Underwater") {
      locomotion = "swim";
      bg = game.add.tileSprite(0, 0, game.world.width * 0.5, game.world.height * 0.5, 'sprites', 'underwater-floor');
      bg.scale.set(2);
    }
    else {
      bg = game.add.tileSprite(0, 0, game.world.width * 0.5, game.world.height * 0.5, 'sprites', 'floor');
      bg.scale.set(2);
    }

    bg.tint = 0x444444;

    this.animGroup = game.add.group();
    this.playAnims();

    game.add.text(game.world.centerX, 60, "Coming up next: " + this.nextState, {
      font: "35px Georgia",
      fill: "#ffffff"
    }).anchor.set(0.5);

    var helpText = "The ogres will only let you pass in exchange for 5 stars. Use arrow keys to move\nthrough the " + this.nextState + ". To collect items, simply " + locomotion + " into them and they will\nbe put in your backpack.";
    if (this.nextState === "Meadow") {
      helpText = "The ogres will only let you pass in exchange for 5 stars. Use arrow keys to move\nthrough the " + this.nextState + ". To collect items, knock them out of the trees by walking into\nthem, then walk over the item and they will be put in your backpack."
    }

    game.add.text(game.world.centerX, 340, helpText, {
      font: "21px Georgia",
      fill: "#94c8d7",
      align: 'center'
    }).anchor.set(0.5);

    this.showContinue(8000);
  },
  playAnims: function() {

    // create a group for all of this to happen
    var animGroup = this.animGroup;

    animGroup.alpha = 0;

    game.add.tween(animGroup).to({alpha: 1}, 500, Phaser.Easing.Linear.None, true);
    
    var ogre = game.add.sprite(game.world.width - 48, game.world.centerY, 'sprites', 'ogre', animGroup);
    ogre.scale.set(2);
    ogre.anchor.set(0.5);

    var treeGroup = game.add.group(animGroup);
    
    var player = game.add.sprite(48, game.world.centerY, (playerData.gender === "male" ? "boy" : "girl"), 0, animGroup);
    player.animations.add("walk-e", [3, 7, 3, 15], 5, true);
    player.animations.play("walk-e");
    player.scale.set(2);
    player.anchor.set(0.5);

    if (this.nextState === "Sky") {
      player.cloud = game.add.sprite(0, 30, 'sprites', 'cloud3', animGroup);
      player.cloud.anchor.set(0.5, 1);
      player.addChild(player.cloud);

      this.game.add.tween(player.cloud).to({
        y: "+3"
      }, 700, Phaser.Easing.Quadratic.InOut, true, this.game.rnd.integerInRange(0, 500), Infinity, true).start();

      ogre.cloud = game.add.sprite(0, 30, 'sprites', 'cloud3', animGroup);
      ogre.cloud.anchor.set(0.5, 1);
      ogre.addChild(ogre.cloud);
    }
    else if (this.nextState === "Underwater") {
      player.tint = ogre.tint = 0x64c5ff;
      player.bubbleMask = game.add.sprite(0, -2, 'sprites', 'mask', animGroup);
      player.bubbleMask.anchor.set(0.5);
      player.addChild(player.bubbleMask);

      ogre.bubbleMask = game.add.sprite(0, -25, 'sprites', 'mask', animGroup);
      ogre.bubbleMask.anchor.set(0.5);
      ogre.addChild(ogre.bubbleMask);
    }

    var star = game.add.sprite(game.world.centerX, game.world.centerY, 'pickups', 0, animGroup)
    star.animations.add("shine", [
      4,
      8,
      12,
      0, 0, 0, 0, 0, 0, 0, 0
    ], 10, true);
    star.animations.play("shine");
    star.scale.set(2);
    star.anchor.set(0.5);

    game.tweens.frameBased = true;

    var bubble = game.add.sprite(game.world.width - 128, game.world.centerY - 80, 'sprites', 'bubble', animGroup);
    bubble.anchor.set(0.5);
    bubble.scale.set(2);
    var bubbleStar = game.add.sprite(0, 0, 'pickups', 0, animGroup);
    bubbleStar.anchor.set(0.5);
    bubble.addChild(bubbleStar);

    game.add.tween(bubble).to({alpha: 0}, 200, Phaser.Easing.Linear.None, true, 2500);

    var treeCanopyGroup = game.add.group(animGroup);
    var treePickupGroup = game.add.group(animGroup);
    treeGroup.scale.set(2);
    treeCanopyGroup.scale.set(2);
    treePickupGroup.scale.set(2);

    if (this.nextState === "Meadow") {
      star.destroy();
      var tree = new Tree(game, game.world.centerX * 0.5, 120, treeGroup, undefined, treeCanopyGroup, null, "star", treePickupGroup, [], 1, true);

      game.add.tween(player).to({x: game.world.centerX - 64}, 1000, Phaser.Easing.Quadratic.In, true).onComplete.add(function() {

        tree.canopy.angle = game.rnd.pick([-3, -2, 2, 3]);
            this.game.add.tween(tree.canopy).to({
              angle: 0
            }, 300, Phaser.Easing.Elastic.Out, true);

        tree.throwPickups(treePickupGroup, 1, true);
        game.add.tween(player).to({x: "-50"}, 500, Phaser.Easing.Quadratic.Out, true).onComplete.add(function() {

          game.add.tween(player).to({x: game.world.width - 128}, 5000, Phaser.Easing.Quadratic.InOut, true).onComplete.add(function() {
            player.animations.currentAnim.stop(true);
            var ogreText;
            if (playerData.path === 1) {
              ogreText = "You haven't\ngot enough\nstars!";

            }
            else {
              ogreText = "You may pass...";
              game.add.tween(player).to({x: game.world.width + 32}, 2000, Phaser.Easing.Quadratic.In, true, 1500).onStart.add(function() {
                player.animations.play("walk-e");
              }, this);
              game.add.tween(ogre).to({y: "-30"}, 1500, Phaser.Easing.Quadratic.In, true,500);
            }

            bubbleStar.destroy();
            bubble.scale.set(3);
            bubble.x -= 20;
            bubble.y -= 20;

            var bubbleText = game.add.text(bubble.x - 2, bubble.y, ogreText, {
              font: "15px Georgia",
              fontWeight: "bold",
              fill: "#000000",
              align: "center"
            }, animGroup);
            bubbleText.lineSpacing = -5;
            bubbleText.anchor.set(0.5);

            game.add.tween(bubble).to({alpha: 1}, 200, Phaser.Easing.Linear.None, true);

          }, this);
          game.add.tween(treePickupGroup.children[0]).to({y: "-80", alpha: 0}, 500, Phaser.Easing.Quadratic.Out, true, 1300);

        }, this);
      }, this);
    }
    else {
      game.add.tween(player).to({x: game.world.width - 128}, 5000, Phaser.Easing.Quadratic.InOut, true).onComplete.add(function() {
        player.animations.currentAnim.stop(true);
        var ogreText;
        if (playerData.path === 1) {
          ogreText = "You haven't\ngot enough\nstars!";

        }
        else {
          ogreText = "You may pass...";
          game.add.tween(player).to({x: game.world.width + 32}, 2000, Phaser.Easing.Quadratic.In, true, 1500).onStart.add(function() {
            player.animations.play("walk-e");
          }, this);
          game.add.tween(ogre).to({y: "-30"}, 1500, Phaser.Easing.Quadratic.In, true,500);
        }

        bubbleStar.destroy();
        bubble.scale.set(3);
        bubble.x -= 20;
        bubble.y -= 20;

        var bubbleText = game.add.text(bubble.x - 2, bubble.y, ogreText, {
          font: "15px Georgia",
          fontWeight: "bold",
          fill: "#000000",
          align: "center"
        }, animGroup);
        bubbleText.lineSpacing = -5;
        bubbleText.anchor.set(0.5);

        game.add.tween(bubble).to({alpha: 1}, 200, Phaser.Easing.Linear.None, true);

      }, this);
      game.add.tween(star).to({y: "-80", alpha: 0}, 500, Phaser.Easing.Quadratic.Out, true, 2300);
    }

    game.time.events.add(Phaser.Timer.SECOND * 9, function() {
      game.add.tween(animGroup).to({alpha: 0}, 500, Phaser.Easing.Linear.None, true).onComplete.add(function() {
        animGroup.removeAll(true, true);
        this.playAnims();
      }, this);
    },this);
  },
  showContinue: function(delay) {
    var cont = game.add.text(game.world.centerX, 410, "Click to continue ➞", {
      font: "24px Georgia",
      fill: "#94c8d7"
    });
    cont.anchor.set(0.5);
    game.add.tween(cont).to({alpha: 0.3}, 600, Phaser.Easing.Quadratic.InOut, true, 0, -1);
    game.add.tween(cont).from({x: -300}, 500, Phaser.Easing.Quadratic.Out, true, delay).onComplete.add(function() {
      game.input.onDown.addOnce(function() {
        game.state.start(this.nextState);
      }, this);
    }, this);
  }
};
game.state.add('Countdown', Hoard.Countdown);

Hoard.Age = function(game) { };
Hoard.Age.prototype = {
  create: function() {
    if (this.isValidAge(playerData.age)) {
      this.nextState();
    }
    
    game.add.tileSprite(0, 0, game.world.width * 0.5, game.world.height * 0.5, 'sprites', 'floor').scale.set(2);

    game.add.text(game.world.centerX, 90, "How old are you?", {
      font: "38px Georgia",
      fill: "#ffffff"
    }).anchor.set(0.5);

    for (var a = 18; a < 121; a++) {
      $("#age").append('<option value="' + a + '">' + a + '</option>');
    }

    $("#ageform").show();
    
    var self = this;
    
    $("#age").focus().on("input click change keyup", function() {
      if (self.isValidAge($(this).val())) {
        $("#ageconfirm").addClass("enabled");
      }
      else {
        $("#ageconfirm").removeClass("enabled");
      }
    });
    
    $("#ageconfirm").on("click", function(e) {
      e.preventDefault();
      var age = self.isValidAge($("#age").val());
      if (age) {
        playerData.age = age;
        self.nextState();
      }
    });

    game.add.text(game.world.centerX, 320, "Select your age above then click '" + $("#ageconfirm").text() + "'.", {
      font: "24px Georgia",
      fill: "#94c8d7"
    }).anchor.set(0.5);
  },
  isValidAge: function(age) {
    age = parseInt(age, 10);
    var minAge = parseInt($("#age").prop("min"), 10) || 13;
    var maxAge = parseInt($("#age").prop("max"), 10) || 115;
    if (age && age >= minAge && age <= maxAge) {
      return age;
    }
    return false;
  },
  shutdown: function() {
    $("#ageform").remove();
  },
  nextState: function() {
    game.state.start("Gender");
  }
};
game.state.add('Age', Hoard.Age);

Hoard.GameOver = function(game) { };
Hoard.GameOver.prototype = {
  preload: function() {

  },
  create: function() {
    playerData.endtime = Date.now();
    this.submitResults(this.debrief, this);
  },
  createCookie: function() {
    // Only set the cookie if single play is enabled
    if (singlePlay) {
      var date = new Date();
      date.setTime(2147485547000);
      document.cookie = "hstudy=1; expires=" + date.toGMTString() + "; path=/";
    }
  },
  debrief: function() {
    this.createCookie();
    $("#game").hide();
    $("#debrief").show();
  },
  submitResults: function(callback, context) {
    $.ajax("submitresults.php", {
      data: playerData,
      dataType: 'json',
      success: function(data) {
        if (data.success === true) {
          if (callback) {
            callback.call(context || this);
          }
        }
        else {
          alert("Submission error. Please contact " + adminEmail + " quoting the following message: '" + data.error + "'. The game will now restart.");
          window.location.reload();
        }
      },
      error: function(xhr, status, err) {
        alert("Problem connecting to the server. Please contact " + adminEmail + " quoting the following message: '" + status + " - " + err + "'. The game will now restart.");
        window.location.reload();
      }
    });
  },
  submitEmail: function(callback, context) {
    $("#message").removeClass("error").hide();
    $.ajax("submitemail.php", {
      data: {
        email: encodeURIComponent($("#email").val().replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, ""))
      },
      dataType: 'json',
      success: function(data) {
        if (data.success) {
          if (callback) {
            callback.call(context || this);
          }
        }
        else {
          $("#message").text("Error: " + data.error).addClass("error").show();
          $("#debrief button").addClass("enabled");
        }
      },
      error: function(xhr, status, err) {
        $("#message")
          .html('Sorry, there was an error (' + status + ' - ' + err + '). Please contact <a href="' + adminEmail + '?subject=Game%20error&body=Error%20' + encodeURIComponent(status) + '%20-%20' + encodeURIComponent(err) + '">' + adminEmail + '</a>')
          .addClass("error").show();
        $("#debrief button").addClass("enabled");
      }
    });
  }
};
game.state.add('GameOver', Hoard.GameOver);

var Ogre = function(game, x, y, group, requires, amount) {
  Phaser.Sprite.call(this, game, x, y, 'sprites', 'ogre');
  this.game = game;
  this.anchor.set(0.5, 1);
  group.add(this);

  this.game.physics.arcade.enable(this, Phaser.Physics.ARCADE);
  this.body.setSize(28, 64, 0, 18);
  this.body.immovable = true;
  this.body.moves = false;
  
  // what does this ogre require? (instrumental pickup)
  this.requires = requires || "star";
  this.amount = amount || 5;
};

Ogre.prototype = Object.create(Phaser.Sprite.prototype);
Ogre.prototype.constructor = Ogre;

// Pickup
var Pickup = function(game, x, y, group, type) {
  Phaser.Sprite.call(this, game, x, y, 'pickups');
  this.game = game;
  this.anchor.set(0.5, 1);
  group.add(this);

  this.game.physics.arcade.enable(this, Phaser.Physics.ARCADE);
  this.body.setSize(16, 12, 0, 0);

  // flip the sprite left or right randomly
  this.scale.set(Math.random() < 0.5 ? -1 : 1, 1);

  // make the pickup bob up and down
  this.bob = this.game.add.tween(this).to({
    y: this.y - 3
  }, 500, Phaser.Easing.Quadratic.InOut, true, this.game.rnd.integerInRange(0, 500), Infinity, true).start();

  // set the frame to the pickup type, or default to 0 if not set
  this.type = type || 0;

  // set up our shiny animation
  this.shineAnim = this.animations.add("shine", [
    4 + this.type,
    8 + this.type,
    12 + this.type,
    0 + this.type
  ], 15, false);

  // play the animation
  this.animations.play("shine");

  // when the animation completes...
  this.shineAnim.onComplete.add(function() {
    // ... create a timed event to happen 250-3000 miliseconds in the future...
    this.game.time.events.add(this.game.rnd.integerInRange(250, 3000), function() {
      // ... to play the animation again
      this.animations.play("shine"); 
    }, this);
  }, this);
};

Pickup.prototype = Object.create(Phaser.Sprite.prototype);
Pickup.prototype.constructor = Pickup;

Pickup.prototype.pause = function() {
  this.animations.currentAnim.stop();
  this.bob.stop();
  this.body.enable = false;
};

Pickup.prototype.play = function() {
  this.animations.currentAnim.play();
  this.bob = this.game.add.tween(this).to({
    y: this.y - 3
  }, 500, Phaser.Easing.Quadratic.InOut, true, this.game.rnd.integerInRange(0, 500), Infinity, true).start();
  this.body.enable = true;
};

Pickup.TYPE = {
  star: 0,
  button: 1,
  moon: 2,
  bow: 3
};

Pickup.NAME = ['star', 'button', 'moon', 'bow'];


// Player
var Player = function(game, x, y, sprite, group) {
  // the player's collection of pickups
  this.pickups = {};
  for (var n in Pickup.TYPE) {
    this.pickups[n] = 0;
  }

  // how far has the player travelled
  this.distanceTravelled = 0;

  // sprite stuff - if a sprite name is not specified, randomly pick a boy or a girl
  Phaser.Sprite.call(this, game, x, y, sprite || game.rnd.pick['boy', 'girl']);

  this.game = game;
  group.add(this);
  this.anchor.set(0.5, 1);

  this.game.physics.arcade.enable(this, Phaser.Physics.ARCADE);
  this.body.setSize(24, 16, 0, 0);
  this.body.collideWorldBounds = true;

  this.canMove = true;
  this.cursors = this.game.input.keyboard.createCursorKeys();

  var walkSpeed = 10;
  this.animations.add("walk-s", [0, 4, 0, 12], walkSpeed, true);
  this.animations.add("walk-w", [1, 5, 1, 13], walkSpeed, true);
  this.animations.add("walk-n", [2, 6, 2, 14], walkSpeed, true);
  this.animations.add("walk-e", [3, 7, 3, 15], walkSpeed, true);

  var idleSpeed = 1.6;
  this.animations.add("idle-s", [0, 4, 0, 12], idleSpeed, true);
  this.animations.add("idle-w", [1, 5, 1, 13], idleSpeed, true);
  this.animations.add("idle-n", [2, 6, 2, 14], idleSpeed, true);
  this.animations.add("idle-e", [3, 7, 3, 15], idleSpeed, true);

  this.speed = 60;
  this.drag = 0.5;
  
  this.direction = "s";
}

Player.prototype = Object.create(Phaser.Sprite.prototype);
Player.prototype.constructor = Player;

Player.prototype.update = function() {
  // check for keys being pressed and move the player accordingly
  if (this.canMove) {
    this.doInputs();
  }

  // check if the player is moving and in which direction, and show the appropriate animation
  this.doAnimations();

  if (this.hasOwnProperty("bubbles")) {
    this.bubbles.emitX = this.x;
    this.bubbles.emitY = this.y + this.bubbles.offsetY;
  }
};

Player.prototype.doInputs = function() {
  this.body.velocity.x *= this.drag;
  this.body.velocity.y *= this.drag;

  // vertical
  if (this.cursors.up.isDown) {
    this.body.velocity.y += this.speed * -1;
    this.direction = "n";
  }
  else if (this.cursors.down.isDown) {
    this.body.velocity.y += this.speed;
    this.direction = "s";
  }
  // horizontal
  if (this.cursors.left.isDown) {
    this.body.velocity.x += this.speed * -1;
    this.direction = "w";
  }
  else if (this.cursors.right.isDown) {
    this.body.velocity.x += this.speed;
    this.direction = "e";
  }

  this.distanceTravelled += (this.body.deltaAbsX() + this.body.deltaAbsY()) << 0;
};

Player.prototype.doAnimations = function() {
  // set a threshold above which the player would be considered to be moving
  var threshold = 1.5;

  // if we're below the threshold, play the idle animation...
  if (Math.abs(this.body.velocity.x) < threshold && Math.abs(this.body.velocity.y) < threshold) {
    this.animations.play('idle-' + this.direction);
  }
  // ... otherwise play the walking animation
  else {
    this.animations.play('walk-' + this.direction);
  }
};

Player.prototype.setPickups = function(pickups, pickupCounts) {
  for (var p in pickups) {
    this.pickups[p] = pickups[p];
    var type = Pickup.TYPE[p];
    pickupCounts[type].setText(pickups[p]);
  }
};

Player.prototype.collectPickup = function(pickup, pickupCounts, effects, levelPickups) {
  // turn off collisions with this pickup
  pickup.body.enable = false;
  effects.add(pickup);
  // tween the pickup off the screen
  game.add.tween(pickup).to({ x: (64 * pickup.type) + 20, y: game.world.height - 24}, 300, Phaser.Easing.Quadratic.In, true)
    .onComplete.add(function() {
      // remove the specified pickup from the world
      pickup.destroy();
    
      // update the UI
      pickupCounts[pickup.type].setText(parseInt(pickupCounts[pickup.type].text, 10) +1);
    }, this);
  

  // increase the player's pickup amount of this type by 1
  var pickupName = Pickup.NAME[pickup.type];
  this.pickups[pickupName]++;

  // increment total pickups
  totalPickups[pickupName]++;

  // increment level pickups
  levelPickups[pickupName]++;
};

$(function() {  
  $("#code").on("input keyup click", function() {
    if ($("#code").val().trim().length > 0) {
      $("#confirm button").addClass("enabled");
    }
    else {
      $("#confirm button").removeClass("enabled");
    }
    $("#confirm button").one("click", function(e) {
      e.preventDefault();
      if ($(this).hasClass("enabled")) {
        playerData.code = $("#code").val().trim();
        setTimeout(function() {
          $("#confirm").remove();
          game.state.start("Boot");
        }, 10);
      }
    });
  });
});