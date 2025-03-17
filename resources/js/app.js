document.addEventListener('DOMContentLoaded', function() {
    // Toggle Password Visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('svg');
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            
            input.setAttribute('type', type);
            icon.innerHTML = type === 'password' ? 
                '<!-- SVG Eye icon -->' : 
                '<!-- SVG Eye-off icon -->';
        });
    });
});