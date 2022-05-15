const Selectors = {
    'addComment' :  document.querySelector('#add-comment'),
    'showComment' : document.querySelector('#show-comment'),
    'firstBox' : document.querySelector('#first-box'),
    'mainBox' : document.querySelector('#main-box'),
    'userMenuButton' : document.querySelector('#user-menu-button'),
    'btnMenu' : document.querySelector('#btn-menu'),
    'checkboxUserInvitation' : document.querySelector('#checkbox-user-invititation'),
    'btnInputFile' : document.querySelector('#btn-input-file'),
    'btnInputTag' : document.querySelector('#btn-input-tag'),
    'showSidebar' : document.querySelector('#show-sidebar'),
};

if (Selectors.addComment !== null) {
    Selectors.addComment.addEventListener('click', addCommentFn);
}

if (Selectors.showComment !== null) {
    Selectors.showComment.addEventListener('click', showCommentFn);
}

if (Selectors.checkboxUserInvitation !== null) {
    Selectors.checkboxUserInvitation.addEventListener('change', hiddenUserPassword);
}

if (Selectors.btnInputFile !== null) {
    Selectors.btnInputFile.addEventListener('click', toggleInputFile);
}

if (Selectors.btnInputTag !== null) {
    Selectors.btnInputTag.addEventListener('click', toggleInputTag);
}

if (Selectors.showSidebar !== null) {
    Selectors.showSidebar.addEventListener('click', toggleMenuDocument);
}

if (Selectors.userMenuButton !== null) {
    Selectors.userMenuButton.addEventListener('click', toggleProfile);
}

if (Selectors.btnMenu !== null) {
    Selectors.btnMenu.addEventListener('click', toggleHamburger);
}

function addCommentFn() {
    return toggleHidden('form-comment');
}

function showCommentFn() {
    return toggleHidden('area-comment');
}

function updateComment(id) {
    if (id !== undefined) {
        document.getElementById('edit-comment-' + id).classList.toggle('hidden');
        document.getElementById('body-comment-' + id).className = 'hidden';
    }   
}

function replyComment(id) {
    if (id !== undefined) {
        document.getElementById('form-reply-comment-' + id).classList.toggle('hidden');
    }
}

function showDescription() {
    return toggleHidden('description-area');
}

function sxFunc() {
    Selectors.firstBox.classList.add('block');
    Selectors.firstBox.classList.remove('hidden');
    Selectors.mainBox.classList.add('hidden');
}

function dxFunc() {
    Selectors.mainBox.classList.add('block');
    Selectors.mainBox.classList.remove('hidden');
    Selectors.firstBox.classList.add('hidden');
}

function hiddenUserPassword(evt)
{
    const pass = document.getElementById('create-user-password');
    if (pass !== null) {
        pass.style.display = "block";
    }
    if(evt.currentTarget.checked) {
        pass.style.display = "none";
    } else {
        pass.style.display = "block";
    }
}

function toggleHidden(name) {
    const getName = document.getElementById(name);
    if (getName !== null) {
        getName.classList.toggle('hidden');
    }
}

// Open Profile menu
function toggleProfile()
{
    toggleHidden('window-profile'); 
}

// Toggle mobile menu
function toggleHamburger()
{
    toggleHidden('menu-mobile'); 
}

function toggleInputFile()
{
    toggleHidden('input-file');
}

function toggleInputTag()
{
    toggleHidden('area-tags');
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
    const sidebar = document.getElementById('menux');
    const doc = document.getElementById('doc-section');
    const footer = document.getElementById('doc-footer');
    
    if (sidebar !== null) {
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
    }
   
}



