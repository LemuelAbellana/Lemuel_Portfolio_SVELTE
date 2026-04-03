<script>
    import { fly } from 'svelte/transition';
    import { Trophy } from 'lucide-svelte';

    const achievements = [
        {
            title: 'Top 100 Scholars Leadership Camp Region XI',
            description:
                'Selected among the Top 100 scholars in Region XI, recognized for leadership, collaboration, and initiative during an intensive development camp focused on service, innovation, and community impact.',
        },
        {
            title: 'DOST-SEI Scholar 2023-2027',
            description: 'Awarded a merit scholarship supporting my engineering studies based on strong academic performance and leadership potential.',
        },
        {
            title: 'NASA Space Apps Challenge 2025 Participant',
            description:
                'Collaborated with a multidisciplinary team to prototype a practical solution for a real-world challenge during the global NASA hackathon.',
        },
        {
            title: 'AI Engineering Training - DurianPy Davao',
            description: 'Completed focused training in AI engineering fundamentals, including applied workflows for practical model-driven solutions.',
        },
        {
            title: 'Ignacian Marian Leadership Training Participant',
            description: 'Completed values-centered leadership formation focused on service, team accountability, and mission-driven collaboration.',
        },
        {
            title: 'Member - ONSSE',
            description: 'Actively participated in scholar-led activities that support academic excellence, peer growth, and community engagement.',
        },
        {
            title: 'Member - DOST START',
            description: 'Contributed to student initiatives and technical learning circles that strengthen innovation and collaborative problem-solving.',
        },
        {
            title: 'TESDA World Skills Olympics - District Wide Cybersecurity Competition Champion',
            description: 'Champion in the district-wide cybersecurity competition and selected representative for Davao City.',
        },
        {
            title: 'TESDA World Skills Olympics - Regional Wide Cybersecurity Competition Champion',
            description: 'Champion in the regional-wide cybersecurity competition and selected representative for Davao Region (Region XI).',
        },
    ];

    let flippedCards = $state({});
    let currentIndex = $state(0);
    let navDirection = $state(1);
    let isNavigating = $state(false);

    const NAV_DURATION = 280;

    function handleFlip(index) {
        flippedCards[index] = !flippedCards[index];
    }

    function handleKeydown(event, index) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            handleFlip(index);
        }
    }

    function normalizeIndex(index) {
        const total = achievements.length;
        return ((index % total) + total) % total;
    }

    function getIndexByOffset(offset) {
        return normalizeIndex(currentIndex + offset);
    }

    function previousAchievement() {
        if (isNavigating) return;
        navDirection = -1;
        isNavigating = true;
        currentIndex = normalizeIndex(currentIndex - 1);
        setTimeout(() => {
            isNavigating = false;
        }, NAV_DURATION);
    }

    function nextAchievement() {
        if (isNavigating) return;
        navDirection = 1;
        isNavigating = true;
        currentIndex = normalizeIndex(currentIndex + 1);
        setTimeout(() => {
            isNavigating = false;
        }, NAV_DURATION);
    }
</script>

<section id="achievements" class="section-wrap">
    <div class="mx-auto w-full px-6 md:px-10">
        <div class="achievements-header">
            <h2 class="achievements-title">ACHIEVEMENTS</h2>
            <p class="achievements-subtitle">Scholarships, Training Experiences, and Organizations that Shape My Growth as an Aspring Software Engineer.</p>
        </div>

        <div class="achievement-viewport">
            {#each [-1, 0, 1] as offset}
                {@const index = getIndexByOffset(offset)}
                {@const achievement = achievements[index]}
                {@const slotClass = offset === 0 ? 'slot-center' : offset < 0 ? 'slot-left' : 'slot-right'}

                <div class={`carousel-slot ${slotClass}`}>
                    {#key `${slotClass}-${index}-${currentIndex}`}
                        <button
                            type="button"
                            class="flip-card cursor-pointer"
                            class:is-flipped={flippedCards[index] ?? false}
                            aria-pressed={flippedCards[index] ?? false}
                            aria-label={`Flip achievement card: ${achievement.title}`}
                            onclick={() => handleFlip(index)}
                            onkeydown={(event) => handleKeydown(event, index)}
                            in:fly={{ x: navDirection * 26, duration: NAV_DURATION }}
                            out:fly={{ x: navDirection * -26, duration: NAV_DURATION }}
                        >
                            <div class="flip-card-inner">
                                <div class="flip-face rounded-2xl border border-[var(--color-primary)]/35 bg-[var(--color-surface)] p-6 md:p-7">
                                    <div class="mb-5 h-1 w-full rounded-full bg-[var(--color-warm)]"></div>
                                    <Trophy class="face-anim anim-1 mx-auto mb-5 h-7 w-7 text-[var(--color-primary)]" aria-hidden="true" />
                                    <h3 class="face-anim anim-2 text-center text-xl font-semibold leading-tight md:text-2xl">{achievement.title}</h3>
                                    <p class="face-anim anim-3 mt-5 text-center text-sm text-[var(--color-text-muted)]">Click to flip</p>
                                </div>

                                <div class="flip-face flip-back rounded-2xl border border-[var(--color-primary)]/35 bg-[var(--color-surface)] p-6 md:p-7">
                                    <div class="mb-5 h-1 w-full rounded-full bg-[var(--color-warm)]"></div>
                                    <h3 class="face-anim anim-1 mb-4 text-center text-lg font-semibold md:text-xl">{achievement.title}</h3>
                                    <p class="face-anim anim-2 text-center text-sm leading-relaxed text-[var(--color-text-muted)] md:text-base">{achievement.description}</p>
                                    <p class="face-anim anim-3 mt-5 text-center text-sm text-[var(--color-text-muted)]">Click to return</p>
                                </div>
                            </div>
                        </button>
                    {/key}
                </div>
            {/each}
        </div>

        <div class="carousel-controls">
            <button type="button" class="carousel-button" aria-label="Previous achievement" onclick={previousAchievement} disabled={isNavigating}>
                &lt;
            </button>
            <a class="gallery-button" href="/achievements-gallery" aria-label="View achievements gallery">
                View Gallery
            </a>
            <button type="button" class="carousel-button" aria-label="Next achievement" onclick={nextAchievement} disabled={isNavigating}>
                &gt;
            </button>
        </div>
    </div>
</section>

<style>
    .achievements-header {
        position: relative;
        margin: 0 auto 2.75rem;
        text-align: center;
    }

    .achievements-title {
        position: relative;
        margin: 0;
        font-family: 'DM Sans', sans-serif;
        font-size: clamp(2.2rem, 5.2vw, 4rem);
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--color-text);
    }

    .achievements-subtitle {
        margin: 0.9rem auto 0;
        max-width: 52rem;
        font-family: 'DM Sans', sans-serif;
        font-size: clamp(1rem, 1.65vw, 1.45rem);
        font-weight: 400;
        color: var(--color-muted);
    }

    .achievement-viewport {
        position: relative;
        height: 19rem;
        width: 100vw;
        margin-left: calc(50% - 50vw);
        overflow: hidden;
    }

    .carousel-slot {
        position: absolute;
        top: 50%;
        height: 100%;
        z-index: 1;
        transition: transform 0.38s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.38s ease;
    }

    .carousel-slot::after {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 24%;
        pointer-events: none;
    }

    .slot-left {
        left: 0;
        transform: translate(-38%, -50%);
        opacity: 0.78;
    }

    .slot-left::after {
        left: 0;
        border-top-left-radius: 1rem;
        border-bottom-left-radius: 1rem;
        background: linear-gradient(90deg, rgba(72, 25, 118, 0.9) 0%, rgba(72, 25, 118, 0.58) 38%, rgba(72, 25, 118, 0) 100%);
        filter: blur(6px);
    }

    .slot-center {
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 3;
    }

    .slot-right {
        right: 0;
        transform: translate(38%, -50%);
        opacity: 0.78;
    }

    .slot-right::after {
        right: 0;
        border-top-right-radius: 1rem;
        border-bottom-right-radius: 1rem;
        background: linear-gradient(270deg, rgba(72, 25, 118, 0.9) 0%, rgba(72, 25, 118, 0.58) 38%, rgba(72, 25, 118, 0) 100%);
        filter: blur(6px);
    }

    .flip-card {
        height: 18rem;
        width: min(36vw, 30rem);
        flex: 0 0 auto;
        perspective: 1400px;
        transition: transform 0.25s ease, opacity 0.25s ease;
    }

    .flip-card-inner {
        position: relative;
        height: 100%;
        width: 100%;
        transform-style: preserve-3d;
        transition: transform 0.3s cubic-bezier(0.33, 1, 0.68, 1);
    }

    .flip-card.is-flipped .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-face {
        position: absolute;
        inset: 0;
        backface-visibility: hidden;
    }

    .flip-back {
        transform: rotateY(180deg);
    }

    .face-anim {
        opacity: 0;
        transform: translateY(10px) scale(0.99);
        transition: opacity 0.2s ease, transform 0.2s ease;
    }

    .flip-card:not(.is-flipped) .flip-face:not(.flip-back) .face-anim,
    .flip-card.is-flipped .flip-back .face-anim {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .anim-1 {
        transition-delay: 0.02s;
    }

    .anim-2 {
        transition-delay: 0.06s;
    }

    .anim-3 {
        transition-delay: 0.1s;
    }

    .carousel-controls {
        margin-top: 1.25rem;
        display: flex;
        justify-content: center;
        gap: 0.75rem;
    }

    .carousel-button {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 9999px;
        border: 1px solid color-mix(in srgb, var(--color-primary) 45%, transparent);
        background: color-mix(in srgb, var(--color-surface) 88%, transparent);
        color: var(--color-text);
        font-size: 1.125rem;
        line-height: 1;
        transition: background-color 0.2s ease, border-color 0.2s ease;
    }

    .carousel-button:hover {
        border-color: color-mix(in srgb, var(--color-primary) 80%, transparent);
        background: color-mix(in srgb, var(--color-surface) 98%, transparent);
    }

    .carousel-button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .gallery-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 2.5rem;
        padding: 0 1rem;
        border-radius: 9999px;
        border: 1px solid color-mix(in srgb, var(--color-primary) 55%, transparent);
        background: color-mix(in srgb, var(--color-surface) 92%, transparent);
        color: var(--color-text);
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
    }

    .gallery-button:hover {
        border-color: color-mix(in srgb, var(--color-primary) 85%, transparent);
        background: color-mix(in srgb, var(--color-surface) 100%, transparent);
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .achievement-viewport {
            height: 17.5rem;
        }

        .slot-left {
            transform: translate(-58%, -50%);
        }

        .slot-right {
            transform: translate(58%, -50%);
        }

        .flip-card {
            height: 17rem;
            width: min(88vw, 23rem);
        }
    }
</style>
