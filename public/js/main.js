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
    let media_id = document.querySelector('.media_id');
    let btn_comment = document.querySelector('#add-com');
    let bloc_com = document.querySelector('.comment_user_granted');
    let btn_delete = document.querySelector('.btn-delete');
    let title = document.querySelector('.title_m');
    let a_tag = document.querySelector('.delete-figure');

    function display_img_form(){
        if(image){
            image.addEventListener('click', (e) => {
                let img_val = image.dataset.value;
                console.log(img_val);
                media_select.style.display = 'block';
                media_select.style.visibility = 'visible';
                input_img.style.display = "flex";
                media_img.style.display = "none";
            });
        }
    }

    function display_vid_form(){
        if(video){
            video.addEventListener('click', (e) => {
                let vid_val = video.dataset.value;
                console.log(vid_val);
                media_select.style.display = 'block';
                media_select.style.visibility = 'visible';
                media_img.style.display = "flex";
                input_img.style.display = "none";
            });
        }
    }

    function get_media_id(){
        m_btn.forEach((btn) => {
            let action = btn.dataset.action;
            let id_value = btn.dataset.id;
            let m_id = btn.dataset.mediaid;
            let title_value = btn.dataset.title;

            btn.addEventListener('click', (e) => {
                let img = document.querySelector('.link_m');
                let inp_media = document.querySelector('.inp_media');
                let form = document.querySelector('.delete_media');


                if(action === 'update'){
                    modal_title.innerHTML = 'Définir comme image de couverture';
                    title.innerHTML = 'Voulez-vous définir l\'image '+title_value+' comme image de couverture de cette figure ?';
                    btn_modal_form.classList.remove('btn-danger');
                    btn_modal_form.classList.add('btn-primary');
                    btn_modal_form.setAttribute('value', 'Mettre à jour');
                    form.setAttribute('action', '/update_media/'+id_value+'/'+m_id);
                    media_id.setAttribute('value', m_id);
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

    function display_add_comment(){
        if(btn_comment){
            btn_comment.addEventListener('click', (e) => {
                bloc_com.style.display = "block";
            });
        }
    }

    function remove_alerte(){
        if(alerte_div){
            setTimeout(() => {
                alerte_div.remove();
            }, 5000);
            return false;
        }
    }

    function delete_figure(){
        btn_delete.addEventListener('click', (e) => {
            let slug = btn_delete.dataset.slug;
            modal_title.innerHTML = 'Etes-vous certain de vouloir supprimer cette figure ?';
            title.innerHTML = 'Attention vous allez supprimer la figure '+slug;
            a_tag.setAttribute('href', '/delete_figure/'+slug);
        });
    }

    delete_figure();
    display_add_comment();
    get_media_id();
    display_img_form();
    display_vid_form();
    remove_alerte();
});