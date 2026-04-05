<script>
    import { onDestroy, onMount } from 'svelte';
    import { gsap } from '../../lib/gsap';

    let section = $state(null);
    let carouselTrack = $state(null);
    let carouselItemsRef = $state([]);
    let scrollTween = $state(null);
    let highlightedIndex = $state(-1);
    let isMobileView = $state(false);

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
        { name: 'Docker', logo: 'https://skillicons.dev/icons?i=docker' },
        { name: 'NodeJS', logo: 'https://skillicons.dev/icons?i=nodejs' },
        { name: 'MongoDB', logo: 'https://skillicons.dev/icons?i=mongodb' },
    ];

    const technicalSkills = [
        { name: 'AI and AI Integrated System', value: 75 },
        { name: 'Web Development', value: 80 },
        { name: 'Database Management', value: 80 },
        { name: 'Mobile Development', value: 50 },
        { name: 'Cybersecurity', value: 50 },
    ];

    const softSkills = [
        { name: 'Communication', value: 90 },
        { name: 'Leadership', value: 90 },
        { name: 'Problem Solving', value: 85 },
        { name: 'Teamwork', value: 85 },
        { name: 'Adaptability', value: 85 },
    ];

    const duplicatedCarouselItems = [...carouselItems, ...carouselItems];

    const applyCinemaCurve = () => {
        if (isMobileView) {
            for (const item of carouselItemsRef) {
                if (!item) continue;

                gsap.set(item, {
                    y: 0,
                    rotateY: 0,
                    scale: 1,
                    opacity: 1,
                });
            }

            return;
        }

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

        const syncViewport = () => {
            isMobileView = window.innerWidth <= 768;
            if (scrollTween) {
                scrollTween.duration(isMobileView ? 28 : 22);
            }
            applyCinemaCurve();
        };

        syncViewport();

        applyCinemaCurve();
        scrollTween = gsap.to(carouselTrack, {
            xPercent: -50,
            duration: isMobileView ? 28 : 22,
            repeat: -1,
            ease: 'none',
            onUpdate: () => {
                if (!isMobileView) {
                    applyCinemaCurve();
                }
            },
        });

        window.addEventListener('resize', syncViewport);

        return () => {
            window.removeEventListener('resize', syncViewport);
        };
    });

    onDestroy(() => {
        scrollTween?.kill();
    });

    const handlePointerMove = (event) => {
        if (isMobileView) return;
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

<section id="skills" class="section-wrap relative isolate overflow-hidden" bind:this={section}>
    <div class="section-grid-zoom" aria-hidden="true"></div>

    <div class="relative z-10 w-full px-6">
        <div class="skills-header">
            <h2 class="skills-title">SKILLS</h2>
            <p class="skills-subtitle">A Practical Full-Stack Skillset Shaped by Projects, Leadership Work, and Continuous Technical Training.</p>
        </div>
    </div>

    <div
        class="skills-cinema relative z-10 mt-8"
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

    <div class="skills-progress-wrap relative z-10">
        <div class="skills-progress-grid">
            <article class="skills-progress-card" aria-label="Technical skills">
                <h3>Technical Skills</h3>
                {#each technicalSkills as skill}
                    <div class="skill-progress-row">
                        <div class="skill-progress-head">
                            <span>{skill.name}</span>
                            <strong>{skill.value}%</strong>
                        </div>
                        <div class="skill-progress-track" aria-hidden="true">
                            <span class="skill-progress-fill" style={`width: ${skill.value}%`}></span>
                        </div>
                    </div>
                {/each}
            </article>

            <article class="skills-progress-card" aria-label="Soft skills">
                <h3>Soft Skills</h3>
                {#each softSkills as skill}
                    <div class="skill-progress-row">
                        <div class="skill-progress-head">
                            <span>{skill.name}</span>
                            <strong>{skill.value}%</strong>
                        </div>
                        <div class="skill-progress-track" aria-hidden="true">
                            <span class="skill-progress-fill" style={`width: ${skill.value}%`}></span>
                        </div>
                    </div>
                {/each}
            </article>
        </div>

        <p class="skills-progress-note">
            These Ratings Guide Me in Identifying Opportunities for Improvement while Fostering a Mindset of Continuous Learning and Ongoing Professional Development.
        </p>
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
        width: 12vw;
        pointer-events: none;
        z-index: 2;
    }

    .skills-cinema::before {
        left: 0;
        background:
            radial-gradient(ellipse 95% 130% at left center, rgba(85, 37, 131, 0.44) 0%, rgba(85, 37, 131, 0.2) 52%, rgba(85, 37, 131, 0) 100%),
            linear-gradient(90deg, rgba(85, 37, 131, 0.36), rgba(85, 37, 131, 0));
    }

    .skills-cinema::after {
        right: 0;
        background:
            radial-gradient(ellipse 95% 130% at right center, rgba(85, 37, 131, 0.44) 0%, rgba(85, 37, 131, 0.2) 52%, rgba(85, 37, 131, 0) 100%),
            linear-gradient(270deg, rgba(85, 37, 131, 0.36), rgba(85, 37, 131, 0));
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

    .skills-progress-wrap {
        max-width: 1200px;
        margin: 2.4rem auto 0;
        padding: 0 1rem;
    }

    .skills-progress-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.1rem;
    }

    .skills-progress-card {
        border-radius: 1rem;
        border: 1px solid color-mix(in srgb, var(--color-primary) 48%, transparent 52%);
        background:
            radial-gradient(circle at 14% 12%, rgba(130, 87, 229, 0.2), transparent 46%),
            linear-gradient(180deg, rgba(12, 10, 28, 0.95), rgba(10, 9, 22, 0.86));
        padding: 1.25rem;
        box-shadow: inset 0 0 16px rgba(85, 37, 131, 0.18), 0 10px 26px rgba(0, 0, 0, 0.35);
    }

    .skills-progress-card h3 {
        margin: 0 0 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: clamp(1.15rem, 2.1vw, 1.55rem);
        letter-spacing: 0.01em;
        color: var(--color-warm);
        text-shadow: 0 0 18px rgba(253, 185, 39, 0.18);
    }

    .skill-progress-row + .skill-progress-row {
        margin-top: 0.86rem;
    }

    .skill-progress-head {
        display: flex;
        justify-content: space-between;
        gap: 0.9rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.99rem;
        color: color-mix(in srgb, var(--color-text) 92%, var(--color-muted) 8%);
        margin-bottom: 0.44rem;
    }

    .skill-progress-head strong {
        color: #c7a9ff;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .skill-progress-track {
        position: relative;
        height: 0.5rem;
        border-radius: 999px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.1);
    }

    .skill-progress-fill {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #7e3af2 0%, #9f67ff 55%, #c6a8ff 100%);
        box-shadow: 0 0 16px rgba(159, 103, 255, 0.52);
    }

    .skills-progress-note {
        margin: 1.2rem auto 0;
        max-width: 72ch;
        text-align: center;
        font-family: 'DM Sans', sans-serif;
        font-size: clamp(0.95rem, 1.45vw, 1.08rem);
        color: color-mix(in srgb, var(--color-muted) 74%, #d7c2ff 26%);
    }

    @media (max-width: 768px) {
        .skills-cinema::before,
        .skills-cinema::after {
            width: 9vw;
        }

        .skills-stage {
            transform: none;
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

        .skills-progress-wrap {
            margin-top: 1.6rem;
            padding: 0 0.3rem;
        }

        .skills-progress-grid {
            grid-template-columns: 1fr;
            gap: 0.85rem;
        }

        .skills-progress-card {
            padding: 1rem;
        }

        .skill-progress-head {
            font-size: 0.93rem;
        }

        .skill-progress-track {
            height: 0.48rem;
        }

        .skills-progress-note {
            margin-top: 1rem;
            font-size: 0.92rem;
        }
    }
</style>
