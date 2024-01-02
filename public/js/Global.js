const wrapperImagePreviews = document.querySelectorAll('.wrapperImagePreview');

wrapperImagePreviews.forEach(wrapperImagePreview => {
    const fileInput = wrapperImagePreview.querySelector('.fileInput');
    const imagePreview = wrapperImagePreview.querySelector('.imagePreview');
    const removeable = wrapperImagePreview.querySelector('.removeable');
    imagePreview.style.display = 'none'
    // console.log(imagePreview);

    fileInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        imagePreview.style.display = 'block'

        if (file) {
            // Create a FileReader to read the selected file
            const reader = new FileReader();

            reader.onload = function (e) {
                removeable.style.display = 'none'
                // Set the src attribute of the image element to the data URL
                imagePreview.src = e.target.result;
            };

            // Read the file as a data URL
            reader.readAsDataURL(file);
        } else {
            // Clear the image preview if no file is selected
            imagePreview.src = '#';
        }
    });

});


// const fileInput = document.getElementById('fileInput');
// const imagePreview = document.getElementById('imagePreview');

// // Add an event listener to the file input element
// fileInput.addEventListener('change', function (event) {
//   const file = event.target.files[0];
// console.log(file);
//   if (file) {
//     // Create a FileReader to read the selected file
//     const reader = new FileReader();

//     reader.onload = function (e) {
//       // Set the src attribute of the image element to the data URL
//       imagePreview.src = e.target.result;
//     };

//     // Read the file as a data URL
//     reader.readAsDataURL(file);
//   } else {
//     // Clear the image preview if no file is selected
//     imagePreview.src = '#';
//   }
// });
