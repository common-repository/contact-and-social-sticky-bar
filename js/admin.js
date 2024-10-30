document.addEventListener("DOMContentLoaded", function() {
    const preview_bar = document.querySelector(`#cassb-bar--preview`);
    const preview_bar_left = document.querySelector(`#cassb-bar__left--preview`);
    const preview_bar_right = document.querySelector(`#cassb-bar__right--preview`);

    const editor_left = document.querySelector(`#cassb_left_content`);
    const editor_right = document.querySelector(`#cassb_right_content`);

    const enable = document.querySelector(`#cassb_enable`);
    const height = document.querySelector(`#cassb_height`);

    jQuery(document).ready(function($){
        $('.cassb_color_picker').wpColorPicker({
            change: function(event, ui) {
                let color = ui.color.toString();
                switch (this.id) {
                    case 'cassb_background_color_picker':
                    	preview_bar.style.backgroundColor = color;
                    break;
                    case 'cassb_text_color_picker':
                    	preview_bar.style.color = color;
                    break;
                }
            }
        });
    });

    enable.addEventListener('change', ()=>{
    	preview_bar.style.display = enable.checked ? "block" : "none";
    });

    height.addEventListener('change', ()=>{
        if (height.value != "")
    	   preview_bar.style.height = `${height.value}px`;
        else
            preview_bar.style.height = `auto`;
    });

    editor_left.addEventListener('change', ()=>{
        preview_bar_left.innerHTML = editor_left.value;
    });

    tinymce.on('addeditor', e =>{
        if (e.editor.id == 'cassb_left_content') {
            e.editor.on( 'init', event => {
                tinymce.editors.cassb_left_content.on(('keyup'), ()=>{
                   preview_bar_left.innerHTML = tinymce.editors.cassb_left_content.getContent();
                });
                tinymce.editors.cassb_left_content.on(('change'), ()=>{
                   preview_bar_left.innerHTML = tinymce.editors.cassb_left_content.getContent();
                });
            });
        }
        if (e.editor.id == 'cassb_right_content') {
            e.editor.on( 'init', event => {
                tinymce.editors.cassb_right_content.on(('keyup'), ()=>{
                   preview_bar_right.innerHTML = tinymce.editors.cassb_right_content.getContent();
                });
                tinymce.editors.cassb_right_content.on(('change'), ()=>{
                   preview_bar_right.innerHTML = tinymce.editors.cassb_right_content.getContent();
                });
            });
        }
    });
});