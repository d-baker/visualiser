<html>
  <head>
    <title>Audio Visualiser</title>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <link href='https://fonts.googleapis.com/css?family=Megrim' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="style.css" type="text/css"></link>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

    <script type="text/javascript" src="js/visualiser.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>

  </head>

  <body>

    <header>
        <img id="menu" src="icons/menu.svg"/>
        <div id="audio">
            <audio controls id="player" src="music/<?php 
                if (isset ($_GET["url"])) {
                    echo $_GET["url"];
                } else {
                    echo "Caper.mp3";
                } 
            ?>"></audio>
        </div>
    </header>

    <table style="width:100%;height:100%;" id="stars"></table>

    <nav>
        <ul>

            <!-- Caper -->
            <li>
                <a href="index.php?song=Caper&url=Caper.mp3&artist=Liam Cooke&download=http://novasolus.bandcamp.com/track/caper">liam cooke - caper</a>
            </li>

            <!-- 2015-01-30 -->
            <li>
                <a href="index.php?song=2015-01-30&url=2015-01-30.mp3&artist=Liam Cooke&download=https://soundcloud.com/novasolus/percussion-doodle-20150130k06">liam cooke - 2015-01-30</a>
            </li>

            <!-- C-1636 -->
            <li>
                <a href="index.php?song=C-1636&url=C-1636.mp3&artist=Liam Cooke&download=https://soundcloud.com/novasolus/c-1636">liam cooke - C-1636</a>
            </li>

            <!-- frog -->
            <li>
                <a href="index.php?song=frog&url=frog.mp3&artist=Liam Cooke&download=http://araile.com/2011/05/frog">liam cooke - frog</a>
            </li>

            <!-- strata -->
            <li>
                <a href="index.php?song=strata&url=strata.mp3&artist=Liam Cooke&download=https://soundcloud.com/novasolus/strata-wip">liam cooke - strata</a>
            </li>

            <!-- 11-12-13 -->
            <li>
                <a href="index.php?song=11-12-13&url=11-12-13.mp3&artist=memoriata&download=https://dbaker.bandcamp.com/track/11-12-13">memoriata - 11-12-13</a>
            </li>

            <!-- 18-12-13 -->
            <li>
                <a href="index.php?song=18-12-13&url=18-12-13.mp3&artist=memoriata&download=https://dbaker.bandcamp.com/track/18-12-13">memoriata - 18-12-13</a>
            </li>

            <!-- 1-1-14 -->
            <li>
                <a href="index.php?song=1-1-14&url=1-1-14.mp3&artist=memoriata&download=https://dbaker.bandcamp.com/track/1-1-14">memoriata - 1-1-14</a>
            </li>

            <!-- 2015-10-08 -->
            <li>
                <a href="index.php?song=2015-10-08&url=2015-10-08.mp3&artist=memoriata&download=http://memoriata.com/music/audio/originalcomps/2015-10-8.html">memoriata - 2015-10-08</a>
            </li>

            <!-- music for a starry night -->
            <li>
                <a href="index.php?song=music for a starry night&url=music for a starry night.mp3&artist=memoriata&download=http://memoriata.com/music/audio/originalcomps/Music_for_a_starry_night.html">memoriata - music for a starry night</a>
            </li>

            <!-- Party at the house of cats -->
            <li>
                <a href="index.php?song=party at the house of cats&url=party at the house of cats.mp3&artist=soxyfleming&download=null">soxyfleming - party at the house of cats</a>
            </li>

            <!-- wark columba mea -->
            <li>
                <a href="index.php?song=wark columba mea&url=wark columba mea.mp3&artist=soxyfleming&download=null">soxyfleming - wark columba mea</a>
            </li>

            <!-- Mecum in aeternum -->
            <li>
                <a href="index.php?song=mecum in aeternum&url=mecum in aeternum.mp3&artist=soxyfleming&download=null">soxyfleming - mecum in aeternum</a>
            </li>

            <!-- Rosarum -->
            <li>
                <a href="index.php?song=rosarum&url=rosarum.mp3&artist=soxyfleming&download=null">soxyfleming - rosarum</a>
            </li>

            <!-- memories/want/bliss -->
            <li>
                <a href="index.php?song=memories/want/bliss&url=memories-want-bliss.mp3&artist=soxyfleming&download=https://soundcloud.com/soxyfleming/fly-to-paradise-memories-want">soxyfleming - memories/want/bliss</a>
            </li>

        </ul>

    </nav>

    <footer>
        <p><a href="<?php 
            if (isset($_GET["download"])) {
                echo $_GET["download"];
            } else {
                echo "http://novasolus.bandcamp.com/track/caper";} 
            ?>">
            <?php 
                if (isset($_GET["artist"]) && isset($_GET["download"])) {
                    echo strtolower($_GET["artist"] . " - " . $_GET["song"]);
                } else {
                    echo "liam cooke - caper";
                } 
            ?>
        </a></p>
    </footer>
  </body>

</html>
