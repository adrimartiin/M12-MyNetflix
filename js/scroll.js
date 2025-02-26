document.addEventListener('DOMContentLoaded', function() {
    const scrollContainers = document.querySelectorAll('.scroll-container');

    scrollContainers.forEach(container => {
        let isDown = false;
        let startX;
        let scrollLeft;
        let velocity = 0;
        let raf;

        container.addEventListener('mousedown', (e) => {
            isDown = true;
            container.classList.add('active');
            startX = e.pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
            cancelAnimationFrame(raf);
        });

        container.addEventListener('mouseleave', () => {
            isDown = false;
            container.classList.remove('active');
        });

        container.addEventListener('mouseup', () => {
            isDown = false;
            container.classList.remove('active');
            raf = requestAnimationFrame(inertiaScroll);
        });

        container.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - container.offsetLeft;
            const walk = (x - startX) * 2; // Ajusta la velocidad de desplazamiento
            container.scrollLeft = scrollLeft - walk;
            velocity = walk;
        });

        function inertiaScroll() {
            if (Math.abs(velocity) < 0.1) return;
            container.scrollLeft -= velocity;
            velocity *= 0.95; // Ajusta el factor de inercia
            raf = requestAnimationFrame(inertiaScroll);
        }
    });
}); 