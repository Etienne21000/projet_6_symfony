document.addEventListener('DOMContentLoaded', function(){
    console.log('Hello world');

    let media_select = document.querySelector('.select_media');
    let image = document.querySelector('#img');
    let video = document.querySelector('#vid');

    function display_img_form(){
        image.addEventListener('click', (e) => {
            media_select.style.display = 'block';
            media_select.style.visibility = 'visible';
        });
    }

    function display_vid_form(){
        video.addEventListener('click', (e) => {
            media_select.style.display = 'block';
            media_select.style.visibility = 'visible';
        });
    }

    display_img_form();
    display_vid_form();

});