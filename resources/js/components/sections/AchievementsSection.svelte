<script>
    import { onDestroy } from 'svelte';
    import { achievements } from '../../lib/achievements';

    let flippedCards = $state({});
    let currentIndex = $state(0);
    let navDirection = $state(1);
    let isMobileView = $state(false);
    let isSliding = $state(false);
    let slideLockTimer = $state(null);

    const NAV_DURATION = 380;

    if (typeof window !== 'undefined') {
        isMobileView = window.innerWidth <= 768;
    }

    onDestroy(() => {
        if (slideLockTimer) clearTimeout(slideLockTimer);
    });

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
        if (isSliding) return;
        isSliding = true;
        navDirection = -1;
        currentIndex = normalizeIndex(currentIndex - 1);

        if (slideLockTimer) clearTimeout(slideLockTimer);
        slideLockTimer = setTimeout(() => {
            isSliding = false;
        }, (isMobileView ? 260 : NAV_DURATION) + 60);
    }

    function nextAchievement() {
        if (isSliding) return;
        isSliding = true;
        navDirection = 1;
        currentIndex = normalizeIndex(currentIndex + 1);

        if (slideLockTimer) clearTimeout(slideLockTimer);
        slideLockTimer = setTimeout(() => {
            isSliding = false;
        }, (isMobileView ? 260 : NAV_DURATION) + 60);
    }

    function formatAchievementDescription(text) {
        if (!text) return '';

        const conjunctions = new Set(['and', 'or', 'for', 'nor', 'but', 'yet', 'so', 'a', 'an', 'the', 'of', 'to', 'in', 'on', 'at', 'with', 'by']);
        const acronyms = new Set(['AI', 'DOST', 'NASA', 'SEI', 'UIC', 'IO', 'XI']);

        const normalized = text
            .replace(/([a-z0-9])([A-Z])/g, '$1 $2')
            .replace(/([A-Z]+)([A-Z][a-z])/g, '$1 $2')
            .replace(/([A-Za-z])(\d)/g, '$1 $2')
            .replace(/(\d)([A-Za-z])/g, '$1 $2')
            .replace(/\s+/g, ' ')
            .trim();

        return normalized
            .split(' ')
            .map((word, index) => {
                const upperWord = word.toUpperCase();
                if (acronyms.has(upperWord)) return upperWord;

                const lowerWord = word.toLowerCase();
                if (index !== 0 && conjunctions.has(lowerWord)) return lowerWord;

                return lowerWord.charAt(0).toUpperCase() + lowerWord.slice(1);
            })
            .join(' ');
    }
</script>

<section id="achievements" class="section-wrap relative isolate overflow-hidden">
    <div class="section-grid-zoom" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto w-full px-6 md:px-10">
        <div class="achievements-header">
            <h2 class="achievements-title">ACHIEVEMENTS AND PARTICIPATIONS</h2>
            <p class="achievements-subtitle">Scholarships, Training Experiences, and Organizations that Shape My Growth as an Aspring Software Engineer.</p>
        </div>

        <div class="achievement-viewport">
            {#each [-1, 0, 1] as offset}
                {@const index = getIndexByOffset(offset)}
                {@const achievement = achievements[index]}
                {@const slotClass = offset === 0 ? 'slot-center' : offset < 0 ? 'slot-left' : 'slot-right'}

                <div class={`carousel-slot ${slotClass}`}>
                    {#key `${slotClass}-${index}`}
                        <button
                            type="button"
                            class="flip-card cursor-pointer"
                            class:slide-from-right={navDirection === 1}
                            class:slide-from-left={navDirection === -1}
                            class:is-flipped={flippedCards[index] ?? false}
                            aria-pressed={flippedCards[index] ?? false}
                            aria-label={`Flip achievement card: ${achievement.title}`}
                            onclick={() => handleFlip(index)}
                            onkeydown={(event) => handleKeydown(event, index)}
                        >
                            <div class="flip-card-inner">
                                <div class="flip-face front-media rounded-2xl border border-[var(--color-primary)]/35 bg-[var(--color-surface)]">
                                    <img class="front-image" src={achievement.image} alt={achievement.title} loading="lazy" />
                                    <div class="front-overlay">
                                        <p class="front-hint">Click to flip</p>
                                    </div>
                                </div>

                                <div
                                    class="flip-face flip-back achievement-back rounded-2xl border border-[var(--color-primary)]/35 p-6 md:p-7"
                                    style={`--achievement-back-image: url('${achievement.image}')`}
                                >
                                    <div class="back-top-line face-anim anim-1"></div>
                                    <h3 class="face-anim anim-1 back-title mb-4 text-center text-lg font-semibold md:text-xl">{achievement.title}</h3>
                                    <p class="face-anim anim-2 flip-description break-words text-center text-sm leading-relaxed md:text-base">{formatAchievementDescription(achievement.description)}</p>
                                    <p class="face-anim anim-3 back-cta mt-5 text-center text-sm">Click to return</p>
                                </div>
                            </div>
                        </button>
                    {/key}
                </div>
            {/each}
        </div>

        <div class="carousel-controls">
            <button type="button" class="carousel-button" aria-label="Previous achievement" onclick={previousAchievement} disabled={isSliding}>
                &lt;
            </button>
            <a class="gallery-button" href="/achievements-gallery" aria-label="View achievements gallery">
                View Gallery
            </a>
            <button type="button" class="carousel-button" aria-label="Next achievement" onclick={nextAchievement} disabled={isSliding}>
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
        display: block;
        height: 18rem;
        width: min(36vw, 30rem);
        flex: 0 0 auto;
        perspective: 1400px;
        transition: opacity 0.2s ease;
        will-change: transform, opacity;
    }

    .flip-card.slide-from-right {
        animation: card-slide-in-right var(--slide-duration, 380ms) cubic-bezier(0.22, 0.61, 0.36, 1) both;
    }

    .flip-card.slide-from-left {
        animation: card-slide-in-left var(--slide-duration, 380ms) cubic-bezier(0.22, 0.61, 0.36, 1) both;
    }

    @keyframes card-slide-in-right {
        from {
            opacity: 0;
            transform: translateX(44px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes card-slide-in-left {
        from {
            opacity: 0;
            transform: translateX(-44px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
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

    .front-media {
        overflow: hidden;
    }

    .front-image {
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .front-overlay {
        position: absolute;
        inset: auto 0 0;
        padding: 1.1rem 1.1rem 1rem;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 4%, rgba(0, 0, 0, 0.72) 54%, rgba(0, 0, 0, 0.86) 100%);
    }

    .front-hint {
        margin: 0;
        text-align: center;
        font-size: 0.8rem;
        color: rgba(246, 246, 251, 0.88);
    }

    .flip-back {
        transform: rotateY(180deg);
    }

    .achievement-back {
        position: relative;
        overflow: hidden;
        isolation: isolate;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: #f2f6ff;
        background: linear-gradient(138deg, rgba(5, 8, 24, 0.92) 0%, rgba(8, 18, 46, 0.9) 52%, rgba(6, 16, 44, 0.95) 100%);
        box-shadow: inset 0 0 0 1px rgba(127, 166, 255, 0.2), 0 20px 38px rgba(1, 6, 19, 0.4);
    }

    .achievement-back::before {
        content: '';
        position: absolute;
        inset: -8%;
        z-index: -2;
        background-image: var(--achievement-back-image);
        background-size: cover;
        background-position: center;
        opacity: 0.35;
        transform: scale(1.08);
        filter: saturate(1.4) contrast(1.1) brightness(0.45);
    }

    .achievement-back::after {
        content: '';
        position: absolute;
        inset: 0;
        z-index: -1;
        background:
            radial-gradient(circle at 16% 84%, rgba(86, 149, 255, 0.34), transparent 42%),
            radial-gradient(circle at 86% 14%, rgba(49, 126, 255, 0.28), transparent 38%),
            linear-gradient(180deg, rgba(2, 8, 24, 0.3) 0%, rgba(4, 10, 28, 0.86) 100%);
    }

    .back-top-line {
        margin-bottom: 1.2rem;
        height: 0.2rem;
        width: 100%;
        border-radius: 9999px;
        background: linear-gradient(90deg, rgba(255, 196, 71, 0.95) 0%, rgba(255, 223, 128, 0.85) 100%);
    }

    .back-title {
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #f4f7ff;
        text-wrap: balance;
    }

    .flip-description {
        color: rgba(232, 240, 255, 0.88);
    }

    .back-cta {
        color: rgba(223, 234, 255, 0.82);
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

    .flip-card.is-flipped .flip-back .flip-description {
        animation: description-reveal 0.58s cubic-bezier(0.22, 1, 0.36, 1) 0.12s both;
    }

    @keyframes description-reveal {
        from {
            opacity: 0;
            transform: translateY(14px);
            clip-path: inset(0 0 100% 0);
            filter: blur(2px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
            clip-path: inset(0 0 0 0);
            filter: blur(0);
        }
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
        .flip-card.slide-from-right,
        .flip-card.slide-from-left {
            --slide-duration: 260ms;
        }

        @keyframes card-slide-in-right {
            from {
                opacity: 0;
                transform: translateX(24px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes card-slide-in-left {
            from {
                opacity: 0;
                transform: translateX(-24px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

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
