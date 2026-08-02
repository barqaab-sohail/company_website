@once
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.hook('request', ({ fail }) => {
                fail(({ status, preventDefault }) => {
                    if (status !== 419) {
                        return;
                    }

                    preventDefault();
                    window.location.reload();
                });
            });
        });
    </script>
@endonce
