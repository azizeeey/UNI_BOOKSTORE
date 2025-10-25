document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('nav a');
    const currentPage = window.location.pathname.split('/').pop() || 'index.php';

    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href');
        if (linkPage === currentPage) {
            link.classList.add('active');
        }
    });

    // Notification helper
    function initNotification(notif) {
        if (notif.dataset.processed === '1') return;
        notif.dataset.processed = '1';

        // ensure .msg exists
        if (!notif.querySelector('.msg')) {
            const content = notif.innerHTML;
            notif.innerHTML = '<span class="msg">' + content + '</span>';
        }

        // ensure icon exists
        if (!notif.querySelector('.icon')) {
            const icon = document.createElement('span');
            icon.className = 'icon';
            if (notif.classList.contains('success')) icon.innerHTML = '✔';
            else if (notif.classList.contains('danger')) icon.innerHTML = '⚠';
            else icon.innerHTML = 'ℹ';
            notif.insertBefore(icon, notif.firstChild);
        }

        // ensure close button exists
        if (!notif.querySelector('.close-btn')) {
            const close = document.createElement('button');
            close.className = 'close-btn';
            close.type = 'button';
            close.innerHTML = '&times;';
            notif.appendChild(close);
            close.addEventListener('click', () => hideNotification(notif));
        }

        // show
        setTimeout(() => notif.classList.add('show'), 30);

        // auto-hide
        const timeout = setTimeout(() => hideNotification(notif), 4000);
        function hideNotification(el) {
            clearTimeout(timeout);
            el.classList.remove('show');
            el.classList.add('hide');
            setTimeout(() => {
                if (el && el.parentNode) el.parentNode.removeChild(el);
            }, 420);
        }
    }

    // Initialize existing notifications
    document.querySelectorAll('.notification').forEach(initNotification);

    // Observe DOM for new notifications
    const observer = new MutationObserver(mutations => {
        mutations.forEach(m => {
            m.addedNodes.forEach(node => {
                if (node.nodeType === 1 && node.classList.contains('notification')) {
                    initNotification(node);
                } else if (node.nodeType === 1) {
                    node.querySelectorAll && node.querySelectorAll('.notification').forEach(initNotification);
                }
            });
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });

    // Modal delete handling (delegated)
    const modal = document.getElementById('confirmModal');
    const confirmCancel = document.getElementById('confirmCancel');
    const hiddenDeleteInput = document.getElementById('hapus_confirm');

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.confirm-delete');
        if (!btn) return;
        e.preventDefault();
        const id = btn.getAttribute('data-id');
        if (!id) return;
        if (hiddenDeleteInput) hiddenDeleteInput.value = id;
        if (modal) {
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
        }
    });

    if (confirmCancel) {
        confirmCancel.addEventListener('click', function(e) {
            e.preventDefault();
            if (modal) {
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
                if (hiddenDeleteInput) hiddenDeleteInput.value = '';
            }
        });
    }

    // Close modal when clicking outside content
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
                if (hiddenDeleteInput) hiddenDeleteInput.value = '';
            }
        });
    }
});
