import Echo from 'laravel-echo';
import io from 'socket.io-client';

window.io = io;

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001', // must match REVERB_PORT
});

document.addEventListener('livewire:initialized', () => {
    window.addEventListener('toast', event => {
        const {
            message,
            type = 'success',     // default type
            timeout = 3000        // default timeout
        } = event.detail;

        const toast = document.createElement('div');
        toast.textContent = message;

        // Tailwind color mapping by type
        const colorMap = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500 text-black',
            info: 'bg-blue-500',
        };

        const colorClass = colorMap[type] || colorMap.success;

        toast.className = `toast-message ${colorClass} text-white px-4 py-2 rounded shadow z-50 mb-2`;
        toast.style.position = "relative";
        toast.style.opacity = "0";
        toast.style.transition = "opacity 0.3s";

        let container = document.querySelector('#toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = "fixed bottom-5 right-5 flex flex-col items-end space-y-2 z-50";
            document.body.appendChild(container);
        }

        container.appendChild(toast);

        // Fade in
        requestAnimationFrame(() => {
            toast.style.opacity = "1";
        });

        // Auto-dismiss if timeout !== false
        if (timeout !== false) {
            setTimeout(() => {
                toast.style.opacity = "0";
                toast.addEventListener('transitionend', () => toast.remove());
            }, timeout);
        }

        // Optional: allow click to dismiss
        toast.addEventListener('click', () => toast.remove());
    });
});
