document.addEventListener('DOMContentLoaded', function(){

    let media_select = document.querySelector('.select_media');
    let input_img = document.querySelector('.row-img');
    let media_img = document.querySelector('.media');
    let image = document.querySelector('#img');
    let video = document.querySelector('#vid');
    let m_btn = document.querySelectorAll('.modal-btn');
    let alerte_div = document.querySelector('.alert');
    let modal_title = document.querySelector('.modal-title');
    let btn_modal_form = document.querySelector('.btn-form');
    let status_edit = document.querySelector('.status-edit');
    // let post_id = document.querySelector('.post_id');

    function display_img_form(){
        image.addEventListener('click', (e) => {
            let img_val = image.dataset.value;
            console.log(img_val);
            media_select.style.display = 'block';
            media_select.style.visibility = 'visible';
            input_img.style.display = "flex";
            media_img.style.display = "none";
        });
    }

    function display_vid_form(){
        video.addEventListener('click', (e) => {
            let vid_val = video.dataset.value;
            console.log(vid_val);
            media_select.style.display = 'block';
            media_select.style.visibility = 'visible';
            media_img.style.display = "flex";
            input_img.style.display = "none";
        });
    }

    function get_media_id(){
        m_btn.forEach((btn) => {
            let action = btn.dataset.action;
            let id_value = btn.dataset.id;
            let title_value = btn.dataset.title;
            let post_id = btn.dataset.postId;

            btn.addEventListener('click', (e) => {
                let title = document.querySelector('.title_m');
                let img = document.querySelector('.link_m');
                let inp_media = document.querySelector('.inp_media');
                let form = document.querySelector('.delete_media');

                let input_status = '<input type="checkbox" value="1" name="status"> <label for="status">Définir comme image de couverture</label>';

                if(action === 'update'){
                    modal_title.innerHTML = 'Mettre à jour l\'image ' + title_value;
                    title.innerHTML = 'Voulez-vous mettre à jour l\'image: '+title_value;
                    btn_modal_form.classList.remove('btn-danger');
                    btn_modal_form.classList.add('btn-primary');
                    btn_modal_form.setAttribute('value', 'Mettre à jour');
                    form.setAttribute('action', '/update_media/'+id_value);
                    status_edit.innerHTML = input_status;
                    //inp_media.setAttribute('value', post_id);
                }
                else if(action === 'delete'){
                    modal_title.innerHTML = 'Supprimer l\'image';
                    title.innerHTML = 'Confirmez-vous la suppréssion de l\'image: '+title_value;
                    btn_modal_form.classList.remove('btn-primary');
                    btn_modal_form.classList.add('btn-danger');
                    btn_modal_form.setAttribute('value', 'Supprimer');
                    form.setAttribute('action', '/delete_media/'+id_value);
                    status_edit.innerHTML ="";
                }

                img.setAttribute('src', '/upload/'+title_value);
                inp_media.setAttribute('value', id_value);
            });
        })
    }

    function remove_alerte(){
        if(alerte_div){
            setTimeout(() => {
                alerte_div.remove();
            }, 5000);
            return false;
        }
    }

    remove_alerte();
    get_media_id();
    display_img_form();
    display_vid_form();
});