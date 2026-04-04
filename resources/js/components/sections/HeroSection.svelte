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
    let wavePathMain = $state(null);
    let waveTimeline = $state(null);
    let isMegaphoneActive = $state(false);
    let currentVerseIndex = $state(-1);
    let isMobileView = $state(false);

    const bibleVerses = [
        '"Commit to the Lord whatever you do, and he will establish your plans." - Proverbs 16:3',
        '"When the time is right, I, the LORD, will make it happen." - Isaiah 60:22',
        '"I can do all things through Christ who strengthens me" - Philippians 4:13',
        '"Have I not commanded you? Be strong and courageous. Do not be afraid; do not be discouraged, for the LORD your God will be with you wherever you go." - Joshua 1:9',
    ];

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
    const waveTrack = $derived(`${waveTech}${waveTech}${waveTech}`);

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
        if (!namePlane || isMobileView) return;

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

        isMobileView = window.matchMedia('(max-width: 767px)').matches;

        gsap.fromTo(
            heroItems,
            { y: 60, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.9, stagger: 0.15, ease: 'power3.out' }
        );

        if (surname) {
            const surnameCycleMs = isMobileView ? 4200 : 2300;
            const fadeOutDuration = isMobileView ? 0.14 : 0.2;
            const fadeInDuration = isMobileView ? 0.2 : 0.32;

            nameFontInterval = setInterval(() => {
                gsap.to(surname, {
                    opacity: 0.25,
                    y: isMobileView ? 4 : 10,
                    duration: fadeOutDuration,
                    ease: 'power2.in',
                    onComplete: () => {
                        surnameVariantIndex = (surnameVariantIndex + 1) % surnameVariants.length;
                        gsap.fromTo(
                            surname,
                            { opacity: 0.25, y: isMobileView ? -4 : -10 },
                            { opacity: 1, y: 0, duration: fadeInDuration, ease: 'power2.out' }
                        );
                    },
                });
            }, surnameCycleMs);
        }

        if (wavePathMain) {
            gsap.set(wavePathMain, {
                attr: { startOffset: '-68%' },
            });

            waveTimeline = gsap.timeline({ repeat: -1 });

            // Start from merged center, pause 3s.
            waveTimeline.to({}, { duration: 3 });

            // Continue wave for 3s.
            waveTimeline.to(
                wavePathMain,
                {
                    attr: { startOffset: '-88%' },
                    duration: 3,
                    ease: 'sine.inOut',
                },
                'wave'
            );

            // Stop 3s, then reset to merged center for the next cycle.
            waveTimeline.to({}, { duration: 3 });
            waveTimeline.set(wavePathMain, {
                attr: { startOffset: '-68%' },
            });
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
                <div class="wave-layer pointer-events-none absolute left-1/2 top-1/2 -z-10 h-[68vh] w-screen md:w-[140vw] -translate-x-1/2 -translate-y-1/2 overflow-hidden" aria-hidden="true">
                    <svg class="wave-svg" viewBox="0 0 1200 520" preserveAspectRatio="none">
                        <defs>
                            <path id="sea-wave-1" d="M-120 270 C 80 90, 240 450, 470 270 C 710 70, 900 470, 1130 270 C 1290 150, 1400 380, 1560 270" />
                        </defs>

                        <text class="sea-wave-text sea-wave-text-primary sea-wave-main">
                            <textPath href="#sea-wave-1" startOffset="-88%" bind:this={wavePathMain}>{waveTrack}</textPath>
                        </text>
                    </svg>
                </div>

                <div
                    class="megaphone-wrap"
                    bind:this={heroItems[2]}
                    role="group"
                    aria-label="Bible verse message"
                    onmouseenter={() => {
                        isMegaphoneActive = true;
                        currentVerseIndex = (currentVerseIndex + 1) % bibleVerses.length;
                    }}
                    onmouseleave={() => (isMegaphoneActive = false)}
                >
                    <button
                        class="megaphone-trigger"
                        type="button"
                        aria-label="Show shout"
                    >
                        <span class="megaphone-emoji" aria-hidden="true">📣</span>
                    </button>
                    <span class="megaphone-message" class:is-visible={isMegaphoneActive}>{bibleVerses[currentVerseIndex] ?? bibleVerses[0]}</span>
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

    .sea-wave-main {
        opacity: 0.95;
    }

    .megaphone-wrap {
        position: absolute;
        top: -5rem;
        left: 50%;
        transform: translateX(calc(-50% - clamp(1.1rem, 2.2vw, 2rem)));
        margin: 0;
        display: inline-flex;
        align-items: center;
        justify-content: flex-start;
        gap: 0.55rem;
        z-index: 5;
    }

    .megaphone-trigger {
        display: inline-flex;
        height: 3.2rem;
        width: 3.2rem;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        border: 1px solid color-mix(in srgb, var(--color-primary) 65%, transparent);
        background: color-mix(in srgb, var(--color-primary) 26%, transparent);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }

    .megaphone-trigger:hover {
        transform: scale(1.08);
        box-shadow: 0 0 14px color-mix(in srgb, var(--color-primary) 54%, transparent);
    }

    .megaphone-trigger:hover .megaphone-emoji {
        animation: megaphone-shake 0.55s ease-in-out infinite;
    }

    .megaphone-emoji {
        font-size: 1.85rem;
        line-height: 1;
        transform-origin: 70% 30%;
    }

    .megaphone-message {
        position: relative;
        display: block;
        width: min(60vw, 26rem);
        opacity: 0;
        transform: translateX(-0.2rem);
        overflow: visible;
        white-space: normal;
        color: var(--color-warm);
        font-family: var(--font-mono);
        font-size: 0.82rem;
        line-height: 1.45;
        text-align: left;
        font-weight: 700;
        letter-spacing: 0.02em;
        visibility: hidden;
        transition: opacity 0.25s ease, transform 0.25s ease;
        pointer-events: none;
        z-index: 4;
    }

    .megaphone-message.is-visible {
        opacity: 1;
        visibility: visible;
        transform: translateX(0);
        animation: shout-pop 0.45s ease;
    }

    @keyframes megaphone-shake {
        0% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(-8deg);
        }

        50% {
            transform: rotate(7deg);
        }

        75% {
            transform: rotate(-6deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    @keyframes shout-pop {
        0% {
            letter-spacing: 0.02em;
            transform: translateX(-0.2rem) scale(0.92);
        }

        70% {
            letter-spacing: 0.04em;
            transform: translateX(0.03rem) scale(1.05);
        }

        100% {
            letter-spacing: 0.02em;
            transform: translateX(0) scale(1);
        }
    }

    @media (max-width: 767px) {
        #home {
            overflow: visible;
        }

        .wave-layer {
            height: 86vh;
            width: 160vw;
            overflow: visible;
        }

        .wave-svg {
            min-height: 510px;
        }

        .sea-wave-text {
            font-size: 16px;
        }

        .megaphone-wrap {
            top: -5.6rem;
            left: 50%;
            transform: translateX(-50%);
            justify-content: center;
            gap: 0.45rem;
            width: min(92vw, 22rem);
        }

        .megaphone-message {
            width: min(72vw, 14rem);
            font-size: 0.7rem;
            line-height: 1.3;
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
            animation: none;
        }

        .name-tilt {
            padding-top: 2.4rem;
        }
    }
</style>
