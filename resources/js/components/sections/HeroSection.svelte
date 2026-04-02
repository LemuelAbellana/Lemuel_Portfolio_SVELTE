<script>
    import { onDestroy, onMount } from 'svelte';
    import { gsap } from '../../lib/gsap';

    let { profile } = $props();
    const displayName = $derived(profile.name);
    const profileTitle = $derived(profile.title ?? 'Full-Stack Developer');
    const profileTagline = $derived(profile.tagline ?? 'Building elegant digital solutions from Davao City');
    let container = $state(null);
    let heroItems = $state([]);

    const badges = [
        { label: 'HTML', cls: 'left-2 top-6' },
        { label: 'PHP', cls: 'right-6 top-10' },
        { label: 'Laravel', cls: 'left-5 bottom-20' },
        { label: 'Svelte', cls: 'right-8 bottom-24' },
        { label: 'React', cls: 'right-2 top-1/2' },
    ];

    $effect(() => {
        displayName;
        profileTitle;
        profileTagline;
    });

    onMount(() => {
        if (!container) return;

        gsap.fromTo(
            heroItems,
            { y: 60, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.9, stagger: 0.15, ease: 'power3.out' }
        );

        container.querySelectorAll('.floating-badge').forEach((badge, idx) => {
            gsap.to(badge, {
                y: idx % 2 === 0 ? 8 : -8,
                duration: 2 + idx * 0.3,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut',
                delay: idx * 0.2,
            });
        });
    });

    onDestroy(() => {
        if (container) {
            gsap.killTweensOf(container.querySelectorAll('*'));
        }
    });
</script>

<section id="home" class="relative overflow-hidden pt-28 pb-14 md:pb-20" bind:this={container}>
    <div class="pointer-events-none absolute inset-0 opacity-10" style="background-image: linear-gradient(135deg, rgba(148, 163, 184, 0.25) 1px, transparent 1px); background-size: 28px 28px;"></div>
    <div class="pointer-events-none absolute right-[12%] top-[20%] h-72 w-72 rounded-full bg-[var(--color-primary)]/20 blur-3xl"></div>

    <div class="relative mx-auto grid w-full max-w-6xl grid-cols-1 items-center gap-12 px-6 pb-16 md:grid-cols-5">
        <div class="md:col-span-3">
            <p class="mb-5 font-mono text-sm text-[var(--color-primary)]" bind:this={heroItems[0]}>&lt; {profileTitle} /&gt;</p>
            <h1 class="font-display leading-[0.95] text-[clamp(3rem,8vw,7rem)]" bind:this={heroItems[1]}>{displayName}</h1>
            <p class="mt-6 max-w-xl text-lg text-[var(--color-muted)]" bind:this={heroItems[2]}>{profileTagline}</p>

            <div class="mt-8 flex flex-wrap gap-4" bind:this={heroItems[3]}>
                <a href="#projects" class="rounded-full bg-[var(--color-primary)] px-6 py-3 text-sm font-semibold text-white">View Projects</a>
                <a href="/resume.pdf" download class="rounded-full border border-[var(--color-primary)] px-6 py-3 text-sm font-semibold text-[var(--color-text)]">Download Resume</a>
                <a href="#contact" class="rounded-full border border-[var(--color-primary)] px-6 py-3 text-sm font-semibold text-[var(--color-text)]">Contact Me</a>
            </div>

            <div class="mt-10 flex flex-wrap gap-6 text-sm text-[var(--color-muted)]" bind:this={heroItems[4]}>
                <span><strong class="text-[var(--color-text)]">13</strong> Projects</span>
                <span><strong class="text-[var(--color-text)]">3</strong> Leadership Roles</span>
                <span><strong class="text-[var(--color-text)]">4+</strong> Major Affiliations</span>
            </div>
        </div>

        <div class="relative md:col-span-2" bind:this={heroItems[5]}>
            {#if profile.photo}
                <img src={profile.photo} alt={`${displayName} professional portrait`} class="mx-auto h-80 w-72 rounded-[2rem] object-cover shadow-2xl" />
            {:else}
                <div
                    class="mx-auto flex h-80 w-72 flex-col items-center justify-center rounded-3xl border border-[var(--color-primary)]/30 text-white shadow-2xl"
                    style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.6), var(--color-surface));"
                >
                    <span class="text-6xl font-display">LGA</span>
                    <span class="mt-2 text-xs uppercase tracking-widest text-white/80">Photo Placeholder</span>
                </div>
            {/if}

            {#each badges as badge}
                <span class={`floating-badge absolute ${badge.cls} rounded-full border border-[var(--color-primary)]/40 bg-[var(--color-surface)] px-3 py-1 text-xs font-mono`}>
                    {badge.label}
                </span>
            {/each}
        </div>
    </div>
</section>
