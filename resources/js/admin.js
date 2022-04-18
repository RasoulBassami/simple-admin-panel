require('./admin/adminlte')
require('./admin/dashboard')
require('./admin/demo')
require("sweetalert");

let createNewPic = ({ id }) => {
    return `
                    <div class="row image-field" id="image-${id}">
                        <div class="col-5">
                            <div class="form-group">
                            <label>تصویر</label>
                                 <div class="custom-file">
                                      <input type="file" class="custom-file-input" name="images[${id}][image]"
                                      id="customFile${id}" aria-describedby="customFileAddon" lang="fa">
                                      <label class="custom-file-label" for="customFile${id}">انتخاب</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                 <label>متن جایگزین تصویر</label>
                                 <input type="text" name="images[${id}][alt]" class="form-control">
                            </div>
                        </div>
                         <div class="col-2">
                            <label >اقدامات</label>
                            <div>
                                <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('image-${id}').remove()">حذف</button>
                            </div>
                        </div>
                    </div>
                `
}
$('#add_post_image').click(function() {

    let imagesSection = $('#images_section');
    let id = imagesSection.children().length;

    imagesSection.append(
        createNewPic({
            id
        })
    );

});

/*  ==========================================
    SHOW UPLOADED IMAGE NAME
    * ========================================== */

var input = document.getElementById( 'upload' );
var infoArea = document.getElementById( 'upload-label' );
console.log(input);

input.addEventListener( 'change', showFileName );
function showFileName( event ) {
    var input = event.srcElement;
    var fileName = input.files[0].name;
    infoArea.textContent = fileName;
}
