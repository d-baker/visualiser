// http://ianreah.com/2013/02/28/Real-time-analysis-of-streaming-audio-data-with-Web-Audio-API.html

$(function () {
    // Future-proofing...
    var context;
    if (typeof AudioContext !== "undefined") {
        context = new AudioContext();
    } else if (typeof webkitAudioContext !== "undefined") {
        context = new webkitAudioContext();
    } else {
        $(".hideIfNoApi").hide();
        $(".showIfNoApi").show();
        return;
    }

    // Create the analyser
    var analyser = context.createAnalyser();
    analyser.fftSize = 32;
    var frequencyData = new Uint8Array(analyser.frequencyBinCount);
    var waveformData = new Uint8Array(analyser.frequencyBinCount);



    
    // set up stars
    for (i = 0; i < 20; i++) {
        $("#stars").append("<tr></tr>");
    }

    $("#stars tr").each(function() {
        for (i = 0; i < 20; i++) {
            $(this).append("<td></td>");
        }
    });



    function updateStars(r, g, b) {
        var freqRatio = (b - g - r) / 100;

        $("#stars tr").each(function() {
            $(this).children("td").each(function() {
                $(this).text("");

                if (Math.random() < freqRatio && r > 50) {
                    if (Math.random() < 0.1) {
                        $(this).text(".");
                    }
                } else {
                    if (Math.random() < 0.05 && freqRatio != 0 && r > 50) {
                        if (Math.random() < 0.1) {
                            $(this).text("✧");
                        }
                        else {
                            $(this).text(".");
                        }
                    }
                }

            });
        });
    }


    b = 0;
    g = 0;
    r = 0;

    // Get the frequency data and update the visualisation
    function update() {
        requestAnimationFrame(update);

        analyser.getByteFrequencyData(frequencyData);
        analyser.getByteTimeDomainData(waveformData);


        prevColor = b+g+r;

        // inner part of radial gradient
        r = ((frequencyData [5] / 2) - frequencyData[6] + frequencyData[7]); 
        g = (waveformData [1]) / 3;
        b = (waveformData [0]) / 2;

        // outer part of radial gradient
        BGr = waveformData[0] - waveformData[4];
        BGg = waveformData[0] - waveformData[7];
        BGb = waveformData[0] - waveformData[15];

        // threshold for bright colors at high frequencies (currently orange)
        if ((b+g+r) - r < 60) {
            r = 40 + waveformData [8];
            g = 10 + (waveformData[14] / 2);
            b = 10 - waveformData[8];
        }

        currentColor = b+g+r;

        colordiff = Math.abs(currentColor - prevColor);
        

        // limit color updates using a color change threshold
        if (prevColor > 0) {
            if (colordiff > 3) {
                $("body").css("background", "radial-gradient(ellipse at center, rgb(" + r + ", " + g + ", " + b + "), rgb(" + BGr + ", " + BGg + ", " + BGb + ")");
            }
        } else {
            // update immediately on first "frame" (IS THIS WORKING?)
            $("body").css("background", "radial-gradient(ellipse at center, rgb(" + r + ", " + g + ", " + b + "), rgb(" + BGr + ", " + BGg + ", " + BGb + ")");
        }
    
        $("footer a").css("color", "rgb(" + r + ", " + g + ", " + b + ")");
        $("footer a").css("border-bottom", "1px dashed rgb(" + r + ", " + g + ", " + b + ")");

        // update stars
        updateStars(r, g, b);

    };




    // Hook up the audio routing...
    // player -> analyser -> speakers
    // (Do this after the player is ready to play - https://code.google.com/p/chromium/issues/detail?id=112368#c4)
    $("#player").bind('canplay', function() {
        var source = context.createMediaElementSource(this);
        source.connect(analyser);
        analyser.connect(context.destination);
    });

    // Kick it off...
    update();

});
