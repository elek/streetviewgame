<html>
<head>
  <meta charset="utf-8" />
  <title>The Street View Game (BETA) </title>
  <meta name="description" content="Nézz körül, és találd ki, hol vagy." />
  <link rel="stylesheet" href="style/styles.css" />
  <script type="text/javascript">
  (function() {
    var po = document.createElement('script');
    po.type = 'text/javascript'; po.async = true;
    po.src = 'https://plus.google.com/js/client:plusone.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(po, s);
  })();
  </script>
  
  <!-- JavaScript specific to this application that is not related to API
     calls -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" ></script>
  <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
  <script src="includes/jquery.cookie.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
  <script src="streetview.js" ></script>
  <script src="includes/levenshtein.js" ></script>
  <script src="main.js" ></script>
</head>
<body itemscope itemtype="http://schema.org/WebApplication">
<?php
require_once("config.php");
$settings = new Settings();
?>
  <!-- STREET VIEW -->
  
  <div id=streetView></div>
  <div id="disableClickOnGoogleIcon"></div> <!-- click on google icon opens a map (cheat) -->

  <!-- MAIN BOX -->

  <div id="mainBox" class="whiteBox" >
    <div class="accordion">
      
      <h3 itemprop="name">The Street View Game <small><small>(BETA)</small></small></h3>
      <div>
        <img itemprop="image" src="style/logo.png" class="floatRight"> 
        <p itemprop="description">Nézz körül, és találd ki, hol vagy. Válaszolj a helyszínnel kapcsolatos kérdésre! Ha nem ismerős a hely, keress táblákat, feliratokat. Sose add fel és ne ess pánikba!</p> 
        <p class="visibleIfNotLoggedIn">
          <img src='style/google-icon.png' class="floatLeft"> 
          Jelentkezz be a Google+ azonosítóddal (jobb felül)!
        </p>
        <p>
          Tetszik a játék? 
          <span class='g-plusone' data-size='medium'></span>
          <br><small> (VIGYÁZAT a +1-ek egyenlőre még csak tesztelésre... a domain név változhat, és így a +1-ek elveszhetnek)</small>
        </p>
        <p>
          Ötleted, fejlesztési javaslatod van? 
          <a href="mailto:elcsiga@projecthost.hu">Írj ide!</a>
        </p>
        <p>
          <small>A játék a <a href="http://www.google.com/streetview/">Google Street View</a> panorámaképeire épül. 
          És próbáljátok ki <a href="http://pursued.nemesys.hu/"> ezt </a> is, az ötletet innen merítettük.</small>
        </p>
      </div>
      
      <h3>Válassz egy rejtvényt!</h3>
      <div id=puzzleList></div>
    
      <h3>... vagy készíts egy újat!</h3>
      <div>
        <div class="visibleIfLoggedIn">
          <p>
            Először írd ide a hozzávetőleges címet! <small> pl. Győr, Dunakapu tér</small><br>
            <input type="text" id="addressOfPuzzle" name="addressOfPuzzle" />
          <p>
          </p> 
            <small>Vigyázat, a panorámaképek nem minden címen elérhetők! 
            Az 1 km-en belüli legközelebbi helyszínre ugrunk.</small> 
          </p> 
          <p>
            <a href="#" id="startCreatingPuzzle" >[Mehet]</a>
          </p>
        </div>
        <p class="visibleIfNotLoggedIn">
          <img src='style/google-icon.png' class = "floatLeft"> 
          Új rejtvény készítéséhez először be kell jelentkezned a Google+ azonosítóddal (jobb felül).
        </p>
      </div>
      
    </div>
  </div>
  
  <!-- ANSWERBOX -->

  <div id=answerBox class="middleBottomBox whiteBox">
    <p> 
      <img src='style/google-icon.png' class="puzzleCreatorIcon floatRight"> 
      <span id="question">Megfejtés:</span> <br> 
      <input type="text" id="answer" name="answer" /> <br>
      <small>Felhasznált idő: <b><span id="currentScore"></span></b> </small>     
    </p>
    <p> 
      <a href="#" id="sendanswer" >[Megfejtem]</a> | <a href="#" class="backToPuzzleList" >[Inkább feladom]</a>
    </p>
  </div>
  
  <!-- RESOLVED PUZZLE BOX -->

  <div id=resolvedPuzzleBox class="middleBottomBox whiteBox">
    <p> 
      <img src='style/google-icon.png' class="puzzleCreatorIcon floatRight"> 
      <img src='style/resolved.png' class = "floatLeft"> 
      <span id="resolvedQuestion">Megfejtés:</span>
      <b><span id="resolvedAnswer"></span></b><br>
      Felhasznált idő: <b><span id="resolvedScore"></span></b> másodperc     
    </p>
    <p> 
      <a href="#" class="backToPuzzleList" >[Vissza a rejtvényekhez]</a>
    </p>
    <p class="visibleIfNotLoggedIn"> 
      <img src='style/google-icon.png' class="floatLeft"> 
      Ha szeretnéd a megfejtéseidet megőrizni, jelentkezz be a Google+ azonosítóddal (jobb felül)!
    </p>
    <p>
      Tetszett a rejtvény? 
      <span class='g-plusone puzzleLinkPlusOne' data-size='medium' data-href='http://streetviewgame.projecthost.hu'></span> <br>
    </p>   
    <p>
      Közvetlen cím: 
      <u><span class='puzzleLink'></span></u><br>
      <small> ezt a címet elküldheted pl. email-ben </small>
    </p>   
    <p>
      <small>Valami nem stimmel, reklamálnál?
      <a href="mailto:elcsiga@projecthost.hu">Írj ide!</a></small>
    </p>
    
  </div>
  
  <!-- PUZZLE DETAILS (new puzzle and edit puzzle) -->
  
  <div id=puzzleDetailsBox class="middleBottomBox whiteBox">
    <p> <input type="hidden" id="puzzleId" name="puzzleId" />
       A rejtvény elnevezése: <small>pl. 'Patakos' </small><br>
       <input type="text" id="puzzleLabel" name="puzzleLabel"/><br>
       A kérdés: <small>pl. 'Mi a város neve?'</small><br>
       <input type="text" id="puzzleQuestion" name="puzzleQuestion" /><br>
       A megfejtés: <small>pl. 'Eger'</small><br>
       <input type="text" id="puzzleAnswer" name="puzzleAnswer" /> 
    </p>
    <p> 
      <small>Menj a pontos helyre, fordítsd a kamerát a kívánt irányba és töltsd ki a fenti sorokat!</small>
    </p>
    <p>
      <a href="#" id="submitPuzzle" >[Minden kész, mehet]</a> | <a href="#" class="backToPuzzleList" >[Mégsem]</a>
    </p>
      
  </div>  
  
  <!-- RIGHT BAR -->

  <div id=rightBar>
  
    <div id="gConnect" class="loginBox" >
      <button class="g-signin"
              data-scope="https://www.googleapis.com/auth/plus.login"
              data-requestvisibleactions="http://schemas.google.com/AddActivity"
              data-clientId="<?php echo $settings->googleApiClientId; ?>"
              data-callback="onSignInCallback"
              data-theme="dark"
	      data-accesstype="offline"
              data-cookiepolicy="single_host_origin">
      </button>

    </div>
    <div id="authOps" class="loginBox" style="display:none">
      <span id="profileImage"></span>
      <p id="profileText">
        <span id="profileName"></span><br>
        <span> <a href="#" id="disconnect" >Kilépés</a></span>
      </p>
    </div>
   
    <div style="clear:both;"></div>

    <div id=commentBox>

      <p id="commentList"></p>
      
      <hr style="clear:both;">
      <p>
        Szólj hozzá!<br>
        <small>... de a megfejtést azért ne áruld el!</small>
      </p>

      <p class="visibleIfNotLoggedIn">
        <img src='style/google-icon.png' class="floatLeft"> 
         Kommenteléshez először be kell jelentkezned a Google+ azonosítóddal (jobb felül).
      </p>

      <div class="visibleIfLoggedIn">
        <textarea id = "newCommentText"></textarea>
        <p><a href="#" id="submitComment" >[Mehet]</a></a></p>
      </div>
        
      <hr style="clear:both;">
      <p> 
        Tetszik ez a rejtvény? 
        <span class='g-plusone puzzleLinkPlusOne' data-size='medium' data-href='http://streetviewgame.projecthost.hu'></span> <br>
      </p>
      <p> 
        Közvetlen cím:<br>
        <u><span class='puzzleLink'></span></u><br>
        <small> ezt a címet elküldheted pl. email-ben </small>
      </p>
    </div> 
     
  </div> 
  

</body>
<script type="text/javascript" src="googleplus.js"></script>
<script type="text/javascript">
  window.___gcfg = {lang: 'hu'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
</html>
