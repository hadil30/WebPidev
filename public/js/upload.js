function uploadImage() {
    var input = document.getElementById('imageUrl');

    // Trigger click event on the hidden file input
    input.click();

    // Listen for changes in the file input
    input.addEventListener('change', function() {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // Get the imageUrl field by its ID
                var imageUrlField = document.getElementById('{{ form.imageUrl.vars.id }}');
                console.log(imageUrlField);
                
                // Set the value of the imageUrl field to the URL of the selected image
                imageUrlField.value = e.target.result;
            };

            // Read the selected file as a Data URL
            reader.readAsDataURL(input.files[0]);
        }
    });
}