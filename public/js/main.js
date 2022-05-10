function comments() {
    const comment = document.getElementById('form-comment');
    const btnComment = document.getElementById('add-comment');
    const areaComment = document.getElementById('area-comment');
    const btnShowComment = document.getElementById('show-comment');
    if(btnComment !== null) {
        btnComment.addEventListener('click', function() {
            comment.classList.toggle('hidden');

        });
    }
    if(btnShowComment !== null) {
        btnShowComment.addEventListener('click', function() {
            areaComment.classList.toggle('hidden');
        });
    }
}

function hiddenUserPassword()
{
    const pass = document.getElementById('create-user-password');
    const check = document.getElementById('checkbox-user-invititation');
    if (pass !== null) {
        pass.style.display = "block";
    }
    
    if(check !== null) {
        check.addEventListener('change', (evt) => {
            if(evt.currentTarget.checked) {
                pass.style.display = "none";
            } else {
                pass.style.display = "block";
            }
        });
    }
    
}

function updateComment(id) {
    document.getElementById('edit-comment-' + id).classList.toggle('hidden');
    document.getElementById('body-comment-' + id).className = 'hidden';
}

function replyComment(id) {
    document.getElementById('form-reply-comment-' + id).classList.toggle('hidden');
}

function showDescription() {
    document.getElementById('description-area').classList.toggle('hidden');
}

function sxFunc() {
    document.getElementById('first-box').classList.add('block');
    document.getElementById('first-box').classList.remove('hidden');
    document.getElementById('main-box').classList.add('hidden');
}

function dxFunc() {
    document.getElementById('main-box').classList.add('block');
    document.getElementById('main-box').classList.remove('hidden');
    document.getElementById('first-box').classList.add('hidden');
}

// Open Profile menu
function toggleProfile()
{
    const btn = document.getElementById('user-menu-button');
    const windowProfile = document.getElementById('window-profile');
    if(windowProfile !== null) {
        windowProfile.style.display = 'none';
        btn.addEventListener('click', function() {
            if (windowProfile.style.display === 'none') {
                windowProfile.style.display = 'block';
            } else {
                windowProfile.style.display = 'none';
            }
    
        });
    }
    
}

// Toggle mobile menu
function toggleHamburger()
{
    const btn = document.getElementById('btn-menu');
    const menuMobile = document.getElementById('menu-mobile');
    if (menuMobile !== null) {
        menuMobile.style.display = 'none';
        btn.addEventListener('click', function() {
            if (menuMobile.style.display === 'none') {
                menuMobile.style.display = 'block';
            } else {
                menuMobile.style.display = 'none';
            }
        });
    }
   
}

function toggleInputFile()
{
    const btn = document.getElementById('btn-input-file');
    const area = document.getElementById('input-file');
    if (btn !== null) {
        btn.addEventListener('click', function() {
            area.classList.toggle('hidden');
        });
    }

}

function toggleInputTag()
{
    const btnInputTag = document.getElementById('btn-input-tag');
    const areaTags = document.getElementById('area-tags');
    if (btnInputTag !== null) {
        btnInputTag.addEventListener('click', function() {
            areaTags.classList.toggle('hidden');
        });
    }
}

function appendTag()
{
    let inputTag = document.getElementById('area-tags');
    const element = document.createElement('input');
    const addInputTag = document.getElementById('add-input-tag');
    const classes = ['w-full', 'py-1', 'px-2', 'border-2', 'border-gray-200', 'mt-2', 'input-tag'];
    element.setAttribute('type', 'text');
    element.setAttribute('name', 'tags[]');
    element.classList.add(...classes);
    inputTag.appendChild(element);
    element.after(addInputTag);
}

function toggleMenuDocument()
{
    const btn = document.getElementById('show-sidebar');
    const sidebar = document.getElementById('menux');
    const doc = document.getElementById('doc-section');
    const footer = document.getElementById('doc-footer');
    
    if (sidebar !== null) {
       
        btn.addEventListener('click', function() {
            sidebar.classList.toggle('hidden');
            if(sidebar.classList.contains('hidden')) {
                sidebar.style.display = "none";
                doc.classList.remove('hidden');
                footer.classList.remove('hidden');
            } else {
                sidebar.classList.remove('hidden');
                sidebar.style.display = "block";
                doc.classList.add('hidden');
                footer.classList.add('hidden');
            }
        });
    }
   
}

window.onload = function() {
    toggleProfile();
    toggleHamburger();
    toggleInputFile();
    toggleInputTag();
    comments();
    hiddenUserPassword();
    toggleMenuDocument();
};

