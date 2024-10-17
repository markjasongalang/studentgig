// Auto-resize all textareas
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

// Back buttons
const backBtns = document.querySelectorAll('.back-btn');
backBtns.forEach(backBtn => {
    backBtn.addEventListener('click', () => {
        window.history.back();
    });
});