document.addEventListener('DOMContentLoaded', function () {
    var video = document.getElementById('videoFullscreen');
    var contentDiv = document.getElementById('root');
    var transitionDuration = 1000; // Durée de la transition en millisecondes
    var startFadeOut = 1.5; // Commencer à diminuer l'opacité 5 secondes avant la fin de la vidéo

    video.addEventListener('canplaythrough', function() {
        // Planifier le début de la transition
        setTimeout(startTransition, (video.duration - startFadeOut) * 1000);
    });

    video.addEventListener('ended', function() {
        video.style.display = 'none';
    });


    function startTransition() {

        contentDiv.style.opacity = '1';
        setTimeout(function() {
            video.style.opacity = '0';
        }, transitionDuration);
    }
});
