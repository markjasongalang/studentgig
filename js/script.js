const autoResizeTextArea = (textarea) => {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
};

const textareas = document.querySelectorAll('textarea');
textareas.forEach(textarea => {
    textarea.addEventListener('input', (e) => {
        autoResizeTextArea(e.target);
    });
});