
// client section owl carousel
$(".client_owl-carousel").owlCarousel({
    loop: true,
    margin: 0,
    dots: false,
    nav: true,
    navText: [],
    autoplay: true,
    autoplayHoverPause: true,
    navText: [
        '<i class="fa fa-angle-left" aria-hidden="true"></i>',
        '<i class="fa fa-angle-right" aria-hidden="true"></i>'
    ],
    responsive: {
        0: {
            items: 1
        },
        768: {
            items: 2
        },
        1000: {
            items: 2
        }
    }
});

// custom.js
$(document).ready(function() {
    $('.option1').click(function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du lien

        var bookId = $(this).data('book-id');
        var bookTitle = $(this).data('title');
        var bookImage = $(this).data('image');
        var bookPrice = $(this).data('price');
        var bookPdfPath = $(this).data('pdf-path');

        $.ajax({
            url: '/add-to-cart/' + bookId,
            type: 'POST',
            data: {
                title: bookTitle,
                image: bookImage,
                price: bookPrice,
                pdfPath: bookPdfPath
            },
            success: function(response) {
                // Gérer la réponse en cas de succès, par exemple afficher un message à l'utilisateur
                alert('Livre ajouté au panier!');
            },
            error: function(xhr, status, error) {
                // Gérer les erreurs, par exemple afficher un message d'erreur à l'utilisateur
                alert('Une erreur est survenue lors de l\'ajout du livre au panier.');
            }
        });
    });
});

/** google_map js **/
function myMap() {
    var mapProp = {
        center: new google.maps.LatLng(40.712775, -74.005973),
        zoom: 18,
    };
    var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
}
