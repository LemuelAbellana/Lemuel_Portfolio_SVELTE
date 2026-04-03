<script>
    import { onDestroy, onMount } from 'svelte';
    import { gsap } from '../../lib/gsap';

    let { profile } = $props();
    const displayName = $derived(profile.name);
    const profileTagline = $derived(profile.tagline ?? 'Building elegant digital solutions from Davao City');
    const firstName = $derived((displayName ?? 'Lemuel').split(' ')[0]);
    const firstNameUpper = $derived(firstName.toUpperCase());
    const firstNameLetters = $derived(firstNameUpper.split(''));
    const lastName = $derived((displayName ?? 'Abellana').trim().split(/\s+/).slice(-1)[0]);
    let container = $state(null);
    let heroItems = $state([]);
    let activeLetterIndex = $state(-1);
    let surnameVariantIndex = $state(0);
    let surname = $state(null);
    let namePlane = $state(null);
    let nameFontInterval = $state(null);
    let wavePathLeft = $state(null);
    let wavePathRight = $state(null);
    let waveTimeline = $state(null);

    const letterIcons = ['<>', '{}', '::', '[]', '/*', '*/'];

    const surnameVariants = $derived([
        { text: lastName, font: '"Segoe Script", "Lucida Handwriting", cursive' },
        { text: '阿贝拉纳', font: '"Microsoft YaHei", "Noto Sans SC", sans-serif' },
        { text: 'アベラナ', font: '"Yu Gothic", "Noto Sans JP", sans-serif' },
        { text: 'أبيلانا', font: '"Noto Naskh Arabic", "Segoe UI", serif' },
        { text: '아벨라나', font: '"Malgun Gothic", "Noto Sans KR", sans-serif' },
    ]);

    const waveTech =
        'Programming Languages — JavaScript — PHP — HTML — CSS — TypeScript — Python — Frameworks — Laravel — Svelte — React — Inertia — PHP — MySQL — Flutter — Livewire — Laravel — REST API — GitHub — Docker — NPM — ';

    $effect(() => {
        displayName;
        profileTagline;
        firstName;
        firstNameUpper;
        firstNameLetters.length;
        lastName;
        surnameVariants.length;
        letterIcons.length;
    });

    const onNameMove = (event) => {
        if (!namePlane) return;

        const rect = namePlane.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        const rotateY = ((x / rect.width) - 0.5) * 22;
        const rotateX = ((y / rect.height) - 0.5) * -18;

        gsap.to(namePlane, {
            rotateX,
            rotateY,
            transformPerspective: 1200,
            transformOrigin: 'center',
            duration: 0.18,
            ease: 'power2.out',
        });
    };

    const onNameLeave = () => {
        if (!namePlane) return;

        gsap.to(namePlane, {
            rotateX: 0,
            rotateY: 0,
            duration: 0.45,
            ease: 'power3.out',
        });
    };

    onMount(() => {
        if (!container) return;

        gsap.fromTo(
            heroItems,
            { y: 60, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.9, stagger: 0.15, ease: 'power3.out' }
        );

        if (surname) {
            nameFontInterval = setInterval(() => {
                gsap.to(surname, {
                    opacity: 0.25,
                    y: 10,
                    duration: 0.2,
                    ease: 'power2.in',
                    onComplete: () => {
                        surnameVariantIndex = (surnameVariantIndex + 1) % surnameVariants.length;
                        gsap.fromTo(
                            surname,
                            { opacity: 0.25, y: -10 },
                            { opacity: 1, y: 0, duration: 0.32, ease: 'power2.out' }
                        );
                    },
                });
            }, 2300);
        }

        if (wavePathLeft && wavePathRight) {
            waveTimeline = gsap.timeline();
            // Single continuous convergence avoids pause/re-merge artifacts.
            waveTimeline.to(
                wavePathLeft,
                {
                    attr: { startOffset: '-68%' },
                    duration: 8,
                        ease: 'sine.inOut',
                },
                0
            );

            waveTimeline.to(
                wavePathRight,
                {
                    attr: { startOffset: '-68%' },
                    duration: 8,
                        ease: 'sine.inOut',
                },
                0
            );
        }
    });

    onDestroy(() => {
        if (nameFontInterval) clearInterval(nameFontInterval);
        if (waveTimeline) waveTimeline.kill();
        if (container) {
            gsap.killTweensOf(container.querySelectorAll('*'));
        }
    });
</script>

<section id="home" class="relative flex min-h-screen items-center overflow-hidden pt-20 pb-12 md:pt-24 md:pb-16" bind:this={container}>
    <div class="hero-grid pointer-events-none absolute inset-0"></div>
    <div class="pointer-events-none absolute right-[12%] top-[20%] h-72 w-72 rounded-full bg-[var(--color-primary)]/20 blur-3xl"></div>

    <div class="relative mx-auto flex w-full max-w-6xl items-center justify-center px-6">
        <div class="w-full text-center">
            <div
                class="relative mb-3"
                bind:this={heroItems[0]}
                onmousemove={onNameMove}
                onmouseleave={onNameLeave}
                role="presentation"
            >
                <div class="wave-layer pointer-events-none absolute left-1/2 top-1/2 -z-10 h-[68vh] w-[140vw] -translate-x-1/2 -translate-y-1/2 overflow-hidden" aria-hidden="true">
                    <svg class="wave-svg" viewBox="0 0 1200 520" preserveAspectRatio="none">
                        <defs>
                            <path id="sea-wave-1" d="M-120 270 C 80 90, 240 450, 470 270 C 710 70, 900 470, 1130 270 C 1290 150, 1400 380, 1560 270" />
                            <clipPath id="wave-left-cut">
                                <rect x="0" y="0" width="610" height="520" />
                            </clipPath>
                            <clipPath id="wave-right-cut">
                                <rect x="590" y="0" width="610" height="520" />
                            </clipPath>
                        </defs>

                        <text class="sea-wave-text sea-wave-text-primary sea-wave-text-left" clip-path="url(#wave-left-cut)">
                            <textPath href="#sea-wave-1" startOffset="-88%" bind:this={wavePathLeft}>{waveTech}</textPath>
                        </text>

                        <text class="sea-wave-text sea-wave-text-primary sea-wave-text-right" clip-path="url(#wave-right-cut)">
                            <textPath href="#sea-wave-1" startOffset="-88%" bind:this={wavePathRight}>{waveTech}</textPath>
                        </text>
                    </svg>
                </div>

                <h1 class="name-tilt font-display leading-[0.92] text-[clamp(3.7rem,11vw,9rem)]" bind:this={namePlane}>
                    <span class="name-primary block" aria-label={firstNameUpper}>
                        {#each firstNameLetters as letter, idx}
                            <span
                                class="name-letter"
                                class:is-active={activeLetterIndex === idx}
                                onmouseenter={() => (activeLetterIndex = idx)}
                                onmouseleave={() => (activeLetterIndex = -1)}
                                role="button"
                                tabindex="0"
                                data-icon={letterIcons[idx % letterIcons.length]}
                            >
                                {letter}
                            </span>
                        {/each}
                    </span>
                    <span class="block text-[clamp(3.8rem,11.2vw,9.2rem)] text-white/75" bind:this={surname} style={`font-family: ${surnameVariants[surnameVariantIndex].font};`}>
                        {surnameVariants[surnameVariantIndex].text}
                    </span>
                </h1>
            </div>

            <p class="mx-auto mt-6 max-w-2xl text-lg text-[var(--color-muted)]" bind:this={heroItems[1]}>{profileTagline}</p>
        </div>
    </div>
</section>

<style>
    .hero-grid {
        opacity: 0.16;
        background-image:
            linear-gradient(rgba(148, 163, 184, 0.25) 1px, transparent 1px),
            linear-gradient(90deg, rgba(148, 163, 184, 0.25) 1px, transparent 1px);
        background-size: 46px 46px;
    }

    .name-tilt {
        transform-style: preserve-3d;
        will-change: transform;
    }

    .name-primary {
        font-family: var(--font-sans);
        font-weight: 800;
        letter-spacing: 0.06em;
    }

    .name-letter {
        position: relative;
        display: inline-block;
        transition: color 0.2s ease, transform 0.2s ease, text-shadow 0.2s ease;
        padding: 0 0.02em;
    }

    .name-letter::after {
        content: attr(data-icon);
        position: absolute;
        left: 50%;
        top: -0.82em;
        transform: translateX(-50%) scale(0.7);
        opacity: 0;
        font-family: var(--font-mono);
        font-size: 0.2em;
        color: var(--color-warm);
        transition: opacity 0.2s ease, transform 0.2s ease;
        pointer-events: none;
    }

    .name-letter.is-active {
        color: var(--color-warm);
        transform: translateY(-0.03em) scale(1.06);
        text-shadow: 0 0 12px color-mix(in srgb, var(--color-warm) 48%, transparent);
    }

    .name-letter.is-active::after {
        opacity: 1;
        transform: translateX(-50%) translateY(-0.08em) scale(1);
    }

    .wave-layer {
        opacity: 0.28;
    }

    .wave-svg {
        width: 100%;
        height: 100%;
        min-height: 460px;
    }

    .sea-wave-text {
        font-family: var(--font-mono);
        font-size: 23px;
        letter-spacing: 0.02em;
        fill: color-mix(in srgb, var(--color-muted) 54%, transparent);
    }

    .sea-wave-text-primary {
        fill: color-mix(in srgb, var(--color-muted) 52%, transparent);
    }

    .sea-wave-text-left {
        opacity: 0.95;
    }

    .sea-wave-text-right {
        opacity: 0.95;
    }

    @media (max-width: 767px) {
        .wave-svg {
            min-height: 360px;
        }

        .sea-wave-text {
            font-size: 17px;
        }
    }
</style>
