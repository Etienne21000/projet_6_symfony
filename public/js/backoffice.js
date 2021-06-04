document.addEventListener('DOMContentLoaded', function() {

    let btn = document.querySelectorAll('.modal-btn');
    let content = document.querySelector('.content-comment');
    let id = document.querySelector('.input_id');
    let modal_title = document.querySelector('.modal-title');
    let sub = document.querySelector('.m-title-h3');
    let form_update = document.querySelector('.update_comment');
    let form_delete = document.querySelector('.delete_comment');
    let comid = document.querySelector('.com_id');
    let comiddelete = document.querySelector('.com_id_delete');

    function get_comment(){
        btn.forEach((b) => {
            let com_id = b.dataset.id;
            let com_content = b.dataset.content;
            let com_user = b.dataset.user;

            b.addEventListener('click', (e) => {
                modal_title.innerHTML = "Validez ou supprimez le commentaire";
                sub.innerHTML = "Ce commentaire à été ajouté par " + com_user;
                content.innerHTML = "\" "+com_content+" \"";
                comid.setAttribute('value', com_id);
                comiddelete.setAttribute('value', com_id);
                form_delete.setAttribute('action', '/delete-comment/'+com_id);
                form_update.setAttribute('action', '/updateComment/'+com_id);
            });
        })
    }

    get_comment();
});