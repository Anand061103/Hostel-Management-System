document.addEventListener('DOMContentLoaded', () => {

    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');

    const savedTheme = localStorage.getItem('theme');

    // Load saved theme
    if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark');
        themeIcon.textContent = '☀️';
    } else {
        document.documentElement.classList.remove('dark');
        themeIcon.textContent = '🌙';
    }

    // Toggle theme
    themeToggle?.addEventListener('click', () => {

        document.documentElement.classList.toggle('dark');

        const isDark =
            document.documentElement.classList.contains('dark');

        localStorage.setItem(
            'theme',
            isDark ? 'dark' : 'light'
        );

        themeIcon.textContent = isDark ? '☀️' : '🌙';
    });

});