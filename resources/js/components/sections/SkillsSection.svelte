<script>
    import { onDestroy, onMount } from 'svelte';
    import { gsap } from '../../lib/gsap';

    let section = $state(null);
    let carouselTrack = $state(null);
    let carouselItemsRef = $state([]);
    let scrollTween = $state(null);
    let highlightedIndex = $state(-1);

    const carouselItems = [
        { name: 'Java', logo: 'https://skillicons.dev/icons?i=java' },
        { name: 'Python', logo: 'https://skillicons.dev/icons?i=python' },
        { name: 'JavaScript', logo: 'https://skillicons.dev/icons?i=js' },
        { name: 'PHP', logo: 'https://skillicons.dev/icons?i=php' },
        { name: 'Laravel', logo: 'https://skillicons.dev/icons?i=laravel' },
        { name: 'React', logo: 'https://skillicons.dev/icons?i=react' },
        { name: 'Svelte', logo: 'https://skillicons.dev/icons?i=svelte' },
        { name: 'Express JS', logo: 'https://skillicons.dev/icons?i=express' },
        { name: 'MySQL', logo: 'https://skillicons.dev/icons?i=mysql' },
        { name: 'Flutter', logo: 'https://skillicons.dev/icons?i=flutter' },
        { name: 'NodeJS', logo: 'https://skillicons.dev/icons?i=nodejs' },
        { name: 'MongoDB', logo: 'https://skillicons.dev/icons?i=mongodb' },
    ];
    const duplicatedCarouselItems = [...carouselItems, ...carouselItems];

    const applyCinemaCurve = () => {
        const viewportCenter = window.innerWidth / 2;

        for (const item of carouselItemsRef) {
            if (!item) continue;

            const rect = item.getBoundingClientRect();
            const itemCenter = rect.left + rect.width / 2;
            const offset = (itemCenter - viewportCenter) / viewportCenter;
            const intensity = Math.min(Math.abs(offset), 1);
            const arcDrop = intensity * intensity * 42;

            gsap.set(item, {
                y: arcDrop,
                rotateY: offset * 14,
                scale: 1 - intensity * 0.08,
                opacity: 1 - intensity * 0.2,
                transformOrigin: 'center center',
            });
        }
    };

    onMount(() => {
        if (!carouselTrack) return;

        applyCinemaCurve();
        scrollTween = gsap.to(carouselTrack, {
            xPercent: -50,
            duration: 22,
            repeat: -1,
            ease: 'none',
            onUpdate: applyCinemaCurve,
        });

        window.addEventListener('resize', applyCinemaCurve);

        return () => {
            window.removeEventListener('resize', applyCinemaCurve);
        };
    });

    onDestroy(() => {
        scrollTween?.kill();
    });

    const handlePointerMove = (event) => {
        if (!carouselItemsRef?.length) return;

        const cursorX = event.clientX;
        let nearestIndex = -1;
        let nearestDistance = Number.POSITIVE_INFINITY;

        for (let i = 0; i < carouselItemsRef.length; i++) {
            const item = carouselItemsRef[i];
            if (!item) continue;

            const rect = item.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const distance = Math.abs(cursorX - centerX);

            if (distance < nearestDistance) {
                nearestDistance = distance;
                nearestIndex = i;
            }
        }

        highlightedIndex = nearestIndex;
    };

    const clearHighlight = () => {
        highlightedIndex = -1;
    };
</script>

<section id="skills" class="section-wrap" bind:this={section}>
    <div class="w-full px-6">
        <div class="skills-header">
            <h2 class="skills-title">Skills</h2>
            <p class="skills-subtitle">A practical full-stack skillset shaped by projects, leadership work, and continuous technical training.</p>
        </div>
    </div>

    <div
        class="skills-cinema mt-8"
        role="region"
        aria-label="Technology carousel"
        onpointermove={handlePointerMove}
        onpointerleave={clearHighlight}
    >
        <div class="skills-stage">
            <div class="skills-track" bind:this={carouselTrack}>
                {#each duplicatedCarouselItems as item, i}
                    <div class="skill-reel-item {highlightedIndex === i ? 'is-highlighted' : ''}" bind:this={carouselItemsRef[i]}>
                        <img src={item.logo} alt={item.name} loading="lazy" class="skill-logo" />
                        <span>{item.name}</span>
                    </div>
                {/each}
            </div>
        </div>
    </div>
</section>

<style>
    .skills-header {
        position: relative;
        margin: 0 auto 2.25rem;
        text-align: center;
    }

    .skills-title {
        position: relative;
        margin: 0;
        font-family: 'DM Sans', sans-serif;
        font-size: clamp(2.2rem, 5.2vw, 4rem);
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--color-text);
    }

    .skills-subtitle {
        margin: 0.9rem auto 0;
        max-width: 52rem;
        font-family: 'DM Sans', sans-serif;
        font-size: clamp(1rem, 1.65vw, 1.45rem);
        font-weight: 400;
        color: var(--color-muted);
    }

    .skills-cinema {
        position: relative;
        width: 100vw;
        margin-left: calc(50% - 50vw);
        overflow: hidden;
        perspective: 1300px;
        padding: 1rem 0 1.3rem;
    }

    .skills-stage {
        transform: rotateX(15deg);
        transform-origin: center top;
    }

    .skills-cinema::before,
    .skills-cinema::after {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 16vw;
        pointer-events: none;
        z-index: 2;
    }

    .skills-cinema::before {
        left: 0;
        background:
            radial-gradient(ellipse 95% 130% at left center, rgba(11, 10, 18, 0.98) 0%, rgba(11, 10, 18, 0.66) 52%, rgba(11, 10, 18, 0) 100%),
            linear-gradient(90deg, rgba(11, 10, 18, 0.95), rgba(11, 10, 18, 0));
    }

    .skills-cinema::after {
        right: 0;
        background:
            radial-gradient(ellipse 95% 130% at right center, rgba(11, 10, 18, 0.98) 0%, rgba(11, 10, 18, 0.66) 52%, rgba(11, 10, 18, 0) 100%),
            linear-gradient(270deg, rgba(11, 10, 18, 0.95), rgba(11, 10, 18, 0));
    }

    .skills-track {
        display: flex;
        width: max-content;
        align-items: center;
        gap: 1.15rem;
        padding: 0 1rem;
        transform-style: preserve-3d;
        will-change: transform;
    }

    .skill-reel-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        gap: 0.56rem;
        min-width: 230px;
        border-radius: 0.95rem;
        border: 1px solid color-mix(in srgb, var(--color-primary) 40%, transparent 60%);
        background: linear-gradient(180deg, rgba(10, 10, 24, 0.9), rgba(10, 10, 24, 0.7));
        padding: 1rem 1.08rem;
        white-space: nowrap;
        font-weight: 700;
        font-size: 1.34rem;
        letter-spacing: 0.02em;
        color: color-mix(in srgb, var(--color-text) 94%, white 6%);
        box-shadow: inset 0 0 10px rgba(99, 102, 241, 0.2), 0 10px 22px rgba(0, 0, 0, 0.35);
        user-select: none;
        transition: border-color 180ms ease, box-shadow 180ms ease, background 180ms ease;
    }

    .skill-reel-item.is-highlighted {
        border-color: color-mix(in srgb, var(--color-warm) 58%, var(--color-primary) 42%);
        background: linear-gradient(180deg, rgba(16, 14, 34, 0.98), rgba(14, 12, 30, 0.92));
        box-shadow:
            inset 0 0 20px rgba(99, 102, 241, 0.32),
            0 12px 24px rgba(0, 0, 0, 0.36),
            0 0 28px rgba(253, 185, 39, 0.24);
    }

    .skill-logo {
        width: 3.55rem;
        height: 3.55rem;
        filter: drop-shadow(0 8px 18px rgba(85, 37, 131, 0.35));
    }

    .skill-reel-item span {
        line-height: 1.12;
    }

    @media (max-width: 768px) {
        .skills-stage {
            transform: rotateX(12deg);
        }

        .skills-track {
            gap: 0.75rem;
        }

        .skill-reel-item {
            min-width: 172px;
            font-size: 1.08rem;
            padding: 0.72rem 0.74rem;
        }

        .skill-logo {
            width: 2.5rem;
            height: 2.5rem;
        }
    }
</style>
