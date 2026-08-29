@once
    <script>
        document.addEventListener('livewire:init', () => {
            const keepAliveUrl = @js(route('session.keep-alive'));
            const keepAliveInterval = 5 * 60 * 1000;
            let lastKeepAlive = Date.now();

            const keepSessionAlive = async () => {
                try {
                    const response = await fetch(keepAliveUrl, {
                        cache: 'no-store',
                        credentials: 'same-origin',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    });

                    if (response.ok) {
                        lastKeepAlive = Date.now();
                    }
                } catch (error) {
                    // A temporary connection failure is handled by the next tick.
                }
            };

            window.setInterval(keepSessionAlive, keepAliveInterval);

            document.addEventListener('visibilitychange', () => {
                if (! document.hidden && Date.now() - lastKeepAlive >= keepAliveInterval) {
                    keepSessionAlive();
                }
            });

            Livewire.hook('request', ({ fail }) => {
                fail(({ status, preventDefault }) => {
                    if (status !== 419) {
                        return;
                    }

                    preventDefault();
                    window.location.replace(window.location.href);
                });
            });
        });
    </script>
@endonce
