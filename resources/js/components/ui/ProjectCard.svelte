<script>
    import { onMount } from 'svelte';
    import { ArrowUpRight } from 'lucide-svelte';
    import { gsap } from '../../lib/gsap';

    let { index = 1, name = '', description = '', tags = [], role = '', features = [], outcome = '' } = $props();

    let card = $state(null);
    let imageVariant = $state(0);
    let imageMissing = $state(false);
    const cardTitle = $derived(name);
    const imageCandidates = $derived.by(() => {
        const slug = name
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');

        if (!slug) return [];
        return [`/assets/images/projects/${slug}.webp`, `/assets/images/projects/${slug}.jpg`, `/assets/images/projects/${slug}.png`];
    });

    const imageSrc = $derived.by(() => {
        if (imageMissing || imageCandidates.length === 0) return null;
        return imageCandidates[imageVariant] ?? null;
    });

    const onMove = (event) => {
        if (!card) return;
        const rect = card.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        const rotateY = ((x / rect.width) - 0.5) * 16;
        const rotateX = ((y / rect.height) - 0.5) * -16;

        gsap.to(card, {
            rotateX,
            rotateY,
            transformPerspective: 900,
            transformOrigin: 'center',
            duration: 0.25,
            ease: 'power2.out',
        });
    };

    const onLeave = () => {
        if (!card) return;
        gsap.to(card, { rotateX: 0, rotateY: 0, duration: 0.45, ease: 'power3.out' });
    };

    const onImageError = () => {
        if (imageVariant < imageCandidates.length - 1) {
            imageVariant += 1;
            return;
        }

        imageMissing = true;
    };

    $effect(() => {
        cardTitle;
        imageVariant = 0;
        imageMissing = false;
    });

    onMount(() => {
        return () => {
            if (card) gsap.killTweensOf(card);
        };
    });
</script>

<article
    bind:this={card}
    onmousemove={onMove}
    onmouseleave={onLeave}
    role="region"
    aria-label={`Project ${index}: ${cardTitle}`}
    class="project-card relative flex h-full flex-col rounded-2xl border border-[var(--color-primary)]/45 bg-[color-mix(in_srgb,var(--color-surface)_92%,black)] p-6 shadow-[0_12px_38px_rgba(0,0,0,0.35)]"
>
    <span class="font-display absolute right-4 top-2 text-7xl text-white/5">{String(index).padStart(2, '0')}</span>
    <ArrowUpRight class="absolute right-4 top-4 h-5 w-5 text-[var(--color-muted)]" aria-hidden="true" />
    <h3 class="relative mb-1 min-h-[5rem] pr-8 text-[clamp(1.25rem,1.5vw,1.85rem)] font-bold leading-tight text-[var(--color-text)] md:min-h-[5.5rem]">{cardTitle}</h3>
    <p class="relative mb-2 min-h-[4.5rem] text-[clamp(0.85rem,0.95vw,1.1rem)] leading-snug text-[var(--color-muted)] md:min-h-[5rem]">{description}</p>

    <div class="relative mb-4 overflow-hidden rounded-xl border border-[var(--color-primary)]/40 bg-[var(--color-bg)]/70 aspect-[16/10]">
        {#if imageSrc}
            <img
                src={imageSrc}
                alt={`${cardTitle} project preview`}
                class="h-full w-full object-cover"
                loading="lazy"
                onerror={onImageError}
            />
        {:else}
            <div class="flex h-full w-full items-center justify-center bg-[radial-gradient(circle_at_20%_10%,rgba(85,37,131,0.28),transparent_52%),linear-gradient(180deg,rgba(9,9,18,0.72),rgba(8,8,15,0.92))] px-4 text-center text-sm font-semibold text-[var(--color-muted)]">
                Image will appear here once uploaded to /assets/images/projects
            </div>
        {/if}
    </div>

    <div class="relative mt-auto flex flex-wrap gap-2">
        {#each tags as tag}
            <span class="rounded-full border border-[var(--color-primary)]/65 bg-[var(--color-primary)]/12 px-2.5 py-1 text-xs font-semibold text-[var(--color-text)]">
                {tag}
            </span>
        {/each}
    </div>
</article>
