<script>
    import { onDestroy, onMount } from 'svelte';
    import SectionTitle from '../ui/SectionTitle.svelte';
    import { revealOnScroll } from '../../lib/gsap';

    let section = $state(null);
    let activeIndex = $state(0);
    let autoSlide = $state(null);
    let trigger = $state(null);

    const courses = [
        'Database Management',
        'Software Engineering',
        'Web Development',
        'Mobile Development',
        'Systems Analysis & Design',
        'Cloud Computing',
        'AI System Integration',
        'Project Management',
        'Organizational Leadership',
    ];

    const keyAchievements = [
        'DOST-SEI Scholar (2023-2027)',
        'Top 100 Scholars Leadership Camp Region XI',
        'Vice Mayor, GDG on Campus - UIC (2025-2026)',
    ];

    const slides = [
        {
            label: 'Background',
            content:
                'I am a passionate BS Information Technology student based in Davao City who combines technical development skills with student leadership. From learning core systems and development foundations, I steadily grew into building full-stack applications while serving communities through GDG on Campus, VIBE Club, and NSTP-CWTS initiatives.',
        },
        {
            label: 'Education',
            content:
                'I am pursuing a BS Information Technology degree at the University of the Immaculate Conception in Davao City. My coursework has grounded me in both software engineering practices and practical implementation across web, mobile, cloud, and AI-assisted systems.',
            list: courses,
        },
        {
            label: 'Mission & Vision',
            content:
                'My mission is to craft reliable, elegant digital systems that empower communities. My vision is to grow into a senior engineering role within the Philippine tech ecosystem, contributing to scalable platforms and AI-powered tools.',
        },
        {
            label: 'Goals',
            content:
                'My short-term goal is to graduate with honors and secure a junior developer role. My long-term goal is to build impactful software products and mentor the next generation of Filipino developers.',
        },
        {
            label: 'Motivation',
            content:
                'I am motivated by projects that combine technical depth with social value. Seeing students, organizations, or local communities benefit from software solutions keeps me focused on delivering practical and maintainable systems.',
            list: keyAchievements,
        },
    ];

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
        }, 4500);
    };

    const stopAutoSlide = () => {
        if (autoSlide) {
            clearInterval(autoSlide);
            autoSlide = null;
        }
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

<section id="about" class="section-wrap" bind:this={section}>
    <div class="mx-auto grid w-full max-w-6xl gap-10 px-6 lg:grid-cols-5">
        <div class="lg:col-span-2" data-about-item>
            <SectionTitle number="01" title="About Me" subtitle="My background, training, purpose, and long-term direction as a full-stack developer." />
        </div>

        <div class="lg:col-span-3" data-about-item>
            <div class="space-y-6" role="region" aria-label="About section carousel" onmouseenter={stopAutoSlide} onmouseleave={startAutoSlide}>
                <div class="grid grid-cols-2 gap-2 rounded-2xl border border-[var(--color-primary)]/30 bg-[var(--color-surface)] p-2 md:grid-cols-5">
                    {#each slides as slide, i}
                        <button
                            type="button"
                            class={`rounded-xl px-3 py-2 text-sm transition ${activeIndex === i ? 'bg-[var(--color-primary)]/20 text-white' : 'text-[var(--color-text)]/85'}`}
                            onclick={() => goTo(i)}
                        >
                            {slide.label}
                        </button>
                    {/each}
                </div>

                <div class="rounded-2xl border border-[var(--color-primary)]/30 bg-[var(--color-surface)] p-6">
                    <div class="mb-5 flex items-center justify-between">
                        <p class="text-sm font-semibold text-[var(--color-warm)]">{slides[activeIndex].label}</p>
                        <div class="flex items-center gap-2">
                            <button type="button" class="rounded-full border border-[var(--color-primary)]/40 px-3 py-1 text-xs" onclick={prevSlide}>Prev</button>
                            <button type="button" class="rounded-full border border-[var(--color-primary)]/40 px-3 py-1 text-xs" onclick={nextSlide}>Next</button>
                        </div>
                    </div>

                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-500" style={`transform: translateX(-${activeIndex * 100}%);`}>
                            {#each slides as slide}
                                <article class="w-full shrink-0 space-y-4">
                                    <p class="text-[var(--color-muted)]">{slide.content}</p>
                                    {#if slide.list}
                                        <ul class="grid gap-2 text-sm text-[var(--color-text)]/90 md:grid-cols-2">
                                            {#each slide.list as item}
                                                <li class="rounded-lg border border-[var(--color-primary)]/20 px-3 py-2">{item}</li>
                                            {/each}
                                        </ul>
                                    {/if}
                                </article>
                            {/each}
                        </div>
                    </div>

                    <div class="mt-5 flex items-center justify-center gap-2">
                        {#each slides as _, i}
                            <button
                                type="button"
                                class={`h-2.5 rounded-full transition ${activeIndex === i ? 'w-6 bg-[var(--color-warm)]' : 'w-2.5 bg-[var(--color-primary)]/45'}`}
                                onclick={() => goTo(i)}
                                aria-label={`Go to slide ${i + 1}`}
                            ></button>
                        {/each}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
