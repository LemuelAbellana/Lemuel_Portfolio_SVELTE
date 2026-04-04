<script>
    import { onDestroy, onMount } from 'svelte';
    import { fade } from 'svelte/transition';
    import { revealOnScroll } from '../../lib/gsap';

    let section = $state(null);
    let activeIndex = $state(0);
    let autoSlide = $state(null);
    let trigger = $state(null);
    let profileImageSrc = $state('/assets/images/gomz.jpg');
    let showProfileImage = $state(true);

    const courses = [
        'Database Management',
        'Software Engineering',
        'Web Development',
        'Mobile Development',
        'Systems Analysis & Design',
        'Cloud Computing Fundamentals',
        'AI System Integration',
        'Project Management',
        'Organizational Leadership',
    ];

    const keyAchievements = [
        'DOST-SEI Scholar (2023-2027)',
        'Top 100 Scholars Leadership Camp Region XI',
        'NASA Space Apps Challenge 2025 Participant',
        'DurianPy AI Engineering 2025 Participant',
        'Ignacian Marian Leadership Training Participant',
        'Vice Mayor, GDG on Campus - UIC (2025-2026)',
    ];

    const slides = [
        {
            label: 'Background',
            lead: 'Profile Overview',
            content:
                'I am a Bachelor of Science in Information Technology student at the University of the Immaculate Conception, based in Davao City. My work combines full-stack development, progressive web applications, and AI-assisted systems with leadership experience from GDG on Campus, UIC-VIBE Club, and NSTP-CWTS community initiatives.',
        },
        {
            label: 'Education',
            lead: 'Academic Foundation',
            content:
                'I am pursuing BS Information Technology at the University of the Immaculate Conception. My coursework and project-based training cover software engineering, systems analysis and design, cloud fundamentals, mobile and web development, AI system integration, project management, and organizational leadership.',
            list: courses,
        },
        {
            label: 'Mission & Vision',
            lead: 'Direction',
            content:
                'My mission is to build reliable and user-focused digital solutions that support education, health, research, and community initiatives. My vision is to grow into a professional software engineer who contributes to scalable systems and responsible AI applications in the Philippines.',
        },
        {
            label: 'Goals',
            lead: 'Roadmap',
            content:
                'My short-term goals are to complete my degree, continue producing high-quality portfolio projects, and secure an internship or junior developer role. My long-term goals are to deliver impactful products, strengthen leadership in tech communities, and mentor aspiring developers.',
        },
        {
            label: 'Motivation',
            lead: 'What Drives Me',
            content:
                'I am motivated by projects with measurable social value. Whether through academic systems, student organization initiatives, or civic outreach, I stay focused on building maintainable solutions that improve processes and help real users.',
            list: keyAchievements,
        },
    ];

    const activeSlide = $derived(slides[activeIndex]);

    const goTo = (index) => {
        activeIndex = index;
    };

    const nextSlide = () => {
        activeIndex = (activeIndex + 1) % slides.length;
    };

    const prevSlide = () => {
        activeIndex = (activeIndex - 1 + slides.length) % slides.length;
    };

    const startAutoSlide = () => {
        if (autoSlide) clearInterval(autoSlide);
        autoSlide = setInterval(() => {
            nextSlide();
        }, 3000);
    };

    const stopAutoSlide = () => {
        if (autoSlide) {
            clearInterval(autoSlide);
            autoSlide = null;
        }
    };

    const handleProfileImageError = () => {
        if (profileImageSrc !== '/build/assets/images/gomz.jpg') {
            profileImageSrc = '/build/assets/images/gomz.jpg';
            return;
        }

        showProfileImage = false;
    };

    $effect(() => {
        activeIndex;
    });

    onMount(() => {
        if (!section) return;
        trigger = revealOnScroll(section, section.querySelectorAll('[data-about-item]'));
        startAutoSlide();
    });

    onDestroy(() => {
        if (trigger) trigger.kill();
        stopAutoSlide();
    });
</script>

<section id="about" class="section-wrap relative isolate overflow-hidden pt-10 md:pt-14" bind:this={section}>
    <div class="section-grid-zoom" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto w-full max-w-6xl px-6">
        <div class="mx-auto max-w-3xl text-center" data-about-item>
            <p class="inline-flex rounded-full bg-[var(--color-primary)]/14 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[var(--color-muted)]">
                About Me
            </p>
            <h2 class="mt-4 text-3xl font-bold tracking-tight text-[var(--color-text)] md:text-5xl">PERSONAL AND PROFESSIONAL SNAPSHOT</h2>
            <p class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-[var(--color-muted)] md:text-base">
                Explore my background, education, goals, and motivation through a guided profile carousel.
            </p>
        </div>

        <div class="mt-10" data-about-item>
            <div class="relative isolate overflow-hidden rounded-[2rem] border border-[var(--color-primary)]/25 bg-[color-mix(in_srgb,var(--color-surface)_92%,black)] shadow-[0_24px_60px_rgba(0,0,0,0.25)]" role="region" aria-label="About section carousel" onmouseenter={stopAutoSlide} onmouseleave={startAutoSlide}>
                <div class="relative z-10 grid h-[560px] gap-0 md:h-[620px] lg:h-[560px] lg:grid-cols-[0.95fr_1.35fr]">
                    <div class="min-h-[240px] border-b border-[var(--color-primary)]/20 bg-[var(--color-primary)]/8 md:min-h-[300px] lg:h-full lg:min-h-0 lg:border-b-0 lg:border-r">
                        {#if showProfileImage}
                            <img
                                src={profileImageSrc}
                                alt="Lemuel profile"
                                class="h-full w-full object-cover"
                                onerror={handleProfileImageError}
                            />
                        {:else}
                            <div class="flex h-full items-center justify-center p-6 text-center text-sm text-[var(--color-muted)]">
                                Add gomz.jpg to public/assets/images to display your profile photo.
                            </div>
                        {/if}
                    </div>

                    <div class="flex min-h-0 flex-col p-7 md:p-10 lg:h-full">
                        <div class="about-scroll flex-1 overflow-y-auto pr-2 min-h-0">
                            {#key activeIndex}
                                <div class="min-h-[160px] md:min-h-[230px]" in:fade={{ duration: 260 }} out:fade={{ duration: 180 }}>
                                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[var(--color-muted)]">{activeSlide.lead}</p>
                                    <h3 class="mt-3 text-3xl font-extrabold text-[var(--color-warm)] md:text-5xl">{activeSlide.label}</h3>
                                    <p class="mt-4 max-w-2xl text-base leading-relaxed text-[var(--color-muted)]">{activeSlide.content}</p>

                                    {#if activeSlide.list}
                                        <div class="mt-6">
                                            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.2em] text-[var(--color-muted)]">Highlights</p>
                                            <ul class="grid gap-2 text-sm text-[var(--color-text)]/92 md:grid-cols-2">
                                                {#each activeSlide.list as item}
                                                    <li class="flex min-h-[44px] items-center rounded-lg border border-[var(--color-primary)]/24 bg-[var(--color-bg)]/30 px-3 py-2">{item}</li>
                                                {/each}
                                            </ul>
                                        </div>
                                    {/if}
                                </div>
                            {/key}
                        </div>
                    </div>
                </div>

                <div class="relative z-10 flex items-center justify-center gap-4 border-t border-[var(--color-primary)]/20 bg-[var(--color-bg)]/18 px-6 py-5">
                    <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[var(--color-warm)]/65 text-lg text-[var(--color-warm)] transition hover:bg-[var(--color-warm)]/12" onclick={prevSlide} aria-label="Previous slide">
                        &#8249;
                    </button>

                    <div class="flex items-center gap-2">
                        {#each slides as _, i}
                            <button
                                type="button"
                                class={`h-2.5 rounded-full transition ${activeIndex === i ? 'w-6 bg-[var(--color-warm)]' : 'w-2.5 bg-[var(--color-warm)]/35 hover:bg-[var(--color-warm)]/55'}`}
                                onclick={() => goTo(i)}
                                aria-label={`Go to slide ${i + 1}`}
                            ></button>
                        {/each}
                    </div>

                    <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[var(--color-warm)]/65 text-lg text-[var(--color-warm)] transition hover:bg-[var(--color-warm)]/12" onclick={nextSlide} aria-label="Next slide">
                        &#8250;
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .about-scroll {
        scrollbar-width: thin;
        scrollbar-color: color-mix(in srgb, var(--color-warm) 85%, transparent) transparent;
    }

    .about-scroll::-webkit-scrollbar {
        width: 10px;
    }

    .about-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .about-scroll::-webkit-scrollbar-thumb {
        background: color-mix(in srgb, var(--color-warm) 80%, transparent);
        border-radius: 999px;
        border: 2px solid transparent;
        background-clip: content-box;
    }

    .about-scroll::-webkit-scrollbar-thumb:hover {
        background: color-mix(in srgb, var(--color-warm) 100%, transparent);
        background-clip: content-box;
    }
</style>
