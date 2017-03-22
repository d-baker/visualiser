// http://ianreah.com/2013/02/28/Real-time-analysis-of-streaming-audio-data-with-Web-Audio-API.html
    currentTime = 0;

    function setTimecode(time) {
        time = parseFloat(time);

        console.log(time);
        currentTime = time;
        document.getElementById("player").currentTime = currentTime;
    }


$(function () {
    function scale(x, max) {
        if (max > 0) {
            return (max * x) / 255;
        }

        return (max * x) / 255;
    }

    function signal(amplitude, frequency, phase) {
        return amplitude * Math.sin(2 * Math.PI * frequency + phase)
    }

    function selectDataViz(option) {
        switch(option) {
            case "horizon":
                horizon();
                break;
            case "contrail":
                contrail();
                break;
            case "galaxy":
                galaxy();
                break;
            default:
                contrail();
        }

        frequencyData = new Uint8Array(analyser.frequencyBinCount);
        waveformData = new Uint8Array(analyser.frequencyBinCount);
    }

    function selectColorFunc(option) {
        switch(option) {
            case "bluescreen":
                colorFunc = bluescreenColorFunc;
                break;
            case "deadchannel":
                colorFunc = deadchannelColorFunc;
                break;
            default:
                colorFunc = deadchannelColorFunc;
        }
    }

    function horizon() {
        analyser.fftSize = 128;
        lineStartYfunc = horizonLineStartY;
        lineEndYfunc = horizonLineEndY;

        numSamples = analyser.fftSize / 2;

        dataVizFunction = sineViz;
    }

    function contrail() {
        analyser.fftSize = 256;
        lineStartYfunc = contrailLineStartY;
        lineEndYfunc = contrailLineEndY;

        numSamples = analyser.fftSize / 2;

        dataVizFunction = sineViz;
    }

    function galaxy() {
        analyser.fftSize = 32;

        numSamples = analyser.fftSize / 2;

        // set up stars
        $("#stars").show();
        for (i = 0; i < 20; i++) {
            $("#stars").append("<tr></tr>");
        }
    
        $("#stars tr").each(function() {
            for (i = 0; i < 20; i++) {
                $(this).append("<td></td>");
            }
        });

        b = 0;
        g = 0;
        r = 0;

        dataVizFunction = starViz;

    }

    function starViz() {
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
        
        updateStars(r, g, b);
    }

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

    function sineViz(numSamples) {
       for (i = 0; i < numSamples; i++) {
            var a = waveformData[i];
            var f = frequencyData[i];

            drawWave(a, f);
        }
    }

    function drawWave(waveformSample, frequencySample) {
        var lineheight = 10;

        var lineStartX = i * (window.innerWidth / numSamples);
        var lineStartY = lineStartYfunc(waveformSample, frequencySample);
        var lineEndX = i * (window.innerWidth / numSamples);
        var lineEndY = lineEndYfunc(lineStartY, lineheight);

        canvasCtx.beginPath();
        canvasCtx.moveTo(lineStartX, lineStartY);
        canvasCtx.lineTo(lineEndX, lineEndY);
        canvasCtx.lineWidth = window.innerWidth/numSamples;

        canvasCtx.strokeStyle = colorFunc(waveformSample, frequencySample);
        canvasCtx.stroke();
    }

    function bluescreenColorFunc(waveform, frequency) {
        var r = Math.round(scale(signal(waveform, frequency, waveform), 255));
        var g = Math.round(scale(signal(frequency, waveform, frequency), 255));
        var b = Math.round(scale(signal(frequency, waveform, 1), 255));

        return "rgb(" + r + "," + g + "," + b + ")";
    }

    function horizonLineStartY(waveform, frequency) {
        return scale(signal(waveform, frequency, 1), window.innerHeight) * 2;
    }

    function horizonLineEndY() {
        return window.innerHeight;
    }

    function deadchannelColorFunc(waveform, frequency) {
        var r = Math.round(scale(signal(waveform, frequency, 1), 255));
        var g = Math.round(scale(signal(frequency, waveform, 1), 255));
        var b = Math.round(scale(signal(waveform, frequency, waveform), 255));

        return "rgb(" + r + "," + g + "," + b + ")";
    }

    function contrailLineStartY(waveform) {
        return scale(waveform, window.innerHeight);
    }
    function contrailLineEndY(lineStartY, lineheight) {
        return lineStartY+lineheight;
    }


    $("#songs, #dataviz, #colorfunc").change(function(event) {
        var newHref = $("#songs").val() + "&dataviz=" + $("#dataviz").val() + "&colorfunc=" + $("#colorfunc").val();
        
        if (event.target.id != "songs") {
            newHref += "&timecode=" + currentTime;
        }

        window.location.href = newHref;
    });

    // TODO store values of dropdown menus on page reload


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
    selectDataViz($("#dataviz").val());
    selectColorFunc($("#colorfunc").val());

    $("#dataviz").change(function() {
        selectDataViz($(this).val());
    });

    $("#colorfunc").change(function() {
        selectColorFunc($(this).val());
    });



    var canvas = document.getElementById('lines');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    var canvasCtx = canvas.getContext('2d');


    // Get the frequency data and update the visualisation
    function update() {
        currentTime = document.getElementById("player").currentTime;
        canvasCtx.clearRect(0, 0, canvas.width, canvas.height);

        requestAnimationFrame(update);

        analyser.getByteFrequencyData(frequencyData);
        analyser.getByteTimeDomainData(waveformData);

        dataVizFunction(numSamples);
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

    CanvasRenderingContext2D.prototype.clear =
  CanvasRenderingContext2D.prototype.clear || function (preserveTransform) {
    if (preserveTransform) {
      this.save();
      this.setTransform(1, 0, 0, 1, 0, 0);
    }

    this.clearRect(0, 0, this.canvas.width, this.canvas.height);

    if (preserveTransform) {
      this.restore();
    }
};

});
