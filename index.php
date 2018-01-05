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

<?php
        $available_dataviz = array('horizon', 'contrail', 'galaxy');
        $available_colorfunc = array('bluescreen', 'deadchannel');

        $songs = array(
            'liam-cooke-caper' =>
                array('url' => 'Caper.mp3',
                'artist' => 'Liam Cooke',
                'download' => 'http://novasolus.bandcamp.com/track/caper',
                'title' => 'Caper'),

            'liam-cooke-17-03-03' =>
                array('url' => '17-03-03.mp3',
                'artist' => 'Liam Cooke',
                'download' => '',
                'title' => '17-03-03'),

            'liam-cooke-2015-01-30' =>
                array('url' => '2015-01-30.mp3',
                'artist' => 'Liam Cooke',
                'download' => 'https://soundcloud.com/novasolus/percussion-doodle-20150130k06',
                'title' => '2015-01-30'),

            'liam-cooke-C-1636' =>
                array('url' => 'C-1636.mp3',
                'artist' => 'Liam Cooke',
                'download' => 'https://soundcloud.com/novasolus/c-1636',
                'title' => 'C-1636'),

            'liam-cooke-frog' =>
                array('url' => 'frog.mp3',
                'artist' => 'Liam Cooke',
                'download' => 'http://araile.com/2011/05/frog',
                'title' => 'frog'),

            'liam-cooke-strata' =>
                array('url' => 'strata.mp3',
                'artist' => 'Liam Cooke',
                'download' => 'https://soundcloud.com/novasolus/strata-wip',
                'title' => 'strata'),

            'memoriata-2017-5-24' =>
                array('url' => '2017-5-24.mp3',
                'artist' => 'memoriata',
                'download' => 'http://memoriata.com/music/audio/originalcomps/2017-05-24.html',
                'title' => '2017-5-24'),

            'memoriata-11-12-13' =>
                array('url' => '11-12-13.mp3',
                'artist' => 'memoriata',
                'download' => 'https://dbaker.bandcamp.com/track/11-12-13',
                'title' => '11-12-13'),

            'memoriata-18-12-13' =>
                array('url' => '18-12-13.mp3',
                'artist' => 'memoriata',
                'download' => 'https://dbaker.bandcamp.com/track/18-12-13',
                'title' => '18-12-13'),

            'memoriata-2015-10-08' =>
                array('url' => '2015-10-08.mp3',
                'artist' => 'memoriata',
                'download' => 'http://memoriata.com/music/audio/originalcomps/2015-10-8.html',
                'title' => '2015-10-08'),

            'memoriata-2017-3-1' =>
                array('url' => '2017-3-1.mp3',
                'artist' => 'memoriata',
                'download' => '',
                'title' => '2017-3-1'),


            'memoriata-music-for-a-starry-night' =>
                array('url' => 'music for a starry night.mp3',
                'artist' => 'memoriata',
                'download' => 'http://memoriata.com/music/audio/originalcomps/Music_for_a_starry_night.html',
                'title' => 'Music for a starry night'),

            'soxyfleming-party-at-the-house-of-cats' =>
                array('url' => 'party at the house of cats.mp3',
                'artist' => 'soxyfleming',
                'download' => '',
                'title' => 'Party at the house of cats'),

            'soxyfleming-wark-columba-mea' =>
                array('url' => 'wark columba mea.mp3',
                'artist' => 'soxyfleming',
                'download' => '',
                'title' => 'Wark columba mea'),

            'soxyfleming-mecum-in-aeternum' =>
                array('url' => 'mecum in aeternum.mp3',
                'artist' => 'soxyfleming',
                'download' => '',
                'title' => 'Mecum in aeternum'),

            'soxyfleming-rosarum' =>
                array('url' => 'rosarum.mp3',
                'artist' => 'soxyfleming',
                'download' => '',
                'title' => 'Rosarum'),

            'soxyfleming-memories-want-bliss' =>
                array('url' => 'memories-want-bliss.mp3',
                'artist' => 'soxyfleming',
                'download' => 'https://soundcloud.com/soxyfleming/fly-to-paradise-memories-want',
                'title' => 'memories/want/bliss'),

            );

        // Default values don't get changed unless the url contains valid params.
        $dataviz = "contrail";
        $selectedSong = "liam-cooke-caper";
        $colorfunc = "deadchannel";

        if (isset($_GET["dataviz"]) && in_array($_GET["dataviz"], $available_dataviz)) {
            $dataviz = $_GET["dataviz"];
        }

        if (isset($_GET["colorfunc"]) && in_array($_GET["colorfunc"], $available_colorfunc)) {
            $colorfunc = $_GET["colorfunc"];
        }

        if (isset($_GET["song"]) && array_key_exists($_GET["song"], $songs)) {
            $selectedSong = $_GET["song"];
        }

        $artist = $songs[$selectedSong]['artist'];
        $download = $songs[$selectedSong]['download'];
        $title = $songs[$selectedSong]['title'];

    ?>

    <p id="credit">
        Created by <a href="http://memoriata.com">Dorothea Baker</a>
    </p>

    <header>
        <div id="audio">
            <audio controls id="player" src="<?php
                echo "music/" . $songs[$selectedSong]['url'];
        ?>" <?php
            if (isset($_GET["timecode"])) {
                if ($_GET["timecode"] > 0) {
                    echo "autoplay";
                }
            }
            ?> onloadeddata="setTimecode('<?php
            if (isset($_GET["timecode"])) {
                echo $_GET["timecode"];
            } else { echo "0"; }
            ?>')">
        </audio>
        </div>

        <div id="title">
        <a href="<?php
                echo $download;
                ?>">
                <?php
                    echo $artist . " - " . $title;
                ?>
            </a>
        </div>
    </header>

    <div id="options">

        <p>

        <label for="songs">Song:</label>
        <select id="songs">
            <?php
            foreach ($songs as $song => $metadata) {
                $title = $metadata['title'];
                $artist = $metadata['artist'];
                echo "<option value='index.php?song=$song' ";
                if ($selectedSong == $song) echo 'selected=true';
                echo ">$artist - $title</option>";
            }
            ?>
        </select>
        </p>

        <p>
            <label for="dataviz">Viz function:</label>
            <select id="dataviz">
                <option value="horizon" <?php if ($dataviz == 'horizon') echo 'selected=true'?>>Horizon</option>
                <option value="contrail" <?php if ($dataviz == 'contrail') echo 'selected=true'?>>Contrail</option>
                <option value="galaxy" <?php if ($dataviz == 'galaxy') echo 'selected=true'?>>Galaxy</option>
            </select>
        </p>

        <p>
            <label for="colorfunc">Color function:</label>
            <select id="colorfunc" <?php if ($dataviz == 'galaxy') echo 'disabled=true' ?>>
                <option value="bluescreen" <?php if ($colorfunc == 'bluescreen') echo 'selected=true'?>>BlueScreen</option>
                <option value="deadchannel" <?php if ($colorfunc == 'deadchannel') echo 'selected=true'?>>DeadChannel</option>
            </select>
        </p>

    </div>


    <canvas id="lines"></canvas>
    <table style="width:100%;height:100%;" id="stars"></table>

  </body>

</html>
