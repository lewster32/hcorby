<?php 
  require_once("config.php");
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8" />
<head>
  <title>Study</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <?php
    if (isset($_COOKIE['hstudy'])) {
  ?>
  <div id="debrief">
    <h1>Thank you for playing!</h1>
  </div>
  <?php } else { ?>
<div id="confirm">
  <h1>Study Information and Consent</h1>
  <p>The study will consist of a short four-level single player game, followed by 3 short questionnaires. It should take no longer than 20 minutes to complete.</p>
  <p>You can withdraw from the study at any time, and your data will not be recorded (simply by closing your browser window). The data from the study will be analysed as part of my dissertation project to produce a report, but no individual players' data will be identified.</p>
  <p>To participate in the study you must be 18 years old or over, and live in the UK.</p>
  <p><label for="age"><input type="checkbox" id="age" /> I confirm I am 18 years old or over</label></p>
  <p><label for="uk"><input type="checkbox" id="uk" /> I confirm I live in the UK</label></p>
  <p><label for="consent"><input type="checkbox" id="consent" /> I consent to participating in the study</label></p>
  <p style="text-align: center"><button>Continue</button></p>
</div>
<div id="ageform" style="display: none">
  <select id="age">
    <option value="" disabled selected>Age</option>
  </select>
  <button id="ageconfirm" />Continue</button>
</div>
<div id="game"></div>
<div id="questionnaires" style="display: none">
  <h1>Questionnaires - <span id="questionnaire-page">1 of 4</span></h2>
  
  <div id="meta" class="questionnaire" style="display: none">
    <p>Please select a response.</p>
    <table cellpadding="0" cellspacing="0" border="0" data-expected="<?php if (FORCE_PATH == 0) { echo 1; } else { echo 0; } ?>">
      <tbody>
        <tr class="label">
          <td colspan="6">How often do you play video games? (e.g. computer, console, mobile phone, tablet, Facebook etc.)<br /><em>Move the slider to where you feel is appropriate for you.</em></td>
        </tr>
        <tr class="noborder">
          <td colspan="3" width="50%" style="text-align: left">
            <label>Not at all</label>
          </td>
          <td colspan="3" width="50%" style="text-align: right">
            <label>Very often</label>
          </td>
        </tr>
        <tr class="noborder">
          <td colspan="6" style="padding: 16px 0">
            <input style="width: 100%" type="range" size="8" id="meta-1" min="0" max="100" value="50" step="1" />
          </td>
        </tr>
        <?php if (FORCE_PATH == 0) { ?>
        <tr class="label">
          <td colspan="6">Do you remember which introduction you received at the beginning of the game?</td>
        </tr>
        <tr class="noborder">
          <td colspan="2" width="33%" style="text-align: center">
            <label>&ldquo;Very much like our own society, in Ogre World there is not enough to go around...&rdquo;<br />
              <input type="radio" name="meta-2" value="1">
            </label>
          </td>
          <td colspan="2" width="33%" style="text-align: center">
            <label>&ldquo;Star World has 4 levels. To pass each level, you'll need to pay the ogre 5 stars.&rdquo;<br />
              <input type="radio" name="meta-2" value="2">
            </label>
          </td>
          <td colspan="2" width="33%" style="text-align: center">
            <label>I don't remember<br />
              <input type="radio" name="meta-2" value="0">
            </label>
          </td>
        </tr>
        <?php } else { ?>
          <input type="hidden" name="meta-2" value="<?php echo FORCE_PATH; ?>" />
        <?php } ?>
      </tbody>
    </table>
    <p style="text-align: center"><button class="continue">Continue</button></p>
  </div>
  <div id="sir" class="questionnaire" style="display: none">
    <p>Please select the response that is most appropriate.</p>
    <table cellpadding="0" cellspacing="0" border="0" data-expected="23">
      <tbody>
        <tr class="label">
          <td colspan="5">To what extent do you have difficulty throwing things away?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Not at all<br />
              <input type="radio" name="sir-1" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>To a mild extent<br />
              <input type="radio" name="sir-1" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>To a moderate extent<br />
              <input type="radio" name="sir-1" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>To a considerable extent<br />
              <input type="radio" name="sir-1" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Very much so<br />
              <input type="radio" name="sir-1" value="4">
            </label>
          </td>
        </tr>
        <tr class="label">
          <td colspan="5">How distressing do you find that task of throwing things away?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>No distress<br />
              <input type="radio" name="sir-2" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Mild distress<br />
              <input type="radio" name="sir-2" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Moderate distress<br />
              <input type="radio" name="sir-2" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Severe distress<br />
              <input type="radio" name="sir-2" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Extreme distress<br />
              <input type="radio" name="sir-2" value="4">
            </label>
          </td>
        </tr>
        <tr class="label">
          <td colspan="5">To what extent do you have so many things that your room(s) are cluttered?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Not at all<br />
              <input type="radio" name="sir-3" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>To a mild extent<br />
              <input type="radio" name="sir-3" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>To a moderate extent<br />
              <input type="radio" name="sir-3" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>To a considerable extent<br />
              <input type="radio" name="sir-3" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Very much so<br />
              <input type="radio" name="sir-3" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How often do you try to avoid discarding possessions because it is too stressful or time consuming?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Never avoid, easily able to discard items<br />
              <input type="radio" name="sir-4" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Rarely avoid, can discard with little difficulty<br />
              <input type="radio" name="sir-4" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Sometimes avoid<br />
              <input type="radio" name="sir-4" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Frequently avoid, can discard items occasionally<br />
              <input type="radio" name="sir-4" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Almost always avoid, rarely able to discard items<br />
              <input type="radio" name="sir-4" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How distressed or uncomfortable would you feel if you could not acquire something you wanted?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Not at all<br />
              <input type="radio" name="sir-5" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Mildly, only slightly anxious<br />
              <input type="radio" name="sir-5" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Moderate, distress would mount but would be manageable<br />
              <input type="radio" name="sir-5" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Severe, prominent and very disturbing increase in distress<br />
              <input type="radio" name="sir-5" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Extreme, incapacitating discomfort from any such effort<br />
              <input type="radio" name="sir-5" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How much of the living area in your home is cluttered with possessions? Consider the amount of clutter in your kitchen, living room, dining room, hallways bedrooms, bathrooms or other rooms.</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>None of the living area is cluttered<br />
              <input type="radio" name="sir-6" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Some of the living area is cluttered<br />
              <input type="radio" name="sir-6" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Much of the living area is cluttered<br />
              <input type="radio" name="sir-6" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Most of the living area is cluttered<br />
              <input type="radio" name="sir-6" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>All or most of the living area is cluttered<br />
              <input type="radio" name="sir-6" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How much does the clutter in your home interfere with your social, work or everyday functioning? Think about things that you don't do because of clutter.</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Not at all<br />
              <input type="radio" name="sir-7" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Mild; slight interference, but overall functioning not impaired<br />
              <input type="radio" name="sir-7" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Moderate; definite interference but still manageable<br />
              <input type="radio" name="sir-7" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Severe; causes substantial interference<br />
              <input type="radio" name="sir-7" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Extreme; incapacitating<br />
              <input type="radio" name="sir-7" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How often do you feel compelled to acquire something you see? E.g when shopping or when being offered free things.</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Never feel compelled<br />
              <input type="radio" name="sir-8" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Rarely feel compelled<br />
              <input type="radio" name="sir-8" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Sometimes feel compelled<br />
              <input type="radio" name="sir-8" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Frequently feel compelled<br />
              <input type="radio" name="sir-8" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Almost always feel compelled<br />
              <input type="radio" name="sir-8" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How strong is your urge to buy or acquire free things for which you have no immediate use?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Urge is not strong at all<br />
              <input type="radio" name="sir-9" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Mild urge<br />
              <input type="radio" name="sir-9" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Moderate urge<br />
              <input type="radio" name="sir-9" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Strong urge<br />
              <input type="radio" name="sir-9" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Very strong urge<br />
              <input type="radio" name="sir-9" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How much control do you have over your urges to acquire possessions?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Complete control<br />
              <input type="radio" name="sir-10" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Much control, usually able to control urges to acquire<br />
              <input type="radio" name="sir-10" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Some control, can control urges to acquire only with difficulty<br />
              <input type="radio" name="sir-10" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Little control, can only delay urges to acquire and only with great difficulty<br />
              <input type="radio" name="sir-10" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>No control, unable to stop urges to acquire possessions<br />
              <input type="radio" name="sir-10" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How often do you decide to keep things you do not need or have little space for?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Never<br />
              <input type="radio" name="sir-11" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Rarely<br />
              <input type="radio" name="sir-11" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Occasionally<br />
              <input type="radio" name="sir-11" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Frequently<br />
              <input type="radio" name="sir-11" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Almost always keep such possessions<br />
              <input type="radio" name="sir-11" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">To what extent does clutter prevent you from using parts of your home?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>All parts of the home are useable<br />
              <input type="radio" name="sir-12" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>A few parts of the home are not useable<br />
              <input type="radio" name="sir-12" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Some parts of the home are not useable<br />
              <input type="radio" name="sir-12" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Many parts of the home are not useable<br />
              <input type="radio" name="sir-12" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Nearly all parts of the home are not useable<br />
              <input type="radio" name="sir-12" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">To what extent does the clutter in your home cause you distress?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>No feelings of distress or discomfort<br />
              <input type="radio" name="sir-13" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Mild feelings of distress or discomfort<br />
              <input type="radio" name="sir-13" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Moderate feelings of distress or discomfort<br />
              <input type="radio" name="sir-13" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Severe feelings of distress and discomfort<br />
              <input type="radio" name="sir-13" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Extreme feelings of distress or discomfort<br />
              <input type="radio" name="sir-13" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How frequently does clutter in your home prevent you from inviting people to visit?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Not at all<br />
              <input type="radio" name="sir-14" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Rarely<br />
              <input type="radio" name="sir-14" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Sometimes<br />
              <input type="radio" name="sir-14" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Often<br />
              <input type="radio" name="sir-14" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Almost always<br />
              <input type="radio" name="sir-14" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How often do you actually buy (or acquire for free) things you use or need?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Never<br />
              <input type="radio" name="sir-15" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Rarely<br />
              <input type="radio" name="sir-15" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Sometimes<br />
              <input type="radio" name="sir-15" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Frequently<br />
              <input type="radio" name="sir-15" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Almost always<br />
              <input type="radio" name="sir-15" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How strong is your urge to save something that you would never use?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Not at all strong<br />
              <input type="radio" name="sir-16" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Mild urge<br />
              <input type="radio" name="sir-16" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Moderate urge<br />
              <input type="radio" name="sir-16" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Strong urge<br />
              <input type="radio" name="sir-16" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Very strong urge<br />
              <input type="radio" name="sir-16" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How much control do you have over your urges to save possessions?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Complete control<br />
              <input type="radio" name="sir-17" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Much control, usually able to control urges to save<br />
              <input type="radio" name="sir-17" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Some control, can control urges to save only with difficulty<br />
              <input type="radio" name="sir-17" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Little control, can only stop urges with great difficulty<br />
              <input type="radio" name="sir-17" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>No control unable to stop urges to save possessions<br />
              <input type="radio" name="sir-17" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How much of your home is difficult to walk through because of clutter?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>None of it is difficult to walk through<br />
              <input type="radio" name="sir-18" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Some of it is difficult to walk through<br />
              <input type="radio" name="sir-18" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Much of it is difficult to walk through<br />
              <input type="radio" name="sir-18" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Most of it is difficult to walk through<br />
              <input type="radio" name="sir-18" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>All or nearly all of it is difficult to walk through<br />
              <input type="radio" name="sir-18" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How upset or distressed do you feel about your acquiring habits?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Not at all upset<br />
              <input type="radio" name="sir-19" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Mildly upset<br />
              <input type="radio" name="sir-19" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Moderately upset<br />
              <input type="radio" name="sir-19" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Severely upset<br />
              <input type="radio" name="sir-19" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Extreme embarrassment<br />
              <input type="radio" name="sir-19" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">To what extent does the clutter in your home prevent you from using parts of your home for their intended purpose? For example, cooking, using furniture, washing dishes, cleaning, etc.?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Never<br />
              <input type="radio" name="sir-20" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Rarely<br />
              <input type="radio" name="sir-20" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Sometimes<br />
              <input type="radio" name="sir-20" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Frequently<br />
              <input type="radio" name="sir-20" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Very frequently or almost all the time<br />
              <input type="radio" name="sir-20" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">To what extent do you feel unable to control the clutter in your home?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Not at all<br />
              <input type="radio" name="sir-21" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>To a mild extent<br />
              <input type="radio" name="sir-21" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>To a moderate extent<br />
              <input type="radio" name="sir-21" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>To a considerable extent<br />
              <input type="radio" name="sir-21" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Very much so<br />
              <input type="radio" name="sir-21" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">To what extent has your saving or compulsive buying resulted in financial difficulties for you?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Not at all<br />
              <input type="radio" name="sir-22" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>A little financial difficulty<br />
              <input type="radio" name="sir-22" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Some financial difficulty<br />
              <input type="radio" name="sir-22" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Quite a lot of financial difficulty<br />
              <input type="radio" name="sir-22" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>An extreme amount of financial difficulty<br />
              <input type="radio" name="sir-22" value="4">
            </label>
          </td>
        </tr>
        <tr>
          <td colspan="5">How often are you unable to discard a possession you would like to get rid of?</td>
        </tr>
        <tr class="noborder">
          <td width="20%" style="text-align: center">
            <label>Never have a problem discarding possessions<br />
              <input type="radio" name="sir-23" value="0">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Rarely<br />
              <input type="radio" name="sir-23" value="1">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Occasionally<br />
              <input type="radio" name="sir-23" value="2">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Frequently<br />
              <input type="radio" name="sir-23" value="3">
            </label>
          </td>
          <td width="20%" style="text-align: center">
            <label>Almost always unable to discard possessions<br />
              <input type="radio" name="sir-23" value="4">
            </label>
          </td>
        </tr>
      </tbody>
    </table>
    <p style="text-align: center"><button class="continue">Continue</button></p>
  </div>
  
  <div id="ocir" class="questionnaire" style="display: none">
    <p>The following statements refer to experiences many people have in their everyday lives. Select the option that best describes <u>how much</u> that experience has <u>distressed</u> or <u>bothered</u> you during the <u>past month</u>.</p>
    <table cellpadding="0" cellspacing="0" border="0" data-expected="18">
      <thead>
        <tr>
          <th width="50%">&nbsp;</th>
          <th width="10%" style="text-align: center">Not at all</th>
          <th width="10%" style="text-align: center">A little</th>
          <th width="10%" style="text-align: center">Moderately</th>
          <th width="10%" style="text-align: center">A lot</th>
          <th width="10%" style="text-align: center">Extremely</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>I save up so many things they get in the way</td>
          <td style="text-align: center"><input type="radio" name="ocir-1" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-1" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-1" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-1" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-1" value="4"/></td>
        </tr>
        <tr>
          <td>I check things more often than necessary</td>
          <td style="text-align: center"><input type="radio" name="ocir-2" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-2" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-2" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-2" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-2" value="4"/></td>
        </tr>
        <tr>
          <td>I get upset if objects are not arranged properly</td>
          <td style="text-align: center"><input type="radio" name="ocir-3" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-3" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-3" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-3" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-3" value="4"/></td>
        </tr>
        <tr>
          <td>I feel compelled to count while I am doing things</td>
          <td style="text-align: center"><input type="radio" name="ocir-4" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-4" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-4" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-4" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-4" value="4"/></td>
        </tr>
        <tr>
          <td>I find it difficult to touch an object when I know it has been touched by strangers or certain people</td>
          <td style="text-align: center"><input type="radio" name="ocir-5" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-5" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-5" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-5" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-5" value="4"/></td>
        </tr>
        <tr>
          <th width="50%">&nbsp;</th>
          <th width="10%" style="text-align: center">Not at all</th>
          <th width="10%" style="text-align: center">A little</th>
          <th width="10%" style="text-align: center">Moderately</th>
          <th width="10%" style="text-align: center">A lot</th>
          <th width="10%" style="text-align: center">Extremely</th>
        </tr>
        <tr>
          <td>I find it difficult to control my thoughts</td>
          <td style="text-align: center"><input type="radio" name="ocir-6" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-6" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-6" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-6" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-6" value="4"/></td>
        </tr>
        <tr>
          <td>I collect things I don't need</td>
          <td style="text-align: center"><input type="radio" name="ocir-7" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-7" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-7" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-7" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-7" value="4"/></td>
        </tr>
        <tr>
          <td>I repeatedly check doors, windows and drawers etc.</td>
          <td style="text-align: center"><input type="radio" name="ocir-8" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-8" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-8" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-8" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-8" value="4"/></td>
        </tr>
        <tr>
          <td>I get upset if others change the way I have arranged things</td>
          <td style="text-align: center"><input type="radio" name="ocir-9" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-9" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-9" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-9" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-9" value="4"/></td>
        </tr>
        <tr>
          <td>I feel I have to repeat certain numbers</td>
          <td style="text-align: center"><input type="radio" name="ocir-10" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-10" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-10" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-10" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-10" value="4"/></td>
        </tr>
        <tr>
          <th width="50%">&nbsp;</th>
          <th width="10%" style="text-align: center">Not at all</th>
          <th width="10%" style="text-align: center">A little</th>
          <th width="10%" style="text-align: center">Moderately</th>
          <th width="10%" style="text-align: center">A lot</th>
          <th width="10%" style="text-align: center">Extremely</th>
        </tr>
        <tr>
          <td>I sometimes have to wash or clean myself simply because I feel contaminated</td>
          <td style="text-align: center"><input type="radio" name="ocir-11" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-11" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-11" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-11" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-11" value="4"/></td>
        </tr>
        <tr>
          <td>I am upset by unpleasant thoughts that come into my mind against my will</td>
          <td style="text-align: center"><input type="radio" name="ocir-12" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-12" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-12" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-12" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-12" value="4"/></td>
        </tr>
        <tr>
          <td>I avoid throwing things away in case I might need them later</td>
          <td style="text-align: center"><input type="radio" name="ocir-13" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-13" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-13" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-13" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-13" value="4"/></td>
        </tr>
        <tr>
          <td>I repeatedly check the gas, water taps and light switches after turning them off</td>
          <td style="text-align: center"><input type="radio" name="ocir-14" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-14" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-14" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-14" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-14" value="4"/></td>
        </tr>
        <tr>
          <td>I need things to be arranged in a particular order</td>
          <td style="text-align: center"><input type="radio" name="ocir-15" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-15" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-15" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-15" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-15" value="4"/></td>
        </tr>
        <tr>
          <th width="50%">&nbsp;</th>
          <th width="10%" style="text-align: center">Not at all</th>
          <th width="10%" style="text-align: center">A little</th>
          <th width="10%" style="text-align: center">Moderately</th>
          <th width="10%" style="text-align: center">A lot</th>
          <th width="10%" style="text-align: center">Extremely</th>
        </tr>
        <tr>
          <td>I feel that there are good and bad numbers</td>
          <td style="text-align: center"><input type="radio" name="ocir-16" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-16" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-16" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-16" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-16" value="4"/></td>
        </tr>
        <tr>
          <td>I wash my hands more often and longer than necessary</td>
          <td style="text-align: center"><input type="radio" name="ocir-17" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-17" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-17" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-17" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-17" value="4"/></td>
        </tr>
        <tr>
          <td>I frequently get nasty thoughts and have difficulty getting rid of them</td>
          <td style="text-align: center"><input type="radio" name="ocir-18" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-18" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-18" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-18" value="3"/></td>
          <td style="text-align: center"><input type="radio" name="ocir-18" value="4"/></td>
        </tr>
      </tbody>
    </table>
    <p style="text-align: center"><button class="continue">Continue</button></p>
  </div>

  <div id="gad7" class="questionnaire" style="display: none">
    <p>Over the <u>last 2 weeks</u>, how often have you been bothered by the following problems?</p>
    <table cellpadding="0" cellspacing="0" border="0" data-expected="7">
      <thead>
        <tr>
          <th width="50%">&nbsp;</th>
          <th width="12%" style="text-align: center">Not at all</th>
          <th width="13%" style="text-align: center">Several days</th>
          <th width="12%" style="text-align: center">More than half the days</th>
          <th width="13%" style="text-align: center">Nearly every day</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Feeling nervous, anxious or on edge</td>
          <td style="text-align: center"><input type="radio" name="gad-1" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="gad-1" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="gad-1" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="gad-1" value="3"/></td>
        </tr>
        <tr>
          <td>Not being able to stop or control worrying</td>
          <td style="text-align: center"><input type="radio" name="gad-2" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="gad-2" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="gad-2" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="gad-2" value="3"/></td>
        </tr>
        <tr>
          <td>Worrying too much about different things</td>
          <td style="text-align: center"><input type="radio" name="gad-3" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="gad-3" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="gad-3" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="gad-3" value="3"/></td>
        </tr>
        <tr>
          <td>Trouble relaxing</td>
          <td style="text-align: center"><input type="radio" name="gad-4" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="gad-4" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="gad-4" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="gad-4" value="3"/></td>
        </tr>
        <tr>
          <td>Being so restless that it is hard to sit still</td>
          <td style="text-align: center"><input type="radio" name="gad-5" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="gad-5" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="gad-5" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="gad-5" value="3"/></td>
        </tr>
        <tr>
          <td>Becoming easily annoyed or irritable</td>
          <td style="text-align: center"><input type="radio" name="gad-6" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="gad-6" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="gad-6" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="gad-6" value="3"/></td>
        </tr>
        <tr>
          <td>Feeling afraid as if something awful might happen</td>
          <td style="text-align: center"><input type="radio" name="gad-7" value="0"/></td>
          <td style="text-align: center"><input type="radio" name="gad-7" value="1"/></td>
          <td style="text-align: center"><input type="radio" name="gad-7" value="2"/></td>
          <td style="text-align: center"><input type="radio" name="gad-7" value="3"/></td>
        </tr>
      </tbody>
    </table>
    <p style="text-align: center"><button class="continue">Continue</button></p>
  </div>
  <p id="questionnaires-message" style="display: none"></p>
</div>
<div id="debrief" style="display: none">
  <h1>Thank you for playing!</h1>
  <p id="message" style="display: none"></p>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/phaser/2.4.4/phaser.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
  var forcedPath = <?php echo FORCE_PATH; ?>;
  var adminEmail = '<?php echo ADMIN_EMAIL; ?>';
</script>
<script src="game.js"></script>
<script src="dungeon.js"></script>
<script src="underwater.js"></script>
<script src="meadow.js"></script>
<script src="sky.js"></script>
<?php }?>
</body>
</html>